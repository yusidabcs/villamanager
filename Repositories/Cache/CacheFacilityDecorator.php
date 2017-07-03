<?php namespace Modules\Villamanager\Repositories\Cache;

use Modules\Villamanager\Repositories\FacilityRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFacilityDecorator extends BaseCacheDecorator implements FacilityRepository
{
    public function __construct(FacilityRepository $facility)
    {
        parent::__construct();
        $this->entityName = 'villamanager.facilities';
        $this->repository = $facility;
    }
}
