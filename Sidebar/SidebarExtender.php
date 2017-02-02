<?php namespace Modules\Villamanager\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('villamanager::villas.title.main'), function (Item $item) {
                $item->icon('fa fa-building-o');
                $item->weight(6);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('villamanager::villas.title.villas'), function (Item $item) {
                    $item->icon('fa fa-hotel');
                    $item->weight(0);
                    $item->append('admin.villamanager.villa.create');
                    $item->route('admin.villamanager.villa.index');
                    $item->authorize(
                        $this->auth->hasAccess('villamanager.villas.index')
                    );
                });
                
                $item->item(trans('villamanager::facilities.title.facilities'), function (Item $item) {
                    $item->icon('fa fa-plus');
                    $item->weight(1);
                    $item->append('admin.villamanager.facility.create');
                    $item->route('admin.villamanager.facility.index');
                    $item->authorize(
                        $this->auth->hasAccess('villamanager.facilities.index')
                    );
                });

                $item->item(trans('villamanager::areas.title.areas'), function (Item $item) {
                    $item->icon('fa fa-map');
                    $item->weight(2);
                    $item->append('admin.villamanager.area.create');
                    $item->route('admin.villamanager.area.index');
                    $item->authorize(
                        $this->auth->hasAccess('villamanager.areas.index')
                    );
                });
                $item->item(trans('villamanager::bookings.title.bookings'), function (Item $item) {
                    $item->icon('fa fa-calendar');
                    $item->weight(2);
                    $item->append('admin.villamanager.booking.index');
                    $item->route('admin.villamanager.booking.index');
                    $item->authorize(
                        $this->auth->hasAccess('villamanager.bookings.index')
                    );
                });


                $item->item(trans('villamanager::inquiries.title.inquiries'), function (Item $item) {
                    $item->icon('fa fa-calendar');
                    $item->weight(2);
                    $item->append('admin.villamanager.inquiry.index');
                    $item->route('admin.villamanager.inquiry.index');
                    $item->authorize(
                        $this->auth->hasAccess('villamanager.inquiries.index')
                    );
                });

                $item->item(trans('villamanager::discounts.title.discounts'), function (Item $item) {
                    $item->icon('fa fa-tag');
                    $item->weight(2);
                    $item->append('admin.villamanager.discount.index');
                    $item->route('admin.villamanager.discount.index');
                    $item->authorize(
                        $this->auth->hasAccess('villamanager.discounts.index')
                    );
                });
// append




            });
        });

        return $menu;
    }
}
