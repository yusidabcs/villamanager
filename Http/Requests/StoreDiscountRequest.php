<?php
/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 1/12/17
 * Time: 5:01 PM
 */

namespace Modules\Villamanager\Http\Requests;


use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = [
            'code' => 'required|unique:villamanager__discounts,code',
            'type' => 'required',
            'discount' => 'required|integer',
            'total' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'minimumPayment' => 'required|integer',
        ];
        if($request->get('type') == 2)
            $rules['discount'] = 'required|integer|between:0,100';
        return $rules;
    }
}