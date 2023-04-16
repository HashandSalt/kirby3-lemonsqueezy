<?php

namespace HashAndSalt\Lemon;

@include_once __DIR__ . '/vendor/autoload.php';

use Kirby\Http\Remote;


class Squeezy {

    

    public function endpoint($end, $cacheName)
    {


    $url = 'https://api.lemonsqueezy.com/v1/' . $end;
 
    $key = kirby()->option('hashandsalt.lemonsqueezy.testmode') === true ? kirby()->option('hashandsalt.lemonsqueezy.testapikey') : kirby()->option('hashandsalt.lemonsqueezy.liveapikey') ;
        
    $data = null;
    $options = [
        'headers' => [
             'Authorization: Bearer ' . $key,
             'Accept: application/vnd.api+json',
             'Content-Type: application/vnd.api+json'
        ],
        'method'  => 'GET',
        'data'    => json_encode($data)
     ];

    $cacheName = 'hashandsalt.lemonsqueezy.' . $cacheName;


    $apiCache = kirby()->cache($cacheName);
    $apiData  = $apiCache->get($cacheName);

  
    


    if ($apiData === null) {   
        $request = Remote::request($url, $options);

        if ($request->code() === 200) {
            $data = $request;
            $data = json_decode($data->content);
            $apiCache->set($cacheName, $data);
        }


      } 


    return $apiData;
      
    }

    /**
     * Fetches Lsst of Stores
     *

     * @return array
     */
    public function stores()
    {
  
        $stores = self::endpoint('stores', 'stores');
      
        return $stores;
        
    }

    /**
     * Fetch Single Store
     *

     * @return array
     */
    public function store($id)
    {
        
        $store = self::endpoint('stores/'. $id, 'store');
    
        return $store;
        
    }


    /**
     * Fetches Lsst of Products
     *

     * @return mixed
     */
    public function products($id, $cacheName)
    {
        if ($id === null) {
            $products = self::endpoint('products', $cacheName);
        } else {
            $end = '?filter[store_id]='.$id;
            $products = self::endpoint($end, $cacheName);
        }
        return $products;        
    }

    /**
     * Fetch Single Product
     *

     * @return array
     */
    public function product($id)
    {
        $cache = 'product';
        $product = self::endpoint('products/'.$id, $cache);
    
        return $product;
        
    }
}
