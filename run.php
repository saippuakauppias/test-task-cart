<?php

require_once __DIR__ . '/vendor/autoload.php';

use Saippuakauppias\TestTaskCart\Cart\{Cart, CartItem};
use Saippuakauppias\TestTaskCart\Products\{Product, ProductManager};
use Saippuakauppias\TestTaskCart\Rules\{ItemsBasedRuleManager, ItemsBasedRule, CountBasedRuleManager, CountBasedRule};

$pm = new ProductManager();
$pm->addProduct(new Product('A', 15.31));
$pm->addProduct(new Product('B', 25.42));
$pm->addProduct(new Product('C', 12.11));
$pm->addProduct(new Product('D', 41.65));
$pm->addProduct(new Product('E', 33.74));
$pm->addProduct(new Product('F', 46.13));
$pm->addProduct(new Product('G', 31.55));
$pm->addProduct(new Product('H', 103.43));
$pm->addProduct(new Product('I', 17.43));
$pm->addProduct(new Product('J', 94.79));
$pm->addProduct(new Product('K', 65.42));
$pm->addProduct(new Product('L', 76.87));
$pm->addProduct(new Product('M', 3.01));


$itemsRM = new ItemsBasedRuleManager();
$itemsRM->addRule(
    new ItemsBasedRule(
        [
            $pm->getProductByName('A'),
            $pm->getProductByName('B'),
        ],
        0.1
    )
);
$itemsRM->addRule(
    new ItemsBasedRule(
        [
            $pm->getProductByName('D'),
            $pm->getProductByName('E'),
        ],
        0.06
    )
);
$itemsRM->addRule(
    new ItemsBasedRule(
        [
            $pm->getProductByName('E'),
            $pm->getProductByName('F'),
            $pm->getProductByName('G'),
        ],
        0.3
    )
);
$itemsRM->addRule(
    new ItemsBasedRule(
        [
            $pm->getProductByName('A'),
            $pm->getProductByName('K'),
        ],
        0.05,
        false
    )
);
$itemsRM->addRule(
    new ItemsBasedRule(
        [
            $pm->getProductByName('A'),
            $pm->getProductByName('L'),
        ],
        0.05,
        false
    )
);
$itemsRM->addRule(
    new ItemsBasedRule(
        [
            $pm->getProductByName('A'),
            $pm->getProductByName('M'),
        ],
        0.05,
        false
    )
);

$countRM = new CountBasedRuleManager();
$countRM->addRule(
    new CountBasedRule(
        [
            $pm->getProductByName('A'),
            $pm->getProductByName('C'),
        ],
        0.2,
        5
    )
);
$countRM->addRule(
    new CountBasedRule(
        [
            $pm->getProductByName('A'),
            $pm->getProductByName('C'),
        ],
        0.1,
        4
    )
);
$countRM->addRule(
    new CountBasedRule(
        [
            $pm->getProductByName('A'),
            $pm->getProductByName('C'),
        ],
        0.05,
        3
    )
);

$cart = new Cart();
$cart->addItem(new CartItem($pm->getProductByName('E')));
$cart->addItem(new CartItem($pm->getProductByName('F')));
$cart->addItem(new CartItem($pm->getProductByName('G')));
$cart->addItem(new CartItem($pm->getProductByName('I')));
$cart->addItem(new CartItem($pm->getProductByName('I')));
$cart->addItem(new CartItem($pm->getProductByName('I')));
$cart->addItem(new CartItem($pm->getProductByName('J')));
$cart->addItem(new CartItem($pm->getProductByName('A')));

$cart->applyRules($itemsRM);
$cart->applyRules($countRM);

// result
var_dump($cart);
echo 'Full price: ' . $cart->getFullPrice() . PHP_EOL;
echo 'Discount price: ' . $cart->getDiscountPrice() . PHP_EOL;
