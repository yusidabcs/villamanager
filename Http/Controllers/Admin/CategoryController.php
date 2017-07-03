<?php
/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 2/16/17
 * Time: 3:13 PM
 */

namespace Modules\Villamanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Media\Repositories\FileRepository;
use Modules\Villamanager\Entities\VillaCategory;
use Modules\Villamanager\Http\Requests\StoreCategoryRequest;
use Modules\Villamanager\Repositories\CategoryRepository;

class CategoryController extends BaseVillaModuleController
{
    public $category,$file;
    public function __construct(CategoryRepository $categoryRepository,FileRepository $fileRepository)
    {
        parent::__construct();
        $this->category  = $categoryRepository;
        $this->file = $fileRepository;
    }

    public function index()
    {
        $categories = $this->category->all();
        return view('villamanager::admin.categories.index', compact('categories'));
    }

    public function create()
    {
        //
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->category->create($request->all());
        return redirect()->route('admin.villamanager.category.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('villamanager::categories.title.categories')]));
    }

    public function edit(VillaCategory $villa_category)
    {
        $category = $villa_category;
        $thumbnail = $this->file->findFileByZoneForEntity('thumbnail', $villa_category);
        return view('villamanager::admin.categories.edit', compact('category','thumbnail'));
    }

    public function update(Request $request,VillaCategory $villa_category)
    {
        $this->category->update($villa_category, $request->all());

        if ($request->get('button') === 'index') {
            return redirect()->route('admin.villamanager.category.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('villamanager::categories.title.categories')]));
        }

        return redirect()->back();
    }

    public function destroy(VillaCategory $villa_category)
    {
        $this->category->destroy($villa_category);

        return redirect()->route('admin.villamanager.category.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('villamanager::categories.title.categories')]));
    }

}