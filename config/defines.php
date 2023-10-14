<?php

define('APP_ROOT', dirname(dirname(__FILE__)));
define('elements', ['Pizzas', 'Ventas']);
define ('ITEMS', [  'Pizzas' => ['cantidad', 'precio', 'sabor', 'tipo'],
                    'Ventas' => ['email', 'sabor', 'tipo', 'cantidad'] ]);
define('IMAGES', APP_ROOT . '/ImagenesDeLaVenta');