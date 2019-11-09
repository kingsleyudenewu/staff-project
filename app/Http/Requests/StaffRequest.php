<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
        switch ($this->method()){
            case "POST":
                return [
                    'name' => 'required|unique:staffs,name',
                    'phone' => 'required',
                    'email' => 'required',
                ];
                break;
            case "PATCH":
                $id = request()->id;
                return [
                    'name' => 'required|unique:staffs,name,'.$id,
                    'phone' => 'required',
                    'email' => 'required',
                ];
                break;
        }

    }
}
