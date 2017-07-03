<?php
/**
 * Created by PhpStorm.
 * User: yusida
 * Date: 3/5/17
 * Time: 3:24 PM
 */

namespace Modules\Villamanager\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class TranslateController extends Controller
{
    public $projectId;
    public $client;
    public function __construct()
    {

    }
    public function translate(Request $request,$to){

        $dom = new \DOMDocument('1.0', 'utf-8');
        $crawler = new Crawler($request->get('description'));
        $crawler = $crawler->filter('*');

        foreach ($crawler as $domElement) {
            if($domElement->nodeName != 'html' && $domElement->nodeName != 'body'){
                $element = $dom->createElement($domElement->nodeName, _t($domElement->nodeValue, [], $to));
                if($domElement->hasAttribute('style')){
                    $attr = $dom->createAttribute('style');
                    $attr->value = $domElement->getAttribute('style');
                    $element->appendChild($attr);

                }
                if($domElement->hasAttribute('class')){
                    $attr = $dom->createAttribute('class');
                    $attr->value = $domElement->getAttribute('class');
                    $element->appendChild($attr);
                }
                if($domElement->hasAttribute('id')){
                    $attr = $dom->createAttribute('id');
                    $attr->value = $domElement->getAttribute('id');
                    $element->appendChild($attr);
                }
                $dom->appendChild($element);
            }
        }

        $dom2 = new \DOMDocument('1.0', 'utf-8');
        $crawler2 = new Crawler($request->get('tos'));
        $crawler2 = $crawler2->filter('*');

        foreach ($crawler2 as $domElement) {
            if($domElement->nodeName != 'html' && $domElement->nodeName != 'body'){
                $element = $dom2->createElement($domElement->nodeName, _t($domElement->nodeValue, [], $to));
                if($domElement->hasAttribute('style')){
                    $attr = $dom2->createAttribute('style');
                    $attr->value = $domElement->getAttribute('style');
                    $element->appendChild($attr);

                }
                if($domElement->hasAttribute('class')){
                    $attr = $dom2->createAttribute('class');
                    $attr->value = $domElement->getAttribute('class');
                    $element->appendChild($attr);
                }
                if($domElement->hasAttribute('id')){
                    $attr = $dom2->createAttribute('id');
                    $attr->value = $domElement->getAttribute('id');
                    $element->appendChild($attr);
                }
                $dom2->appendChild($element);
            }
        }
        return response()->json([
            'locale' => $to,
            'short_description' => $request->get('short_description') != '' ? _t($request->get('short_description'), [], $to) : '',
            'description'       =>  $dom->saveHTML(),
            'tos'                 => $dom2->saveHTML(),
            'meta_title'          => $request->get('meta_title') != '' ? _t($request->get('meta_title'), [], $to) : '',
            'meta_description'    => $request->get('meta_description') != '' ? _t($request->get('meta_description'), [], $to) : '',
        ]);
    }
}