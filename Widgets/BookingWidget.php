<?php namespace Modules\Villamanager\Widgets;

use Modules\Villamanager\Repositories\BookingRepository;
use Modules\Dashboard\Foundation\Widgets\BaseWidget;

class BookingWidget extends BaseWidget
{
    /**
     * @var \Modules\Blog\Repositories\PostRepository
     */
    private $post;
    public function __construct(BookingRepository $post)
    {
        $this->post = $post;
    }
    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'BookingWidget';
    }
    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'villamanager::widgets.booking';
    }
    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {

        return ['total' => $this->post->all()->count()];
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
            'y' => '3',
        ];


    }
}