<?php
/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 1/24/17
 * Time: 4:18 PM
 */

namespace Modules\Villamanager\Repositories;
use Modules\Core\Repositories\BaseRepository;

interface DisableDateRepository extends BaseRepository
{
    public function all();
}
