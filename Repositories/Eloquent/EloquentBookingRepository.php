<?php namespace Modules\Villamanager\Repositories\Eloquent;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\QueryException;
use League\Flysystem\Exception;
use Modules\User\Services\UserRegistration;
use Modules\Villamanager\Entities\Status;
use Modules\Villamanager\Repositories\BookingRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentBookingRepository extends EloquentBaseRepository implements BookingRepository
{

	public function findByBookingNumber($id){
		
		return $this->model->with('villa')->where('booking_number', $id)->first();

	}

    public function create($data)
    {
        $data['check_in'] = $data['check_in'].' 14:00:00';
        $data['check_out'] = $data['check_out'].' 12:00:00';
        $data['user_id'] = 0;

        if(array_key_exists('register',$data)){
            if($data['register'] == 1){

                try{
                    $user = app(UserRegistration::class)->register([
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'email' => $data['email'],
                        'password'  => rand()
                    ]);
                    $data['user_id'] = $user->id;
                }catch (QueryException $exception){
                    return redirect()->back()->withInput()
                        ->withError('Member with this email already exist, please try login.');

                }


            }
        }

        if(Sentinel::check()){
            $user = Sentinel::check();
            $data['user_id'] = $user->id;
        }

        return $this->model->create($data);
    }


    public function all(){


		if(request()->has('view')){
			if(request()->has('villa')){

				$bookings = $this->model->where('villa_id',request()->get('villa'))->get();

			}else{
				
				$bookings = $this->model->all();
				
			}
			$rs  = [];
			foreach ($bookings as $booking) {
				$rs[] = $booking->fullcalender();
			}
			return $rs;
		}
        if(Sentinel::check()){
            $user = Sentinel::getUser();
            if(!$user->inRole('admin')){
                return $this->model->whereHas('villa',function($q) use ($user){
                    $q->where('user_id',$user->id);
                })->get();
            }
        }
		return $this->model->all();

	}

    public function findByUser($id)
    {
        return $this->model->where('user_id',$id)->paginate(10);
    }

    public function getTotalBookingOnDate($date,$opt = [])
    {
        $rs = $this->model->where('created_at',$date);

        foreach ($opt as $key => $value){
            $rs->where($key,$value);
        }

        return $rs->count();
    }

    public function getTotalBookingByDate($opt)
    {
        if(Sentinel::check()){
            $user = Sentinel::getUser();
            if(!$user->inRole('admin')){
                return currency($this->model->whereHas('villa',function($q) use ($user){
                    $q->where('user_id',$user->id);
                })->where('created_at',$opt)->sum('total'));
            }
        }
        return currency($this->model->where('created_at',$opt)->sum('total'));
    }

    public function getTotalBookingCommissionByDate($date)
    {
        if(Sentinel::check()){
            $user = Sentinel::getUser();
            if(!$user->inRole('admin')){
                return currency($this->model->whereHas('villa',function($q) use ($user){
                    $q->where('user_id',$user->id);
                })->where('created_at',$date)->sum('total_commission'));
            }
        }
        return currency($this->model->where('created_at',$date)->sum('total_commission'));
    }

    public function getTotalBooking()
    {
        if(Sentinel::check()){
            $user = Sentinel::getUser();
            if(!$user->inRole('admin')){
                return currency($this->model->whereHas('villa',function($q) use ($user){
                    $q->where('user_id',$user->id);
                })->sum('total'));
            }
        }
        return currency($this->model->sum('total'));
    }

    public function getTotalPaidBooking()
    {
        if(Sentinel::check()){
            $user = Sentinel::getUser();
            if(!$user->inRole('admin')){
                return currency($this->model->whereHas('villa',function($q) use ($user){
                    $q->where('user_id',$user->id);
                })->where('status',Status::SUCCESS)->count());
            }
        }
        return ($this->model->where('status',Status::SUCCESS)->count());
    }

    public function getTotalCancelBooking()
    {
        if(Sentinel::check()){
            $user = Sentinel::getUser();
            if(!$user->inRole('admin')){
                return currency($this->model->whereHas('villa',function($q) use ($user){
                    $q->where('user_id',$user->id);
                })->where('status',Status::CANCEL)->count());
            }
        }
        return ($this->model->where('status',Status::CANCEL)->count());
    }

    public function getTotalCommission()
    {
        if(Sentinel::check()){
            $user = Sentinel::getUser();
            if(!$user->inRole('admin')){
                return currency($this->model->whereHas('villa',function($q) use ($user){
                    $q->where('user_id',$user->id);
                })->where('status',Status::SUCCESS)->sum('total_commission'));
            }
        }
        return currency($this->model->where('status',Status::SUCCESS)->sum('total_commission'));
    }

    public function todayBookings()
    {
        if(Sentinel::check()){
            $user = Sentinel::getUser();
            if(!$user->inRole('admin')){
                return ($this->model->whereHas('villa',function($q) use ($user){
                    $q->where('user_id',$user->id);
                })->where('created_at',date('Y-m-d')));
            }
        }
        return $this->model->where('created_at',date('Y-m-d'));
    }


}
