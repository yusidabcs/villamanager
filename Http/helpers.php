<?php

use Modules\Villamanager\Entities\Villa;


function elixirTheme($file, $manifestPath = 'build/rev-manifest.json')
{
    static $manifest = null;

    if (is_null($manifest)) {
        $manifest = json_decode(file_get_contents(Theme::url('build/rev-manifest.json')), true);
    }

    if (isset($manifest[$file])) {
        return 'build/'.$manifest[$file];
    }

    throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
}
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

function get_villas($limit = null,$options = []){


	$request = request();
    $villa = new Villa();

    if($request->get('keyword') != '')
    {
        $villa = $villa->where('name','like','%'.$request->get('keyword').'%');
    }

    if($request->get('area') != '')
    {
        $villa = $villa->where('area_id','=',$request->get('area'));
    }
	if($request->has('check_in') && $request->has('check_out'))
    {
    	$start = $request->get('check_in');
        $end = $request->get('check_out');

        $villa = $villa->whereDoesntHave('bookings', function ($q) use ($start,$end){

            $q->whereRaw('(check_in between "'.$start.'" and "'.$end.'" 
                OR "'.$start.'" between  check_in  and  check_out  
                OR  check_in between "'.$start.'" and "'.$end.'" 
                OR "'.$end.'" between check_in  and check_out) and status != 2');

        })->whereDoesntHave('disableDates',function ($q) use ($start,$end){
            $q->whereRaw('(date between "'.$start.'" and "'.$end.'" )');
        });
    }
    if($request->has('category') && $request->get('category') != ''){

        $villa = $villa->where('category_id','=',$request->get('category'));

    }

    if(isset($options['featured']) && $options['featured'] == true)
    {
        $villa = $villa->where('featured',1);
    }

    if(isset($options['discount']) && $options['discount'] == true)
    {
        $villa = $villa->whereHas('discount',function ($q){
            $q->where('total','>','claim');
            $q->whereRaw(' current_date between start_date and end_date');
        });
    }

    if($request->has('min_price') && $request->has('max_price')){
        if($request->get('min_price') != '' && $request->get('max_price') != '' ) {
            $villa = $villa->whereHas('rates',function ($q) use ($request){
                $q->whereBetween('rate',[$request->get('min_price'),$request->get('max_price')]);
            });
        }
    }

    if($request->has('bedroom')){
        $villa = $villa->whereHas('bedroomFacility',function ($q) use ($request){
            $q->where('value','=',$request->get('bedroom'));
        });
    }
    $villa = $villa->paginate($limit ? $limit : 6);
	return $villa;
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
    $bookings = \Modules\Villamanager\Entities\Booking::where('villa_id',$villa->id)->whereRaw('( CURRENT_DATE BETWEEN check_in and check_out or (check_in > CURRENT_DATE) or (check_out < CURRENT_DATE) )')
        ->where('status','!=',2)
        ->orderBy('check_in')->get();

    foreach($bookings as $booking){

        $dates = generateDateRange(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$booking->check_in),\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$booking->check_out));
        $disabledDays = array_merge($disabledDays,$dates);

    }

    $disable_dates = \Modules\Villamanager\Entities\DisableDate::select('date')->where('villa_id',$villa->id)->whereRaw('date >= CURRENT_DATE')->get();

    $rs = $disabledDays;//array_merge($disabledDays,$disable_dates->pluck('date')->toArray());
    return json_encode($rs);

}

function generateDateRange(Carbon\Carbon $start_date, Carbon\Carbon $end_date)
{
    $dates = [];

    for($date = $start_date; $date->lte($end_date); $date->addDay()) {
        $dates[] = $date->format('Y-m-d');
    }

    return $dates;
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


function villa_areas($status = false)
{
    if($status){
        return \Modules\Villamanager\Entities\Area::parent()->get();
    }

    return \Modules\Villamanager\Entities\Area::all();
}

function villa_categories(){
    return \Modules\Villamanager\Entities\VillaCategory::all();
}

function villa_category_image($category){

    return url(count($category->files) > 0 ? $category->files[0]->path : Theme::url('images/user-icon.png'));

}

function villa_category_alt($category){

    return url(count($category->files) > 0 ? $category->files[0]->alt_attribute : '');

}

function get_discounts(){
    return \Modules\Villamanager\Entities\Discount::active()->get();
}