<?php
use PHPUnit\Framework\TestCase;
use Saippuakauppias\TestCart\Cart\Cart;
use Saippuakauppias\TestCart\Cart\CartItem;
use Saippuakauppias\TestCart\Products\Product;
use Saippuakauppias\TestCart\Products\ProductManager;
use Saippuakauppias\TestCart\Rules\ItemsBasedRuleManager;
use Saippuakauppias\TestCart\Rules\ItemsBasedRule;
use Saippuakauppias\TestCart\Rules\CountBasedRuleManager;
use Saippuakauppias\TestCart\Rules\CountBasedRule;

class CartTests extends TestCase
{
    protected $productManager;

    protected $itemsRM;

    protected $countRM;

    protected function setUp(): void
    {
        $this->productManager = new ProductManager();
        $this->productManager->addProduct(new Product('A', 15.31));
        $this->productManager->addProduct(new Product('B', 25.42));
        $this->productManager->addProduct(new Product('C', 12.11));
        $this->productManager->addProduct(new Product('D', 41.65));
        $this->productManager->addProduct(new Product('E', 33.74));
        $this->productManager->addProduct(new Product('F', 46.13));
        $this->productManager->addProduct(new Product('G', 31.55));
        $this->productManager->addProduct(new Product('H', 103.43));
        $this->productManager->addProduct(new Product('I', 17.43));
        $this->productManager->addProduct(new Product('J', 94.79));
        $this->productManager->addProduct(new Product('K', 65.42));
        $this->productManager->addProduct(new Product('L', 76.87));
        $this->productManager->addProduct(new Product('M', 3.01));

        $this->itemsRM = new ItemsBasedRuleManager();
        $this->itemsRM->addRule(
            new ItemsBasedRule(
                [
                    $this->productManager->getProductByName('A'),
                    $this->productManager->getProductByName('B'),
                ],
                0.1
            )
        );
        $this->itemsRM->addRule(
            new ItemsBasedRule(
                [
                    $this->productManager->getProductByName('D'),
                    $this->productManager->getProductByName('E'),
                ],
                0.06
            )
        );
        $this->itemsRM->addRule(
            new ItemsBasedRule(
                [
                    $this->productManager->getProductByName('E'),
                    $this->productManager->getProductByName('F'),
                    $this->productManager->getProductByName('G'),
                ],
                0.03
            )
        );
        $this->itemsRM->addRule(
            new ItemsBasedRule(
                [
                    $this->productManager->getProductByName('A'),
                    $this->productManager->getProductByName('K'),
                ],
                0.05,
                false
            )
        );
        $this->itemsRM->addRule(
            new ItemsBasedRule(
                [
                    $this->productManager->getProductByName('A'),
                    $this->productManager->getProductByName('L'),
                ],
                0.05,
                false
            )
        );
        $this->itemsRM->addRule(
            new ItemsBasedRule(
                [
                    $this->productManager->getProductByName('A'),
                    $this->productManager->getProductByName('M'),
                ],
                0.05,
                false
            )
        );

        $this->countRM = new CountBasedRuleManager();
        $this->countRM->addRule(
            new CountBasedRule(
                [
                    $this->productManager->getProductByName('A'),
                    $this->productManager->getProductByName('C'),
                ],
                0.2,
                5
            )
        );
        $this->countRM->addRule(
            new CountBasedRule(
                [
                    $this->productManager->getProductByName('A'),
                    $this->productManager->getProductByName('C'),
                ],
                0.1,
                4
            )
        );
        $this->countRM->addRule(
            new CountBasedRule(
                [
                    $this->productManager->getProductByName('A'),
                    $this->productManager->getProductByName('C'),
                ],
                0.05,
                3
            )
        );
    }

    public function testVariant1()
    {
        $cart = new Cart();
        $cart->addItem(new CartItem($this->productManager->getProductByName('A')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('B')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('D')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('E')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('E')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('F')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('G')));

        $cart->applyRules($this->itemsRM);
        $cart->applyRules($this->countRM);

        $this->assertSame(227.54, $cart->getFullPrice());
        $this->assertSame(215.60, $cart->getDiscountPrice());
    }

    public function testVariant2()
    {
        $cart = new Cart();
        $cart->addItem(new CartItem($this->productManager->getProductByName('A')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('B')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('D')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('E')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('I')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('I')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('I')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('I')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('C')));

        $cart->applyRules($this->itemsRM);
        $cart->applyRules($this->countRM);

        $this->assertSame(197.95, $cart->getFullPrice());
        $this->assertSame(182.38, $cart->getDiscountPrice());
    }

    public function testVariant3()
    {
        $cart = new Cart();
        $cart->addItem(new CartItem($this->productManager->getProductByName('I')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('J')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('H')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('I')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('I')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('C')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('A')));

        $cart->applyRules($this->itemsRM);
        $cart->applyRules($this->countRM);

        $this->assertSame(277.93, $cart->getFullPrice());
        $this->assertSame(227.83, $cart->getDiscountPrice());
    }

    public function testVariant4()
    {
        $cart = new Cart();
        $cart->addItem(new CartItem($this->productManager->getProductByName('A')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('B')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('C')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('C')));
        $cart->addItem(new CartItem($this->productManager->getProductByName('C')));

        $cart->applyRules($this->itemsRM);
        $cart->applyRules($this->countRM);

        $this->assertSame(77.06, $cart->getFullPrice());
        $this->assertSame(72.99, $cart->getDiscountPrice());
    }
}
