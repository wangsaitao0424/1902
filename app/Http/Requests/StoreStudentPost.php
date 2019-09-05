<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentPost extends FormRequest
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
            'student_name' => 'required|unique:student|max:30',
            'student_age' => 'required|numeric',
            'student_sex' => 'required',
        ];
    }
    public function messages(){
        return [
            'student_name.required' => '姓名必填',
            'student_name.unique' => '姓名已有',
            'student_name.max' => '字段最大姓名为30位',
            'student_age.numeric' => '年龄必选为数值',
            'student_age.required' => '年龄必填',
            'student_sex.required' => '性别必选',
        ];
    }
}
