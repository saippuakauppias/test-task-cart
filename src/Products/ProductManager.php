<?php
declare(strict_types=1);
namespace Saippuakauppias\TestTaskCart\Products;

use Saippuakauppias\TestTaskCart\Products\Product;

class ProductManager
{
    protected $products = [];

    /**
     * Add Product to manager
     *
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $this->products[$product->getName()] = $product;
    }

    /**
     * Get Product object by product name
     *
     * @param string $name
     */
    public function getProductByName(string $name): Product
    {
        $this->checkProductNameExists($name);

        return $this->products[$name];
    }

    private function checkProductNameExists(string $name)
    {
        if (!\array_key_exists($name, $this->products)) {
            throw new \Exception('Product with name "' . $name . '" not found!');
        }
    }
}
