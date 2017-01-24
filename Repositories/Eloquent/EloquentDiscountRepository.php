<?php namespace Modules\Villamanager\Repositories\Eloquent;

use Modules\Villamanager\Repositories\DiscountRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentDiscountRepository extends EloquentBaseRepository implements DiscountRepository
{
    public function findDiscountByCode($code)
    {
        return $this->model->where('code', $code)->first();
    }

    public function claimDiscountByCode()
    {
        return $this->model->where('code',request()->get('discount_code'))->increment('claim');
    }


}
