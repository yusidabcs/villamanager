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

    public function all()
    {
        return $this->repository->all();
    }

    public function unapproved()
    {
        return $this->repository->unapproved();
    }

    public function unapprovedVillas()
    {
        return $this->repository->unapprovedVillas();
    }





}
