<?php namespace Modules\Villamanager\Repositories\Eloquent;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Modules\Villamanager\Entities\Villa;
use Modules\Villamanager\Repositories\VillaRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentVillaRepository extends EloquentBaseRepository implements VillaRepository
{
    public function all()
    {
        if(Sentinel::check()){
            $user = Sentinel::getUser();
            if(!$user->inRole('admin')){
                return $this->model->where('user_id',$user->id)->get();
            }
        }


        return parent::all();
    }
    public function unapproved()
    {
        if(Sentinel::check()){
            $user = Sentinel::getUser();
            if(!$user->inRole('admin')){
                return $this->model->where('user_id',$user->id)->where('approved',0)->count();
            }
        }
        return $this->model->where('approved',0)->count();
    }

    public function unapprovedVillas()
    {
        if(Sentinel::check()){
            $user = Sentinel::getUser();
            if(!$user->inRole('admin')){
                return $this->model->where('user_id',$user->id)->where('approved',0)->get();
            }
        }
        return $this->model->where('approved',0)->get();
    }

    protected function slugGenerator($slug)
    {
        $count = Villa::where('slug',$slug)->count();
        if($count == 0)
        {
            return $slug;
        }
        else{
            $slug = $slug.''.($count+1);
            return $this->slugGenerator($slug);
        }

    }
    public function create($data){
                
                $facility = array();
                if(array_key_exists('facility',$data)){
                    foreach ($data['facility'] as $key => $value) {

                        $facility[$key] = [
                            'status' => isset($value['status']) ? $value['status'] : 0,
                            'value'	=> isset($value['value']) ? $value['value'] : '',
                        ];
                    }
                }

                $slug = str_slug($data['name']);

                $data['slug'] = $this->slugGenerator($slug);

                $villa = $this->model->create($data);

                $villa->facilities()->sync($facility);

                $images = session()->get('villa_image',[]);

                $villa->images()->sync($images);

                $images = session()->forget('villa_image');

              
                return $villa;
        }

        public function update($model,$data){

                $model->update($data);

                $model->tripadvisor()->updateOrCreate([
                    'url' => $data['tripadvisor_url']
                ]);

                $facility = array();
                if(array_key_exists('facility',$data)) {
                    foreach ($data['facility'] as $key => $value) {

                        $facility[$key] = [
                            'status' => isset($value['status']) ? $value['status'] : 0,
                            'value' => isset($value['value']) ? $value['value'] : '',
                        ];
                    }
                }

                $model->facilities()->sync($facility);
              
                return $model;
        }


        public function findBySlug($slug)
        {
                return $this->model->where('slug', $slug)->first();
        }

        public function url(){
                return url('villas/'.$this->model->slug);
        }


}
