<?php namespace Modules\Villamanager\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Villamanager\Entities\Image;
use Modules\Villamanager\Repositories\ImageRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Support\Facades\Response;
use Modules\Media\Image\Imagy;
use Modules\Media\Repositories\FileRepository;
use Modules\Media\Services\FileService;
use Modules\Media\Entities\File;
use Modules\Villamanager\Entities\Villa;

class ImageController extends Controller
{
    /**
     * @var ImageRepository
     */
    private $image;
    private $fileService;
    private $imagy;

    public function __construct(FileService $fileService, Imagy $imagy,File $file)
    {

        $this->fileService = $fileService;
        $this->imagy = $imagy;

        $this->file = $file;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$images = $this->image->all();

        return view('villamanager::admin.images.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('villamanager::admin.images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store($villa_id,Request $request)
    {
        $savedFile = $this->fileService->store($request->file('file'));
        session()->push('villa_image', $savedFile->id);
        return session()->all();
        if (is_string($savedFile)) {
            return Response::json([
                'error' => $savedFile
            ], 409);
        }
        if($villa_id != 0){
            $villa = Villa::find($villa_id);
            $villa->images()->attach([$savedFile->id]);
            return view()->make('villamanager::admin.villas.partials.single-image')->with('file',$savedFile)
            ->with('villa',$villa);
        }else{
            session()->push('villa_image', $savedFile->id);
            return view()->make('villamanager::admin.villas.partials.single-image')->with('file',$savedFile);
        }
        

        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Image $image
     * @return Response
     */
    public function edit(Image $image)
    {
        return view('villamanager::admin.images.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Image $image
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request,$id){

        $villa = Villa::find($id);
        $mainImage = $villa->mainImages();
        $image = json_decode($request->get('menu'));

        $data = array(

        );
        foreach ($image as $position => $item) {

            if($mainImage && $mainImage->id == $item->id){
                $data[$item->id] = [
                    'thumbnail' => 1,
                    'order' => $position+1
                ];
            }else{
                $data[$item->id] =  [
                    'thumbnail' => 0,
                    'order' => $position+1
                ];
            }
        }
        $villa->images()->sync($data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Image $image
     * @return Response
     */
    public function destroy(File $file,Request $request)
    {
        
        $request->session()->pull('image_temp', $file->id);
        try {
            $this->imagy->deleteAllFor($file);    
        } catch (Exception $e) {
            
        }
        
        $this->file->destroy($file->id);
        $request->session()->pull('image_temp', $file->id);

        return response()->json(trans('media::messages.file deleted'));
    }

    public function thumbnail($villa_id,$image_id,Image $image)
    {

        $villa = Villa::find($villa_id);
        $villa->images()->update([
            'thumbnail' => 0
        ]);
        $villa->images()->detach($image_id);
        $villa->images()->attach([$image_id => [
            'thumbnail' => 1
        ]]);
        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('villamanager::images.title.images')]));
        return redirect()->back();
    }
}
