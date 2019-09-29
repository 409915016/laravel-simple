<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class StoreBook extends FormRequest
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
	        'title'  => 'required|min:3',
	        'author' => 'required',
	        'type'   => '',
	        'file'   => 'required_if:type,ebook'
        ];
    }

	public function messages()
	{
		return [
			'title.required' => 'A title is required',
			'author.required'  => 'A author is required',
		];
	}

	protected function failedValidation(Validator $validator)
	{

		$data = [
			'code' => 422,
			'msg' => $validator->errors()->first(),
		];
		$response = new Response(json_encode($data), 422);
		throw (new ValidationException($validator, $response))
			->errorBag($this->errorBag)
			->redirectTo($this->getRedirectUrl());
	}

}
