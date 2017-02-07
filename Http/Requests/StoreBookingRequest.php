<?php namespace Modules\Villamanager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Villamanager\Entities\Villa;

class StoreBookingRequest extends FormRequest {

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
			'title' => 'required',
			'first_name' => 'required',
			'email' => 'required|email',
			'phone' => 'required',
			'check_in' => 'required',
			'check_out' => 'required',
			'adult_guest' => 'required|integer',
			'country' => 'required',
			'total' => 'required',
		];
	}

	public function all()
    {
    	
    	$input = parent::all();

    	$villa = Villa::find(request()->id);
    	if(!$villa){
    		$villa = Villa::find($input['villa_id']); 
    	}
        
        if(empty($input['total'])){
            $input['total'] = floatval(str_replace(',', '.', str_replace('.', '', booking_price($villa))));
        }
        if(empty($input['total_paid'])){
            $input['total_paid'] = floatval(str_replace(',', '.', str_replace('.', '', total_booking_price($villa))));
        }

        if(array_key_exists('total_discount',$input)){
            $input['total_discount'] = floatval(str_replace(',', '.', str_replace('.', '', $input['total_discount'])));
        }

        $input['remaining_payment'] = $input['total'] - $input['total_paid'];
        $input['booking_number'] = time() . rand(10*45, 10*98);
        $input['villa_id'] = $villa->id;
        $input['check_in'] =  date('Y-m-d', strtotime($input['check_in']));
        $input['check_out'] =  date('Y-m-d', strtotime($input['check_out']));
        


        return $input;
    }

}
