<?php namespace Modules\Villamanager\Repositories\Cache;

use Modules\Villamanager\Repositories\RateRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRateDecorator extends BaseCacheDecorator implements RateRepository
{
    public function __construct(RateRepository $rate)
    {
        parent::__construct();
        $this->entityName = 'villamanager.rates';
        $this->repository = $rate;
    }
}
