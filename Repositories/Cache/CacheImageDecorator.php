<?php namespace Modules\Villamanager\Repositories\Cache;

use Modules\Villamanager\Repositories\ImageRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheImageDecorator extends BaseCacheDecorator implements ImageRepository
{
    public function __construct(ImageRepository $image)
    {
        parent::__construct();
        $this->entityName = 'villamanager.images';
        $this->repository = $image;
    }
}
