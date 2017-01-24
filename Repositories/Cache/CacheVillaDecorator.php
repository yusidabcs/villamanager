<?php namespace Modules\Villamanager\Repositories\Cache;

use Modules\Villamanager\Repositories\VillaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheVillaDecorator extends BaseCacheDecorator implements VillaRepository
{
    public function __construct(VillaRepository $villa)
    {
        parent::__construct();
        $this->entityName = 'villamanager.villas';
        $this->repository = $villa;
    }
}
