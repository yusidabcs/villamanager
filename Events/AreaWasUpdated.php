<?php
namespace Modules\Villamanager\Events;
use Modules\Media\Contracts\StoringMedia;

/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 1/29/17
 * Time: 5:16 PM
 */
class AreaWasUpdated implements StoringMedia
{

    public $data;
    /**
     * @var int
     */
    public $area;

    public function __construct($area, array $data)
    {
        $this->data = $data;
        $this->area = $area;
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
        return $this->area;
    }
}