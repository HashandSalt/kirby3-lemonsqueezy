<?php

@include_once __DIR__ . '/vendor/autoload.php';

load([
    'hashandsalt\\lemon\\squeezy' => 'src/classes/LemonSqueezy.php',
], __DIR__);


use HashAndSalt\Lemon\Squeezy;

require __DIR__ . '/models/products.php';

Kirby::plugin('hashandsalt/lemonsqueezy', [
	// Options


    'options' => [
        'cache.products' => true,
        'template' => kirby()->option('hashandsalt.lemonsqueezy.template'),
        'model' => kirby()->option('hashandsalt.lemonsqueezy.model')
		
	],

    'blueprints' => [
		'product'    => __DIR__ . '/blueprints/pages/product.yml',

	],

	'pageModels' => [
		'products' => 'ProductsPage'

	],


    # Page methods
    'pageMethods' => [
        'stores' => function () {
            $init = new Squeezy();
            return $init->stores();
        },
		'store' => function ($id) {
            $init = new Squeezy();
            return $init->store($id);
        },

		'products' => function ($id) {
            $init = new Squeezy();
            return $init->products($id);
        },
		'product' => function ($id) {
            $init = new Squeezy();
            return $init->product($id);
        },


    ],


]);
