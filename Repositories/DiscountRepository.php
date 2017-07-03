<?php namespace Modules\Villamanager\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface DiscountRepository extends BaseRepository
{
	public function findDiscountByCode($code);
    public function claimDiscountByCode();
}
