<?php

if(isset($_REQUEST['create']) && in_array($_REQUEST['create'], array_keys(ITEMS)) && isset($_REQUEST['params']))
{
    if($_REQUEST['create'] === 'Ventas' && $_REQUEST['params']['email'] !== '' && filter_var($_REQUEST['params']['email'], FILTER_VALIDATE_EMAIL))
    {
        $requestParamsKeys = array_keys($_REQUEST['params']);

        if( count(array_intersect(ITEMS[$_REQUEST['create']], $requestParamsKeys)) === count(ITEMS[$_REQUEST['create']]) )
        {
            $params = [
                        "sabor" => $_REQUEST['params']['sabor'],
                        "tipo" => $_REQUEST['params']['tipo'],
                        "cantidad" => $_REQUEST['params']['cantidad']
                    ];            

            if(ItemManager::SearchMultipleParams($params, 'Pizzas'))
            {
                $venta = new Venta($_REQUEST['params']);

                $pizzas = DataAccess::ReadFile('Pizzas');
                foreach($pizzas as &$pizza)
                {
                    if($pizza['attributes']['sabor'] == $params['sabor'] && $pizza['attributes']['cantidad'] >= $params['cantidad'] && $pizza['attributes']['tipo'] == $params['tipo'])
                    {
                        $pizza['attributes']['cantidad'] -= $params['cantidad'];
                        break;
                    }
                }
                DataAccess::WriteFile('Pizzas', $pizzas);
                ItemManager::SaveVenta($venta);
                echo 'Venta realizada.';
                return http_response_code(200);                
            }
            else
            {
                echo 'No hay del producto buscado.';
                return http_response_code(400);
            }            
        }
        else
        {
            echo var_dump($_REQUEST['params']);
            echo 'error en params';
            return http_response_code(400);
        }
    }
    else
    {
        echo 'Item o mail no validos';
        return http_response_code(400);
    }
}
echo 'error general';
return http_response_code(400);