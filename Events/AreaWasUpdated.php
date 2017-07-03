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
    private $gallery;
    private $data;

    public function __construct($gallery, $data)
    {
        $this->gallery = $gallery;
        $this->data = $data;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->gallery;
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