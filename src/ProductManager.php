<?php
declare(strict_types=1);
namespace Saippuakauppias\TestCart;

use Saippuakauppias\TestCart\Product;


class ProductManager
{
    protected $products = [];

    public function addProduct(Product $product) {
        $this->products[$product->getName()] = $product;
    }

    public function getPriceByName(string $name): float {
        $this->checkProductNameExists($name);

        return $this->products[$name]->getPrice();
    }

    public function getProductByName(string $name): Product {
        $this->checkProductNameExists($name);

        return $this->products[$name];
    }

    private function checkProductNameExists(string $name) {
        if (!\array_key_exists($name, $this->products)) {
            throw new \Exception('Product with name "' . $name . '" not found!');
        }
    }
}
