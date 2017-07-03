<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->get('villamanagers/checkprice/{id}', ['uses' => 'BookingController@checkprice', 'as' => 'api.villamanger.checkprice']);
$router->get('villamanagers/bookingdate/{id}', ['uses' => 'BookingController@bookingdate', 'as' => 'api.villamanger.bookingdate']);
$router->get('villamanagers/unavailabledate', ['uses' => 'BookingController@unavailableDate', 'as' => 'api.villamanger.unavailabledate']);
$router->post('villamanagers/images/{id}', ['uses' => 'ImageController@update', 'as' => 'api.villamanager.image.update']);
/** @var Router $router */
$router->group(['prefix' => 'villamanagers', 'middleware' => 'api.token'], function (Router $router) {

    $router->post('villas/{id}/images', [
        'as' => 'api.villamanager.image.store',
        'uses' => 'ImageController@store'
    ]);

    $router->post('translate/{to}', [
        'as' => 'api.villamanager.translate',
        'uses' => 'TranslateController@translate'
    ]);

    $router->post('booking/import/{id}',[
        'as' => 'api.villamanager.booking.import',
        'uses' => 'BookingController@import'
    ]);

    $router->get('booking/reports',[
        'as' => 'api.villamanager.booking.report',
        'uses' => 'BookingController@bookingReport'
    ]);
});

$router->post('tripadvisor/grab/{id}',function($id){
    $villa = \Modules\Villamanager\Entities\Villa::find($id);
    if(!$villa->tripadvisor)
        return 0;
    $client = new GuzzleHttp\Client();
    $response = $client->get($villa->tripadvisor->url);
    $html = (string) $response->getBody(true);

    $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
    $crawler2 = $crawler->filter('div.rating > span');
    $bintang = $crawler2->filter('.rate > img')->attr('class');
    $rate = preg_replace("/[^0-9]/","",$bintang);

    $text = $crawler2->filter('.rating-in-language')->text();

    $total = preg_replace("/[^0-9]/","",$crawler->filter('.based-on-n-reviews')->text());

    $villa->tripadvisor()->update([
        'rate' => $rate,
        'text' => $text,
        'total_review' => $total
    ]);
    return response([
        'rate' => $rate,
        'text' => $text,
        'total_review' => $total
    ]);
})->name('api.tripadvisor.grab');

$router->group(['prefix' => 'midtrans'],function (Router $router){

    $router->post('notification',[
        'as' => 'midtrans.notification',
        'uses'  => 'MidtransController@notification'
    ]);

    $router->post('finish',[
        'as' => 'midtrans.finish',
        'uses'  => 'MidtransController@finish'
    ]);
    $router->get('finish',[
        'as' => 'midtrans.finish',
        'uses'  => 'MidtransController@finish'
    ]);
    $router->get('finish/{id}',[
        'as' => 'midtrans.finish2',
        'uses'  => 'MidtransController@finish'
    ]);

});