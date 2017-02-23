<?php
/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 2/16/17
 * Time: 7:29 PM
 */

namespace Modules\Villamanager\Events;


use Modules\Media\Contracts\DeletingMedia;

class CategoryWasDeleted implements DeletingMedia
{
    /**
     * @var string
     */
    private $areaClass;
    /**
     * @var int
     */
    private $areaId;
    public function __construct($areaId, $areaClass)
    {
        $this->areaClass= $areaClass;
        $this->areaId = $areaId;
    }
    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId()
    {
        return $this->areaId;
    }
    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName()
    {
        return $this->areaClass;
    }

}