<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=> ['required','string'],
            'description'=> ['required'],
            'price'=> ['required','numeric'] ,
            'qtyInstock'=>['required','numeric'],
            'categoryId' => ['required','numeric','exists:categories,id'],
            'imgUrl'=>['nullable','mimes:png,jpg']
        ];
    }
}
