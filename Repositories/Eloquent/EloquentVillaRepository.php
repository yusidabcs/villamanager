<?php namespace Modules\Villamanager\Repositories\Eloquent;

use Modules\Villamanager\Repositories\VillaRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentVillaRepository extends EloquentBaseRepository implements VillaRepository
{

        public function create($data){
                
                $facility = array();
                foreach ($data['facility'] as $key => $value) {

                	$facility[$key] = [
                      'status' => isset($value['status']) ? $value['status'] : 0,
                      'value'	=> isset($value['value']) ? $value['value'] : '',
                      ];
                }
                
                $data['slug'] = str_slug($data['name']);

                $villa = $this->model->create($data);

                $villa->facilities()->sync($facility);

                $images = session()->get('villa_image',[]);

                $villa->images()->sync($images);

                $images = session()->forget('villa_image');

              
                return $villa;
        }

        public function update($model,$data){

                $model->update($data);

                $facility = array();
                foreach ($data['facility'] as $key => $value) {

                	$facility[$key] = [
                      'status' => isset($value['status']) ? $value['status'] : 0,
                      'value'	=> isset($value['value']) ? $value['value'] : '',
                      ];
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
