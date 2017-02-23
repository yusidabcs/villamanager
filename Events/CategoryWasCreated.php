<?php
/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 2/16/17
 * Time: 7:29 PM
 */

namespace Modules\Villamanager\Events;


use Modules\Media\Contracts\StoringMedia;

class CategoryWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var int
     */
    public $area;

    public function __construct($area, array $data)
    {
        $this->data = $data;
        $this->area= $area;
    }

    public function getEntity()
    {
        return $this->area;
    }
    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }

}