<?php

namespace HashAndSalt\Lemon;

@include_once __DIR__ . '/vendor/autoload.php';

use Kirby\Http\Remote;


class Squeezy {

    

    public function endpoint($end)
    {
    $url = 'https://api.lemonsqueezy.com/v1/' . $end;
 
    $key = kirby()->option('hashandsalt.lemonsqueezy.testmode') === true ? kirby()->option('hashandsalt.lemonsqueezy.testapikey') : kirby()->option('hashandsalt.lemonsqueezy.liveapikey') ;
        
    $data = '';
    $options = [
        'headers' => [
             'Authorization: Bearer ' . $key,
             'Accept: application/vnd.api+json',
             'Content-Type: application/vnd.api+json'
        ],
        'method'  => 'GET',
        'data'    => json_encode($data)
     ];
    $request = Remote::request($url, $options);
    
    if ($request->code() === 200) {
        $data = $request;
    }


    return $data;
      
    }

    /**
     * Fetches Lsst of Stores
     *

     * @return array
     */
    public function stores()
    {
  
        $stores = self::endpoint('stores')->content;
        $list = json_decode($stores)->data;
        return $list;
        
    }

    /**
     * Fetch Single Store
     *

     * @return array
     */
    public function store($id)
    {
  
        $data = self::endpoint('stores/'.$id)->content;
    
        return json_decode($data)->data;
        
    }


    /**
     * Fetches Lsst of Products
     *

     * @return mixed
     */
    public function products()
    {
  
        $products = self::endpoint('products')->content;
        $list = json_decode($products);
        return $list;
        
    }

    /**
     * Fetch Single Product
     *

     * @return array
     */
    public function product($id)
    {
  
        $product = self::endpoint('products/'.$id)->content;
    
        return json_decode($product);
        
    }
}
