<?php

class ProductsPage extends Page
{


    public function subpages()
    {
        return Pages::factory($this->inventory()['children'], $this);
    }


    public function children()
    {

 
        $apiCache = kirby()->cache('hashandsalt.lemonsqueezy.products');
        $apiData = $apiCache->get('hashandsalt.lemonsqueezy.products');
        site()->products(null);
    
     
            foreach ($apiData['data']  as $key => $productitem) {        
           
                if ($productitem['attributes']['status'] === 'published') {
    
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
                        'thumburl'          => $productitem['attributes']['thumb_url'],
                        'largethumburl'     => $productitem['attributes']['large_thumb_url'],
                        'price'             => $productitem['attributes']['price'],
                        'formattedprice'    => $productitem['attributes']['price_formatted'],
                        'buynowurl'         => $productitem['attributes']['buy_now_url']
                    ]
                ];


            }

            
        
        }
        return Pages::factory($pages, $this);
    }


}