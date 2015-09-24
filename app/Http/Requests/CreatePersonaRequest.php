<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreatePersonaRequest extends Request {

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
            'nombre_persona'=>'required',
            'tipdoc'=>'required',
            'dni'=>'required|min:5|max:11|unique:persona,dni',
            'ticket'=>'required|unique:ticket,nroticket',
		];
	}

}
