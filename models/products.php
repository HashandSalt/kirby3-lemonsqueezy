<?php

class ProductsPage extends Page
{


    public function subpages()
    {
        return Pages::factory($this->inventory()['children'], $this);
    }


    public function children()
    {
        $url = 'https://api.lemonsqueezy.com/v1/products';
    
        $key = kirby()->option('hashandsalt.lemonsqueezy.testmode') === true ? kirby()->option('hashandsalt.lemonsqueezy.testapikey') : kirby()->option('hashandsalt.lemonsqueezy.liveapikey') ;
        
        $data = [];
        $options = [
            'headers' => [
                 'Authorization: Bearer ' . $key,
                 'Accept: application/vnd.api+json',
                 'Content-Type: application/vnd.api+json'
            ],
            'method'  => 'GET',
            'data'    => json_encode($data)
         ];

         $apiCache = kirby()->cache('hashandsalt.lemonsqueezy.products');
         $apiData  = $apiCache->get('hashandsalt.lemonsqueezy.products');


        $request = Remote::request($url, $options);

        if ($apiData === null) {
      
          

            if ($request->code() === 200) {
                $data = $request;
                $data = json_decode($data->content)->data;
                $apiCache->set('hashandsalt.lemonsqueezy.products', $data);
            }


          }
        
        


          foreach ($apiData  as $key => $productitem) {        
           
  
    
          $key++;
          
          $slug = $productitem['attributes']['slug'];
          $page = $this->subpages()->find($slug);

           $pages[] = [
              'slug'     => $productitem['attributes']['slug'],
           
             
              'template' => kirby()->option('hashandsalt.lemonsqueezy.template'),
              'model'    => kirby()->option('hashandsalt.model'),
              // 'dirname' => $key.'_'.$productitem->attributes->slug,
              'num'      => $key,
              'files'    => $page ? $page->files()->toArray() : null,
              'content'  => [
                  'title'             => $productitem['attributes']['name'],
                  'description'       => $productitem['attributes']['description'],
                  'product_status'    => $productitem['attributes']['status'],
                  'thumb_url'         => $productitem['attributes']['thumb_url'],
                  'large_thumb_url'   => $productitem['attributes']['large_thumb_url'],
                  'price'             => $productitem['attributes']['price'],
                  'formatted_price'   => $productitem['attributes']['price_formatted'],
                  'buy_now_url'       => $productitem['attributes']['buy_now_url']
              ]
          ];
      }

     return Pages::factory($pages, $this);
    }
}