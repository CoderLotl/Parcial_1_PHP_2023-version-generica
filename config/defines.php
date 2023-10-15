<?php

define('APP_ROOT', dirname(dirname(__FILE__)));
define('elements', ['Pizzas', 'Ventas']);
define ('ITEMS', [  'Pizzas' => ['cantidad', 'precio', 'sabor', 'tipo'],
                    'Ventas' => ['email', 'sabor', 'tipo', 'cantidad'] ]);
define('SALES_IMAGES', APP_ROOT . '/ImagenesDeLaVenta');
define('PIZZA_IMAGES', APP_ROOT . '/ImagenesDePizzas');