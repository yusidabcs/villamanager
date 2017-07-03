<?php namespace Modules\Villamanager\Http\Requests;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
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
            'short_description' => 'required',
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
        if(empty($input['best_seller'])){
            $input['best_seller'] = 0;
        }
        if(empty($input['approved'])){
            $input['approved'] = 0;
        }
        $input = array_add($input,'user_id',Sentinel::check()->id);
        return $input;
    }

}
