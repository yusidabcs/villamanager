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

function similar_villas($other, $limit = 3){

    $request = request();
    $villa = new Villa();

    $villa = $villa->where('area_id',$other->area_id);
    $villa = $villa->where('approved',1)
        ->where('id','!=',$other->id)->take($limit)->get();
    return $villa;
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
    	$start = $request->get('check_in').' 14:00:00';
        $end = $request->get('check_out').' 12:00:00';;

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

    if($request->has('guest') && $request->get('guest') != ''){

        $villa = $villa->where('max_person','>=',$request->get('guest'));

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

    if($request->has('sort_price')){
        $villa = $villa->whereHas('rates',function ($q) use ($request){
            $q->orderBy('rate',$request->get('sort_price'));
        });
    }
    if($request->has('sort_name')){
        $villa = $villa->orderBy('name',$request->get('sort_name'));
    }
    if($request->has('facility')){
        foreach ($request->get('facility') as $key => $facility) {
            $villa = $villa->whereHas('main_facilities', function ($q) use ($facility) {
                $q->where('key', $facility);

            });
        }
    }

    $villa = $villa->where('approved',1)->paginate($limit ? $limit : 12);
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
	return route('villas.show',$villa->slug.$url);
}


function villa_main_image($villa , $thumbnail = false){

	return url($villa->mainImages() ? ($thumbnail !== false ? \Modules\Media\Image\Facade\Imagy::getThumbnail($villa->mainImages(),$thumbnail) : $villa->mainImages()->path) : '#');
}

function villa_price($villa){
    $user = \Cartalyst\Sentinel\Laravel\Facades\Sentinel::check();
    if($user){
        if($user->inRole('agent')){

            if($villa->agent_price_type == 1)
                return ($villa->cheapest_rates ? currency($villa->cheapest_rates->rate + ($villa->cheapest_rates->rate * $villa->agent_price / 100)) : currency(0));
            else if($villa->agent_price_type == 2)
                return ($villa->cheapest_rates ? currency($villa->cheapest_rates->rate + $villa->agent_price ) : currency(0));
        }
    }
    if($villa->publish_price_type == 1)
        return ($villa->cheapest_rates ? currency($villa->cheapest_rates->rate + ($villa->cheapest_rates->rate * $villa->publish_price / 100)) : currency(0));
    else if($villa->publish_price_type == 2)
        return ($villa->cheapest_rates ? currency($villa->cheapest_rates->rate + $villa->publish_price) : currency(0));
}

function rate_price($rate){

    if ($user = Sentinel::getUser())
    {
        if ($user->inRole('agent'))
        {
            return currency($rate->rate - ($rate->rate * $rate->villa->agent_discount / 100));
        }
    }

    return currency($rate->rate);
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

	$rs = floor($datediff / (60 * 60 * 22));
	return $rs;
}


function booking_price($villa,$status = true,$user = null){
	$length = booking_length();
	$i = 0;
	$total = 0;

    if($user == null)
        $user = \Cartalyst\Sentinel\Laravel\Facades\Sentinel::check();

	while ($i < $length ) {
		# code...
		$time = strtotime(request()->get('check_in')."+".$i." days");
		$newformat = date('Y-m-d',$time);
        $rate = $villa->getRate($newformat);

        if($user && $user->inRole('agent')){

            if($villa->agent_price_type == 1){
                $fee =  $rate * $villa->agent_price / 100;
                $total += $rate + $fee;
            }
            else if($villa->agent_price_type == 2){
                $fee = $villa->agent_price;
                $total += $rate + $fee;
            }
        }else{
            if($villa->publish_price_type == 1){
                $fee =  $rate * $villa->publish_price / 100;
                $total += $rate + $fee;
            }
            else if($villa->publish_price_type == 2){
                $fee = $villa->publish_price;
                $total += $rate + $fee;
            }
        }
		$i ++;
	}
	if ($status)
	    return currency($total);
    return $total;
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


function villa_areas($parent = false,$limit = false,$top = false)
{
    if($parent){
        if($limit !== false){
            return \Modules\Villamanager\Entities\Area::parent()->take($limit)->get();
        }
    }

    if($top){
        if($limit !== false){
            return \Modules\Villamanager\Entities\Area::leftJoin('villamanager__villas','villamanager__areas.id','=','villamanager__villas.area_id')
                ->selectRaw('villamanager__areas.*, count(villamanager__villas.id) as `count`')
                ->groupBy('villamanager__areas.id')
                ->orderBy('count','desc')
                ->take($limit)->get();
        }else{
            return \Modules\Villamanager\Entities\Area::leftJoin('villamanager__villas','villamanager__areas.id','=','villamanager__villas.area_id')
                ->selectRaw('villamanager__areas.*, count(villamanager__villas.id) as `count`')
                ->groupBy('villamanager__areas.id')
                ->orderBy('count','desc')
                ->get();
        }
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

function get_facilities(){
    return \Modules\Villamanager\Entities\Facility::all();
}

function get_countries(){
    $value = Cache::remember('countries', 600, function()
    {
        return \Modules\Villamanager\Entities\Country::all();
    });
    return $value;
}