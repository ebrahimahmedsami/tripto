<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LoginRequest;
use App\Http\Resources\Dashboard\UserResource;
use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ResponseTrait;
    public function login(LoginRequest $request){
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password))
            return $this->validationError([ 'email' => [__('auth.failed')],]);

        return $this->returnData('data', new UserResource($user->load('group')), 'User Authenticated Successfully');
    }

    /**this method signs out users by removing tokens
     * @param Request $request
     */
    public function signout(Request $request) :void
    {
        $request->user()->currentAccessToken()->delete();
    }

}
