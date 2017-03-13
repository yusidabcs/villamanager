<?php namespace Modules\Villamanager\Entities;

use Modules\Villamanager\Entities\Facility;
use Modules\Villamanager\Entities\Rate;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Entities\File;

class Villa extends Model
{
    use Translatable;

    protected $table = 'villamanager__villas';
    public $translatedAttributes = [
	    'short_description',
	    'description',
	    'tos',
	    'villa_id',
	    'locale',
	    'meta_title',
	    'meta_description',
    ];
    protected $fillable = [
    	'name',
    	'location',
        'slug',
        'reservation_type',
        'area_id',
        'featured',
        'category_id',
    	// Translatable fields
    	'short_description',
	    'description',
	    'tos',
	    'villa_id',
	    'locale',
	    'meta_title',
	    'meta_description',

    ];

    public function facilities(){
    	 return $this->belongsToMany(Facility::class,'villamanager__villa_facility','villa_id','facility_id')->withPivot('status','value');
    }

    public function main_facilities(){
         return $this->belongsToMany(Facility::class,'villamanager__villa_facility','villa_id','facility_id')->withPivot('status','value')->wherePivot('status',1);
    }
    public function maxPerson(){
        return $this->maxPersonFacility->first() ? $this->maxPersonFacility->first()->pivot->value : 1;
    }

    public function bedroom(){
        return $this->bedroomFacility->first() ? $this->bedroomFacility->first()->pivot->value : 1;
    }
    public function bedroomFacility(){
        return $this->belongsToMany(Facility::class,'villamanager__villa_facility','villa_id','facility_id')->withPivot('status','value')->wherePivot('status',1)->where('key','bedroom');
    }
    public function maxPersonFacility(){
        return $this->belongsToMany(Facility::class,'villamanager__villa_facility','villa_id','facility_id')->withPivot('status','value')->wherePivot('status',1)->where('key','max_person');   
    }
    public function other_facilities(){
         return $this->belongsToMany(Facility::class,'villamanager__villa_facility','villa_id','facility_id')->withPivot('status','value')->wherePivot('status',0);
    }

    public function images(){
    	 return $this->belongsToMany(File::class,'villamanager__villa_images','villa_id','file_id')
             ->withPivot('thumbnail');
    }

    public function mainImages(){
         return $this->belongsToMany(File::class,'villamanager__villa_images','villa_id','file_id')
             ->withPivot('thumbnail')->where('thumbnail',1)->first();
    }

    public function allRates(){
        return $this->hasMany(Rate::class);
    }
    public function rates(){
    	 return $this->hasMany(Rate::class)->whereRaw('( CURRENT_DATE() BETWEEN start_date and end_date  or CURRENT_DATE() < start_date )');
    }

    public function category(){
        return $this->belongsTo(VillaCategory::class,'category_id');
    }
    public function cheapest_rates(){
         return $this->hasOne(Rate::class)->orderBy('rate','asc')->whereRaw('( CURRENT_DATE() BETWEEN start_date and end_date  or CURRENT_DATE() < start_date )');
    }

    public function bookings(){
        return $this->hasMany(VillaBooking::class,'villa_id');
    }
    public function disableDates(){
        return $this->hasMany(DisableDate::class,'villa_id');
    }

    public function fullcalender(){
    	$rs = [];
    	 foreach($this->allRates as $rate){
    	 	$rs[] = ($rate->fullcalender());
    	 }
    	 return $rs;
    }

    public function findBySlug($slug)
    {
            return $this->where('slug', $slug)->first();
    }

    public function url(){
            return url('villas/'.$this->slug);
    }

    public function getRate($date)
    {
        $rates = $this->rates()->whereRaw('"'.$date.'" between start_date and end_date')->first();
        return  $rates ? $rates->rate : 0;
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured',1);
    }

    public function lat()
    {
        $location = explode(';',$this->location);
        return @$location[0];
    }

    public function lng()
    {
        $location = explode(';',$this->location);
        return @$location[1];
    }

    public function discount()
    {
        $discount = Discount::active()->whereRaw('villa_id RLIKE "'.$this->id.'"')->first();
        return $discount;
    }

    public function discount_price($status = false)
    {
        $discount = $this->discount();

        if($discount->type == 1){
            $price = $this->cheapest_rates->rate - $discount->discount;
        }else{
            $price = $this->cheapest_rates->rate - ($this->cheapest_rates->rate * $discount->discount / 100);
        }

        if($status){
            return setting('core::currency') . ' '. $price;
        }
        return $price;



    }

}
