<?php namespace Modules\Villamanager\Widgets;

use Modules\User\Contracts\Authentication;
use Modules\Villamanager\Repositories\VillaRepository;
use Modules\Dashboard\Foundation\Widgets\BaseWidget;

class VillasWidget extends BaseWidget
{
    /**
     * @var \Modules\Blog\Repositories\PostRepository
     */
    private $villa,$user;
    public function __construct(Authentication $authentication,VillaRepository $villaRepository)
    {
        $this->villa = $villaRepository;
        $this->user = $authentication;
    }
    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'VillasWidget';
    }
    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'villamanager::widgets.villas';
    }
    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {
        return ['villaCount' => $this->villa->all()->count()];
    }
     /**
     * Get the widget type
     * @return string
     */
    protected function options()
    {
        return [
            'width' => '3',
            'height' => '2',
            'x' => '0',
        ];
    }
}