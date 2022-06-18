<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class EmloyeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|string',
            'image'=>'image|mimes:jpg,png,jpeg,gif,|max:2048|sometimes|nullable',
            'email'=>'required|email|unique:users,email,'.$this->id,
            'password' => 'sometimes|min:6|max:25|confirmed',
            'phone'=>'required|numeric',
            'role_id'=>'required',
            'type'=>'required',
            'status'=>'required|in:1,0',

        ];
    }
}
