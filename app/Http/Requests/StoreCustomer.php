<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomer extends FormRequest
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
		        'name'       => 'required|min:3',
		        'email'      => 'required|email',
		        'active'     => 'required',
		        'company_id' => 'required',
		        'image'      => 'sometimes|file|image|max:5000',
        ];
    }

	/**
	 *  配置验证器实例。
	 *
	 * @param  \Illuminate\Validation\Validator $validator
	 * @return void
	 */
	public function withValidator($validator)
	{

	}

	/**
	 * 获取已定义验证规则的错误消息。
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'name.required' => 'A name is required',
			'email.required'  => 'A email is required',
		];
	}
}
