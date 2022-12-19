<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'ad'=>'required|min:3|max:14',
            'email'=>'required|min:5|max:30',
            'parol'=>'required|min:3|max:14',
        ];
    }

    public function messages(){

        return[
            'ad.required'=>'Ad daxil etmediniz',
            'ad.min'=>'Ad minimum 3 simvol olmalidir',
            'email.required'=>'Email daxil etmediniz',
            'email.min'=>'Email minimum 5 simvol olmalidir',
            'parol.min'=>'Ad minimum 3 simvol olmalidir',
        ];
    }
}
