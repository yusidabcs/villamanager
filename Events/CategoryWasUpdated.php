<?php
namespace Modules\Villamanager\Events;
use Modules\Media\Contracts\StoringMedia;

/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 1/29/17
 * Time: 5:16 PM
 */
class CategoryWasUpdated implements StoringMedia
{

    public $data;
    /**
     * @var int
     */
    public $category;

    public function __construct($category, array $data)
    {
        $this->data = $data;
        $this->category = $category;
    }

    public function getEntity()
    {
        return $this->category;
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