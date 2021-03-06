<?php namespace Modules\Villamanager\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateVillaRequest extends BaseFormRequest {

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
    public function all()
    {

        $input = parent::all();
        if(empty($input['featured'])){
            $input['featured'] = 0;
        }
        return $input;
    }

}
