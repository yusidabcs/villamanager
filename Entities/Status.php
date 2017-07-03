<?php namespace Modules\Villamanager\Entities;

/**
 * Class Status
 * @package Modules\Blog\Entities
 */
class Status
{
    const CHALLENGE = 3;
    const SUCCESS = 1;
    const SETTLEMENT = 2;
    const PENDING = 0;
    const DENY = 4;
    const EXPIRE = 5;
    const CANCEL = 6;

    /**
     * @var array
     */
    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::CHALLENGE => trans('villamanager::bookings.status.challenge'),
            self::SUCCESS => trans('villamanager::bookings.status.success'),
            self::SETTLEMENT => trans('villamanager::booking.sstatus.settlement'),
            self::PENDING => trans('villamanager::bookings.status.pending'),
            self::DENY => trans('villamanager::bookings.status.deny'),
            self::EXPIRE => trans('villamanager::bookings.status.expire'),
            self::CANCEL => trans('villamanager::bookings.status.cancel'),
        ];
    }

    /**
     * Get the available statuses
     * @return array
     */
    public function lists()
    {
        return $this->statuses;
    }

    /**
     * Get the post status
     * @param int $statusId
     * @return string
     */
    public function get($statusId)
    {
        if (isset($this->statuses[$statusId])) {
            return $this->statuses[$statusId];
        }

        return $this->statuses[self::PENDING];
    }

    public function getHTML($statusId)
    {
        switch ($statusId){
            case 0:
                return '<span class="label label-warning">'.$this->statuses[$statusId].'</span>';
            case 1:
                return '<span class="label label-success">'.$this->statuses[$statusId].'</span>';
            case 2:
                return '<span class="label label-success">'.$this->statuses[$statusId].'</span>';
            case 3:
                return '<span class="label label-danger">'.$this->statuses[$statusId].'</span>';
            case 4:
                return '<span class="label label-danger">'.$this->statuses[$statusId].'</span>';
            case 5:
                return '<span class="label label-danger">'.$this->statuses[$statusId].'</span>';
            case 6:
                return '<span class="label label-cancel">'.$this->statuses[$statusId].'</span>';
        }
        if (isset($this->statuses[$statusId])) {
            return ;
        }

        return $this->statuses[self::PENDING];
    }

    public function template($statusID){

        switch ($statusID){
            case 0:
                return 'emails.pending-villa-booking';
            case 1:
                return 'emails.success-villa-booking';
            case 2:
                return 'emails.settlement-villa-booking';
            case 3:
                return 'emails.challenge-villa-booking';
            case 4:
                return 'emails.deny-villa-booking';
            case 5:
                return 'emails.expire-villa-booking';
            case 6:
                return 'emails.cancel-villa-booking';
        }
    }
}
