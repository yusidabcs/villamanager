<?php namespace Modules\Villamanager\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;

abstract class BaseVillaModuleController extends AdminBaseController
{
    /**
     * @var PermissionManager
     */
    protected $facilities;

    /**
     * @param $request
     * @return array
     */
    protected function mergeRequestWithFacility($request)
    {
        $facilities = $request->facilities;

        return array_merge($request->all(), [ 'facilities' => $facilities ]);
    }
}
