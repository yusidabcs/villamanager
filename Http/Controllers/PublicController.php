<?php namespace Modules\Villamanager\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Villamanager\Repositories\VillaRepository;
use Illuminate\Http\Request;
use Modules\Villamanager\Entities\Villa;
class PublicController extends BasePublicController
{
    /**
     * @var PageRepository
     */
    private $villa;
    /**
     * @var Application
     */
    private $app;

    public function __construct(VillaRepository $villa, Application $app)
    {
        parent::__construct();
        $this->villa = $villa;
        $this->app = $app;
    }

    /**
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function uri($slug)
    {
        $villa = $this->villa->findBySlug($slug);

        $this->throw404IfNotFound($villa);
        $template = 'villas.show';

        return view($template, compact('villa'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function homepage(Request $request)
    {   
        return view('villas.index');
    }

    /**
     * Return the template for the given page
     * or the default template if none found
     * @param $page
     * @return string
     */
    private function getTemplateForPage($page)
    {
        return (view()->exists($page->template)) ? $page->template : 'default';
    }

    /**
     * Throw a 404 error page if the given page is not found
     * @param $page
     */
    private function throw404IfNotFound($page)
    {
        if (is_null($page)) {
            $this->app->abort('404');
        }
    }
}
