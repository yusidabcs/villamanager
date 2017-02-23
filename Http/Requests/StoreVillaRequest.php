<?php namespace Modules\Villamanager\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class StoreVillaRequest extends BaseFormRequest {

	protected $translationsAttributesKey = 'villamanager::villas.validation.attributes';
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
			'name' => 'required',
		];
	}

	public function translationRules()
    {
        return [
            'short_description' => 'required|max:250',
			'description' => 'required',
			'tos' => 'required',
        ];
    }

}
