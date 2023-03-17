# WARNING This plugin is shiny new beta! Use with caution and please feedback any issues via Github issues if you have any problems.  

# Kirby3 Lemon Squeezy

A plugin for working with the Lemon Squeezy API. 

Features

* Fetch Store(s)
* Fetch Product(s)
* Turns products into virtual pages 


## Config

Add your API keys to the `Config.php`

```
// API Keys
'hashandsalt.lemonsqueezy.testmode' => true, // flick to false in to use the live API
'hashandsalt.lemonsqueezy.testapikey' => 'XXX',
'hashandsalt.lemonsqueezy.liveapikey' => 'XXX'
```

Change the default template and model for the virtual pages (optional)

```
// Virtual Pages
'hashandsalt.lemonsqueezy.template' => 'products',
'hashandsalt.lemonsqueezy.model' => 'products',
```

## Usage

### Fetching store data

An array of all stores

```
$stores = $page->stores();
```

A specific store by ID

```
$store = $page->store('11087');
```

### Fetching product data


An array of all products

```
$products = $page->products();
```

A specific product by ID

```
$product = $page->product('22352');
```

## Virtual Pages

Available fields in the virtual pages

```
'title'             => $productitem->attributes->name,
'description'       => $productitem->attributes->description,
'product_status'    => $productitem->attributes->status,
'thumb_url'         => $productitem->attributes->thumb_url,
'large_thumb_url'   => $productitem->attributes->large_thumb_url,
'price'             => $productitem->attributes->price,
'formatted_price'   => $productitem->attributes->price_formatted,
'buy_now_url'       => $productitem->attributes->buy_now_url
```