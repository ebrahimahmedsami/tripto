<?php

use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

if(!function_exists('generateQrcode')){
    function generateQrcode($organizationName,$organizationphone){
        $qrcode = $organizationName.'_'.time().'_qrcode'.'.svg';
        $path = public_path('images/organization/qrcode');
        $whatsapp='https://wa.me/'.$organizationphone.'?text=Hello....';
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        QrCode::size(500)
            ->backgroundColor(255,255,204)
            ->format('svg')
            ->generate($whatsapp,$path.'/'.$qrcode);

        return $qrcode;
    }
}


if(!function_exists('imageUpload')){
    function imageUpload($image, $path){
        $imageName = 'image_'.time().'.'.$image->extension();
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        $image->move(public_path($path), $imageName);
        return $imageName;
    }
}
if(!function_exists('TypeUser')){
    function TypeUser($type){
        switch ($type) {
            case 1:
                return 'Admin';
                break;
            case 2:
                return 'organization_manager';
                break;
            case 3:
                return 'branch_manager';
                break;
            case 4:
                return 'department_manager';
                break;
            case 5:
                return 'service_operator';
                break;
        }

    }
}

if(!function_exists('permissions')){
    function permissions(){
       $permissions = ['users','roles','organizations','branches','departments','services','members'];
        return $permissions;
    }
}

if(!function_exists('reservationKeyWords')){
    function reservationKeyWords($word){
        $keyWords = [
            'branch'=>'BYKL',
            'department'=>'DXLE',
            'service'=>'SPOU'
        ];
        return  array_search($word, $keyWords, true);
    }
}
