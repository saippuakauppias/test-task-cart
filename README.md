# Тестовое задание о продуктах в корзине

![Lint Code Base](https://github.com/saippuakauppias/test-task-cart/workflows/Lint%20Code%20Base/badge.svg)

## Установка и запуск

```bash
git clone git@github.com:saippuakauppias/test-task-cart.git
cd test-task-cart
composer install --dev
vendor/bin/phpunit tests/*.php

php run.php
```

## Условия

Есть продукты A, B, C, D, E, F, G, H, I, J, K, L, M. Каждый продукт стоит определенную сумму.

Есть набор правил расчета итоговой суммы:

1. Если одновременно выбраны А и B, то их суммарная стоимость уменьшается на 10% (для каждой пары А и B)
2. Если одновременно выбраны D и E, то их суммарная стоимость уменьшается на 6% (для каждой пары D и E)
3. Если одновременно выбраны E, F, G, то их суммарная стоимость уменьшается на 3% (для каждой тройки E, F, G)
4. Если одновременно выбраны А и один из [K, L, M], то стоимость выбранного продукта уменьшается на 5%
5. Если пользователь выбрал одновременно 3 продукта, он получает скидку 5% от суммы заказа
6. Если пользователь выбрал одновременно 4 продукта, он получает скидку 10% от суммы заказа
7. Если пользователь выбрал одновременно 5 продуктов, он получает скидку 20% от суммы заказа
8. Описанные скидки 5,6,7 не суммируются, применяется только одна из них
9. Продукты A и C не участвуют в скидках 5,6,7
10. Каждый товар может участвовать только в одной скидке. Скидки применяются последовательно в порядке описанном выше.

### Обязательные требования

- Необходимо написать программу на PHP, которая, имея на входе набор продуктов (один продукт может встречаться несколько раз) рассчитывала суммарную их стоимость.
- Программу необходимо написать максимально просто и максимально гибко. Учесть, что список продуктов практически не будет меняться, также как и типы скидок. В то время как правила скидок (какие типы скидок к каким продуктам) будут меняться регулярно.
- Все параметры задаются в программе статически (пользовательский ввод обрабатывать не нужно).
- Оценивается подход к решению задачи.
- Тщательное тестирование решения проводить не требуется.
- Скрипты обязательно должны выполнять принципы SOLID.
- Необходимо использовать стандарты кодирования PSR [http://www.php-fig.org/](http://www.php-fig.org/)

## Дополнение и исправление условий

1. Производится нормализация списка продуктов, они сортируются по убыванию цены.
2. Правила 5,6,7 применяются в обратном порядке для соблюдения корректности решения.
3. В 4 правиле "выбранным" продуктом считает один из [K, L, M]. К продукту А эта скидка не применяется.

## Пример вывода

В тестовом скрипте выводится всё содержимое корзины, чтоб можно было посмотреть какое правило было применено к тому или иному товару в корзине.

```bash
$ php run.php

object(Saippuakauppias\TestTaskCart\Cart\Cart)#27 (1) {
  ["items":protected]=>
  array(8) {
    [0]=>
    object(Saippuakauppias\TestTaskCart\Cart\CartItem)#34 (2) {
      ["product":protected]=>
      object(Saippuakauppias\TestTaskCart\Products\Product)#12 (2) {
        ["name":protected]=>
        string(1) "J"
        ["price":protected]=>
        float(94.79)
      }
      ["rule":protected]=>
      object(Saippuakauppias\TestTaskCart\Rules\CountBasedRule)#25 (3) {
        ["excludeProducts":protected]=>
        array(2) {
          [0]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#2 (2) {
            ["name":protected]=>
            string(1) "A"
            ["price":protected]=>
            float(15.31)
          }
          [1]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#5 (2) {
            ["name":protected]=>
            string(1) "C"
            ["price":protected]=>
            float(12.11)
          }
        }
        ["count":protected]=>
        int(4)
        ["discount":protected]=>
        float(0.1)
      }
    }
    [1]=>
    object(Saippuakauppias\TestTaskCart\Cart\CartItem)#29 (2) {
      ["product":protected]=>
      object(Saippuakauppias\TestTaskCart\Products\Product)#8 (2) {
        ["name":protected]=>
        string(1) "F"
        ["price":protected]=>
        float(46.13)
      }
      ["rule":protected]=>
      object(Saippuakauppias\TestTaskCart\Rules\ItemsBasedRule)#19 (3) {
        ["needProducts":protected]=>
        array(3) {
          [0]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#7 (2) {
            ["name":protected]=>
            string(1) "E"
            ["price":protected]=>
            float(33.74)
          }
          [1]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#8 (2) {
            ["name":protected]=>
            string(1) "F"
            ["price":protected]=>
            float(46.13)
          }
          [2]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#9 (2) {
            ["name":protected]=>
            string(1) "G"
            ["price":protected]=>
            float(31.55)
          }
        }
        ["applyOnAll":protected]=>
        bool(true)
        ["discount":protected]=>
        float(0.3)
      }
    }
    [2]=>
    object(Saippuakauppias\TestTaskCart\Cart\CartItem)#28 (2) {
      ["product":protected]=>
      object(Saippuakauppias\TestTaskCart\Products\Product)#7 (2) {
        ["name":protected]=>
        string(1) "E"
        ["price":protected]=>
        float(33.74)
      }
      ["rule":protected]=>
      object(Saippuakauppias\TestTaskCart\Rules\ItemsBasedRule)#19 (3) {
        ["needProducts":protected]=>
        array(3) {
          [0]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#7 (2) {
            ["name":protected]=>
            string(1) "E"
            ["price":protected]=>
            float(33.74)
          }
          [1]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#8 (2) {
            ["name":protected]=>
            string(1) "F"
            ["price":protected]=>
            float(46.13)
          }
          [2]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#9 (2) {
            ["name":protected]=>
            string(1) "G"
            ["price":protected]=>
            float(31.55)
          }
        }
        ["applyOnAll":protected]=>
        bool(true)
        ["discount":protected]=>
        float(0.3)
      }
    }
    [3]=>
    object(Saippuakauppias\TestTaskCart\Cart\CartItem)#30 (2) {
      ["product":protected]=>
      object(Saippuakauppias\TestTaskCart\Products\Product)#9 (2) {
        ["name":protected]=>
        string(1) "G"
        ["price":protected]=>
        float(31.55)
      }
      ["rule":protected]=>
      object(Saippuakauppias\TestTaskCart\Rules\ItemsBasedRule)#19 (3) {
        ["needProducts":protected]=>
        array(3) {
          [0]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#7 (2) {
            ["name":protected]=>
            string(1) "E"
            ["price":protected]=>
            float(33.74)
          }
          [1]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#8 (2) {
            ["name":protected]=>
            string(1) "F"
            ["price":protected]=>
            float(46.13)
          }
          [2]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#9 (2) {
            ["name":protected]=>
            string(1) "G"
            ["price":protected]=>
            float(31.55)
          }
        }
        ["applyOnAll":protected]=>
        bool(true)
        ["discount":protected]=>
        float(0.3)
      }
    }
    [4]=>
    object(Saippuakauppias\TestTaskCart\Cart\CartItem)#31 (2) {
      ["product":protected]=>
      object(Saippuakauppias\TestTaskCart\Products\Product)#11 (2) {
        ["name":protected]=>
        string(1) "I"
        ["price":protected]=>
        float(17.43)
      }
      ["rule":protected]=>
      object(Saippuakauppias\TestTaskCart\Rules\CountBasedRule)#25 (3) {
        ["excludeProducts":protected]=>
        array(2) {
          [0]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#2 (2) {
            ["name":protected]=>
            string(1) "A"
            ["price":protected]=>
            float(15.31)
          }
          [1]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#5 (2) {
            ["name":protected]=>
            string(1) "C"
            ["price":protected]=>
            float(12.11)
          }
        }
        ["count":protected]=>
        int(4)
        ["discount":protected]=>
        float(0.1)
      }
    }
    [5]=>
    object(Saippuakauppias\TestTaskCart\Cart\CartItem)#32 (2) {
      ["product":protected]=>
      object(Saippuakauppias\TestTaskCart\Products\Product)#11 (2) {
        ["name":protected]=>
        string(1) "I"
        ["price":protected]=>
        float(17.43)
      }
      ["rule":protected]=>
      object(Saippuakauppias\TestTaskCart\Rules\CountBasedRule)#25 (3) {
        ["excludeProducts":protected]=>
        array(2) {
          [0]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#2 (2) {
            ["name":protected]=>
            string(1) "A"
            ["price":protected]=>
            float(15.31)
          }
          [1]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#5 (2) {
            ["name":protected]=>
            string(1) "C"
            ["price":protected]=>
            float(12.11)
          }
        }
        ["count":protected]=>
        int(4)
        ["discount":protected]=>
        float(0.1)
      }
    }
    [6]=>
    object(Saippuakauppias\TestTaskCart\Cart\CartItem)#33 (2) {
      ["product":protected]=>
      object(Saippuakauppias\TestTaskCart\Products\Product)#11 (2) {
        ["name":protected]=>
        string(1) "I"
        ["price":protected]=>
        float(17.43)
      }
      ["rule":protected]=>
      object(Saippuakauppias\TestTaskCart\Rules\CountBasedRule)#25 (3) {
        ["excludeProducts":protected]=>
        array(2) {
          [0]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#2 (2) {
            ["name":protected]=>
            string(1) "A"
            ["price":protected]=>
            float(15.31)
          }
          [1]=>
          object(Saippuakauppias\TestTaskCart\Products\Product)#5 (2) {
            ["name":protected]=>
            string(1) "C"
            ["price":protected]=>
            float(12.11)
          }
        }
        ["count":protected]=>
        int(4)
        ["discount":protected]=>
        float(0.1)
      }
    }
    [7]=>
    object(Saippuakauppias\TestTaskCart\Cart\CartItem)#35 (2) {
      ["product":protected]=>
      object(Saippuakauppias\TestTaskCart\Products\Product)#2 (2) {
        ["name":protected]=>
        string(1) "A"
        ["price":protected]=>
        float(15.31)
      }
      ["rule":protected]=>
      NULL
    }
  }
}

Full price: 273.81
Discount price: 225.68
```