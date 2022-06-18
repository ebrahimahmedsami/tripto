<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
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
            'name' => 'required|string|unique:organizations,name,'.(integer)$this->id,
            'phone' => 'required|numeric|digits_between:5,14|unique:organizations,phone,'.(integer)$this->id,
            'email' => 'required|email|unique:organizations,email,'.(integer)$this->id,
            'address' => 'required|string|min:20|max:255',
            'website_url' => 'required|url',
            'status'=> 'required|numeric|in:0,1',
            'lat' => 'required|between:-90,90',
            'long' => 'required|between:-180,180',
            'desc' => 'required|string|min:20|max:255',
            'instance_id' => 'required|string',
            'temp_msg' => 'required|string|min:20|max:255',
            'error_msg' => 'required|string|min:20|max:255',
            'department_msg' => 'required|string|min:20|max:255',
            'service_msg' => 'required|string|min:20|max:255',
            'token' => 'required|string',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
        ];
    }
}
