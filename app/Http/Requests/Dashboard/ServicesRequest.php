<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ServicesRequest extends FormRequest
{
    use ResponseTrait;
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
        return $this->isMethod('POST') ? $this->store() : $this->update();
    }

    public function store(){
        return [
            "name" => "required|string|min:3|max:150",
            "status" => "required|boolean",
            "desc" => "required|string|min:3|max:225",
            "queue_number" => "required|numeric",
            "range_time" => "required|numeric",
            "department_id" => "required|numeric|exists:departments,id",
        ];
    }

    public function update(){
        return [
            "name" => "required|string|min:3|max:150",
            "status" => "required|boolean",
            "desc" => "required|string|min:3|max:225",
            "queue_number" => "required|numeric",
            "range_time" => "required|numeric",
            "department_id" => "required|numeric|exists:departments,id",
        ];
    }

    protected function failedValidation(Validator $validator){
        $response = $this->validationError($validator->errors());
        throw new ValidationException($validator, $response);
    }

}
