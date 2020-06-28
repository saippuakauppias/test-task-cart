<?php

require_once __DIR__ . '/vendor/autoload.php';

use Saippuakauppias\TestCart\{Product, ProductManager, Cart, CartItem, Rule, RuleManager};


$pm = new ProductManager();
$pm->addProduct(new Product('A', 100));
$pm->addProduct(new Product('B', 110));
$pm->addProduct(new Product('C', 120));
$pm->addProduct(new Product('D', 130));
$pm->addProduct(new Product('E', 140));
$pm->addProduct(new Product('F', 150));
$pm->addProduct(new Product('G', 160));
$pm->addProduct(new Product('H', 170));
$pm->addProduct(new Product('I', 180));
$pm->addProduct(new Product('J', 190));
$pm->addProduct(new Product('K', 200));
$pm->addProduct(new Product('L', 210));
$pm->addProduct(new Product('M', 220));

$rm = new RuleManager();
$rm->addRule(
    new Rule(
        [
            $pm->getProductByName('A'),
            $pm->getProductByName('B'),
        ],
        0.1
    )
);
$rm->addRule(
    new Rule(
        [
            $pm->getProductByName('D'),
            $pm->getProductByName('E'),
        ],
        0.06
    )
);
$rm->addRule(
    new Rule(
        [
            $pm->getProductByName('E'),
            $pm->getProductByName('F'),
            $pm->getProductByName('G'),
        ],
        0.3
    )
);
$rm->addRule(
    new Rule(
        [
            $pm->getProductByName('A'),
            $pm->getProductByName('K'),
        ],
        0.05,
        false
    )
);
$rm->addRule(
    new Rule(
        [
            $pm->getProductByName('A'),
            $pm->getProductByName('L'),
        ],
        0.05,
        false
    )
);
$rm->addRule(
    new Rule(
        [
            $pm->getProductByName('A'),
            $pm->getProductByName('M'),
        ],
        0.05,
        false
    )
);



$cart = new Cart();
$cart->addItem(new CartItem($pm->getProductByName('E')));
$cart->addItem(new CartItem($pm->getProductByName('F')));
$cart->addItem(new CartItem($pm->getProductByName('G')));
$cart->addItem(new CartItem($pm->getProductByName('A')));
$cart->addItem(new CartItem($pm->getProductByName('M')));

$cart->applyRules($rm);


$price_full = $cart->getFullPrice();
$price_discount = $cart->getDiscountPrice();

var_dump($cart);
echo 'Full price: ' . $price_full . PHP_EOL;
echo 'Discount price: ' . $price_discount . PHP_EOL;
