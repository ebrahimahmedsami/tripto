<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Member;
use App\Models\MemberService;
use App\Models\Message;
use App\Models\Organization;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WhatsappController extends Controller
{
    private const WHATSAPP_SEND_API = 'https://ifmibot.com/api/send.php';
    protected $contactName;
    protected $contactNumber;
    protected $organization;
    protected $member_id = null;

    /**webHook
     *
     * @param Request $request
     */
    public function webHook(Request $request){
       // dd($request->all());
        $message = '';
        $organization = Organization::with('branches.departments.services')->where('instance_id', $request->instance_id)->first();

        if($organization->exists()){
            $this->organization = $organization;
          //  dd($request->event);
            if($request->event = 'message'){
                $messages = $request['data']['messages'][0];
                $this->createMessage($messages['key']['id'], $messages['message']['conversation'], $request['data']['type'], 1, $messages['key']['remoteJid']);
                if(!$messages['key']['fromMe']){
                    //Log::info(json_encode($request->all()));
                    Storage::put('tt.txt' , json_encode($request->all()));
                    $this->contactNumber = explode('@',$messages['key']['remoteJid'])[0];
                    $this->contactName = $messages['pushName'];
                    $this->member_id = $this->createMember();
                    $conversation = $messages['message']['conversation'];
                    //dd($conversation);
                    // contains an underscore and is two words
                    if ( preg_match('/^[a-z]+_[0-9]+$/i', $conversation) ) {
                        $splitText = explode('_', $conversation);
                        $reservedId = $splitText[1];
                        $reservedStep = reservationKeyWords($splitText[0]);
                        if($reservedStep){
                            $message = $this->makeReservation($reservedStep, $reservedId);
                        }else{
                            $message = $this->organization->error_msg;
                        }
                    } else {
                        // does not contain two words, or an underscore so send Welcome Message
                        $message = str_replace("{member_name}", $this->contactName , $organization->welcome_msg) . "\r\n\r\nHere's our branches to get started:\r\n";
                        foreach ($organization->branches as $branch)
                            $message .="- {$branch->name}: ( BYKL_{$branch->id} )\r\n";
                        $message .= "\r\nTo get started please respond with the {branch} code like (BYKL_15)";
                    }
                    $this->sendMessage('text',$message);
                }
            }

        }

    }

    /**makeReservation step by step
     *
     * @param $reservedStep
     * @param $reservedId
     * @return array|string[]
     */
    private function makeReservation($reservedStep, $reservedId){
        switch ($reservedStep){
            case 'branch':
                $message = $this->getDepartmentMessages($reservedId);
                break;
            case 'department':
                $message = $this->getServicesMessages($reservedId);
                break;
            case 'service':
                $message = $this->addMemberToService($reservedId);
                break;
        }
        return $message;
    }

    /**get Department Messages
     *
     * @param $reservedId
     * @return string[]
     */
    private function getDepartmentMessages($reservedId){
        $departments = Department::where(['branch_id' => $reservedId, 'status' =>1])->get();
        if($departments->count() > 0){
            $message = $this->organization->department_msg."\r\n\r\n";
            foreach ($departments as $department)
                $message .="- {$department->name}: ( DXLE_{$department->id} )\r\n";
            $message .= "\r\nTo get started please respond with the {Department} code like (DXLE_15)";
        }else{
            $message = $this->organization->error_msg;
        }
        return  $message;
    }

    /**getServicesMessages Related to specific department
     *
     * @param $reservedId
     * @return string[]
     */
    private function getServicesMessages($reservedId){
        $services = Service::where(['department_id' => $reservedId, 'status' =>1])->get();
        if( $services->count() > 0 ){
            $message = $this->organization->service_msg."\r\n\r\n";
            foreach ($services as $service)
                $message .="- {$service->name}: ( SPOU_{$service->id} )\r\n";

            $message .= "\r\nTo get started please respond with the {Service} code like (SPOU_15)";
        }else{
            $message = $this->organization->error_msg;
        }
        return  $message;
    }

    /**addMemberToService to finish booking
     * @param $reservedId
     * @return string[]
     */
    private function addMemberToService($reservedId){
        $service = Service::find($reservedId);
        if($service->exists()){
            $memberService = MemberService::with('service')->where(['member_id' => $this->member_id, 'status'=>[0,1]])->first();
            if($memberService->exists()){
                $message = "You already booked Before on service( {$memberService->service->name} ), Your Window number is {$memberService->service->queue_number}";
            }else{
                MemberService::create(['member_id' => $this->member_id, 'service_id' => $service->id]);
                $message = str_replace("{window_number}", $service->queue_number, $this->organization->success_msg);
            }
        }else{
            $message = $this->organization->error_msg;
        }
        return $message;
    }

    /** sendMessage
     * @param $type
     * @param $messages
     */
    private function sendMessage($type, $message){
        $response = Http::post(self::WHATSAPP_SEND_API."?number={$this->contactNumber}&type={$type}&message={$message}&instance_id={$this->organization->instance_id}&access_token={$this->organization->token}");
        if($response->successful()){
            $responseBody = json_decode($response->body());
            if($responseBody->status == 'success'){
                $this->createMessage($responseBody->data->key->id, $message, $type, 1, $responseBody->data->key->remoteJid);
            }
        }
    }

    /** Create Message
     * @param $message_id
     * @param $message
     * @param $type
     * @param $from_me
     * @param $contact_number
     */
    private function createMessage($message_id, $message, $type, $fromMe, $contact_number){
        Message::create([
            'msg_id' => $message_id,
            'member_id' => $this->member_id,
            'body' => $message,
            'msg_type' => $type,
            'from_me' => $fromMe,
            'msg_date' => Carbon::now(),
            'contact_number' => $contact_number,
        ]);
    }
    /**createMember
     * @return mixed
     */
    private function createMember(){
        $member = Member::updateOrCreate(['name' => $this->contactName],['phone' => $this->contactNumber]);
        return $member->id;
    }

}
