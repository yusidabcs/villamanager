<?php
/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 2/23/17
 * Time: 5:21 PM
 */

namespace Modules\Villamanager\Repositories\Cache;


use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Villamanager\Repositories\AreaRepository;

class CacheAreaDecorator extends BaseCacheDecorator implements AreaRepository
{
    public function __construct(AreaRepository $booking)
    {
        parent::__construct();
        $this->entityName = 'villamanager.areas';
        $this->repository = $booking;
    }
}