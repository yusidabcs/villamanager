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
			'first_name' => 'required',
			'email' => 'required|email',
			'phone' => 'required',
			'check_in' => 'required',
			'check_out' => 'required',
			'adult_guest' => 'required|integer',
			'country_id' => 'required',
			'total' => 'required',
		];
	}

	public function all()
    {
    	
    	$input = parent::all();


        //calculate tip

    	$villa = Villa::find(request()->id);
    	if(!$villa){
    		$villa = Villa::find($input['villa_id']);
    	}

        if(empty($input['total'])){
            $input['total'] = floatval(str_replace(',', '.', str_replace('.', '', booking_price($villa,false))));
        }
        if(empty($input['total_paid'])){
            $input['total_paid'] = floatval(str_replace(',', '.', str_replace('.', '', total_booking_price($villa,false))));
        }

        if(array_key_exists('total_discount',$input)){
            $input['total_discount'] = floatval(str_replace(',', '.', str_replace('.', '', $input['total_discount'])));
        }else{
            $input['total_discount'] = 0;
        }



        $input['remaining_payment'] = $input['total'] - $input['total_paid'];
        $input['booking_number'] = time() . rand(10*45, 10*98);
        $input['villa_id'] = $villa->id;



        $date = $input['check_in'] =  date('Y-m-d', strtotime($input['check_in']));
        $input['check_out'] =  date('Y-m-d', strtotime($input['check_out']));

        $input['total_commission'] = 0;
        while (strtotime($date) <= strtotime("-1 day", strtotime($input['check_out']))) {
            $input['total_commission'] += $villa->getCommission($date);
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

        }

        if(isset($input['profile'])){
            foreach ($input['profile'] as $key => $value) {
                $input[$key] = $value;
            }
        }


        return $input;
    }


}
