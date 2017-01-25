<?php

use Modules\Villamanager\Entities\Villa;

function url_generator($key,$value)
{
	$url = Request::url();
	$qry_old = Request::server('QUERY_STRING');
	parse_str($qry_old,$array);
	$array = array_except($array, array($key,'_pjax'));
	$array = array_add($array, $key, $value);
	$rs = http_build_query($array);
	return $url.'?'.$rs;
}

function get_villas($limit = null){
	$request = request();
	if($request->has('check_in') && $request->has('check_out'))
    {
    	$start = $request->get('check_in');
        $end = $request->get('check_out');

        $villas = Villa::whereDoesntHave('bookings', function ($q) use ($start,$end){

            $q->whereRaw('(check_in between "'.$start.'" and "'.$end.'" 
                OR "'.$start.'" between  check_in  and  check_out  
                OR  check_in between "'.$start.'" and "'.$end.'" 
                OR "'.$end.'" between check_in  and check_out)');

        })->whereDoesntHave('disableDates',function ($q) use ($start,$end){
            $q->whereRaw('(date between "'.$start.'" and "'.$end.'" )');
        })->limit($limit ? $limit : 6)->get();
    }else{
    	if($limit == null){
			$villas = Modules\Villamanager\Entities\Villa::all();
		}else{
			$villas = Modules\Villamanager\Entities\Villa::limit($limit)->get();
		}
    }

	return $villas;
}

function villa_url($villa){
	$url = '';
	$request = request();
	if($request->has('check_in') && $request->has('check_out'))
    {
    	$check_in = $request->get('check_in');
        $check_out = $request->get('check_out');
        $url = '?check_in='.$check_in.'&check_out='.$check_out;

    }
	return url('villas/'.$villa->slug.$url);
}


function villa_main_image($villa){

	return url($villa->mainImages() ? $villa->mainImages()->path : '#');
}

function villa_price($villa){
	return setting('core::currency').($villa->cheapest_rates ? price_format($villa->cheapest_rates->rate) : '0');
}


function booking_url($villa){

	$url = route('villamanager.bookings.show',$villa->id);
	$qry_old = request()->server('QUERY_STRING');
	parse_str($qry_old,$array);
	$array = array_except($array, array('_pjax'));
	//$array = array_add($array, $key, $value);
	$rs = http_build_query($array);
	return $url.'?'.$rs;
}

function booking_length($check_in = null,$check_out = null){

	if($check_in == null && $check_out == null){
		$check_in = strtotime(request()->get('check_in'));
		$check_out = strtotime(request()->get('check_out'));
	}else{
		$check_in = strtotime($check_in);
		$check_out = strtotime($check_out);
	}

	$datediff = $check_out - $check_in;

	$rs = floor($datediff / (60 * 60 * 24));
	return $rs;
}


function booking_price($villa){
	$length = booking_length();
	$i = 0;
	$total = 0;
	while ($i < $length ) {
		# code...
		$time = strtotime(request()->get('check_in')."+".$i." days");
		$newformat = date('Y-m-d',$time);

		$total += $villa->getRate($newformat);
		$i ++;
	}
	return price_format($total);
}

function total_discount($villa){
    $discount_code = request()->get('discount_code');
    $total_booking = floatval(str_replace(',', '.', str_replace('.', '', booking_price($villa))));
    if($discount_code != '')
    {
        $discount = \Modules\Villamanager\Entities\Discount::where('code',$discount_code)->first();
        if($discount)
        {
            $today = strtotime(date('Y-m-d'));
            $discount_start = strtotime($discount->start_date);
            $discount_end = strtotime($discount->end_date);

            if (($today >= $discount_start) && ( $today <= $discount_end))
            {
                if($discount->type == 1)
                {
                    if($discount->minimumPayment <= $total_booking)
                    {
                        return $discount->discount;
                    }
                }
                elseif($discount->type == 2)
                {
                    if($discount->minimumPayment <= $total_booking)
                    {
                        return $discount->discount / 100 * $total_booking;
                    }
                }
            }
        }
    }
}

function total_booking_price($villa){
	$percentage = setting('villamanager::booking_percentage');

    $discount_code = request()->get('discount_code');
    $total_booking = floatval(str_replace(',', '.', str_replace('.', '', booking_price($villa))));
    if($discount_code != '')
    {
        $discount = \Modules\Villamanager\Entities\Discount::where('code',$discount_code)->first();
        if($discount)
        {
            $today = strtotime(date('Y-m-d'));
            $discount_start = strtotime($discount->start_date);
            $discount_end = strtotime($discount->end_date);

            if (($today >= $discount_start) && ( $today <= $discount_end))
            {
                if($discount->type == 1)
                {
                    if($discount->minimumPayment <= $total_booking)
                    {
                        $total_booking-=$discount->discount;
                    }
                }
                elseif($discount->type == 2)
                {
                    if($discount->minimumPayment <= $total_booking)
                    {
                        $discount_nominal = $discount->discount / 100 * $total_booking;
                        $total_booking-=$discount_nominal;
                    }
                }
            }
        }
    }
	return price_format($percentage/100 * $total_booking);
}

function disabledDays($villa)
{

    $disabledDays = [];
    $bookings = \Modules\Villamanager\Entities\Booking::where('villa_id',$villa->id)->whereRaw('CURRENT_DATE BETWEEN check_in and check_out')->orderBy('check_in')->get();
    foreach($bookings as $booking){
        $dates = \Illuminate\Support\Facades\DB::select('select * from 
(select adddate(\'1970-01-01\',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where selected_date between ? and ?', [$booking->check_in,$booking->check_out]);
        foreach ($dates as $date){
            array_push($disabledDays,$date->selected_date);
        }
    }

    $disable_dates = \Modules\Villamanager\Entities\DisableDate::select('date')->where('villa_id',$villa->id)->whereRaw('date >= CURRENT_DATE')->get();

    $rs = array_merge($disabledDays,$disable_dates->pluck('date')->toArray());
    return json_encode($rs);


}
function price_format($a,$status=true){ // masuk 500000 ,, keluar jadi Rp. 500.000
    $string = $a . "";
    $tempKoma = "";
    if(strpos($string,".")!=false){
        $posKoma = strpos($string,".");
        $tempKoma = substr($string,$posKoma);
        $tempKoma = str_replace(".",",",$tempKoma);
        $tempKoma = substr($tempKoma,0,3);
        $string = substr($string,0,strpos($string,"."));
    }

    $jumDot = intval(strlen($string)/3);
    if(strlen($string) % 3 == 0){
        $jumDot = $jumDot-1;
    }
    $aha = 0;
    for($i=0; $i<$jumDot;$i++){
        $part[$i] = substr($string,strlen($string)-3);
        $string = substr($string,0,strlen($string)-3);
        $aha++;
    }

    $temp = $string;
    $string = "";
    for($i=0;$i<$jumDot;$i++){
        $string = "." . $part[$i] . $string;
    }
    $string =  $temp . $string ;
    return $string;
}
