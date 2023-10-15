<?php

if(isset($_REQUEST['create']) && in_array($_REQUEST['create'], array_keys(ITEMS)) && isset($_REQUEST['params']))
{
    if($_REQUEST['create'] === 'Pizzas')
    {
        $requestParamsKeys = array_keys($_REQUEST['params']);
        
        if( count(array_intersect(ITEMS[$_REQUEST['create']], $requestParamsKeys)) === count(ITEMS[$_REQUEST['create']]) )
        {
            $item = new Pizza($_REQUEST['params']);
    
            if(ItemManager::SavePizza($item))
            {
                echo "Success!";

                if($_SERVER['REQUEST_METHOD'] === 'POST')
                {
                    Extras::UploadImage( [ $_REQUEST['params']['tipo'], $_REQUEST['params']['sabor'], $_REQUEST['params']['email'] ], PIZZA_IMAGES, "Pizzas");
                }

                return http_response_code(200);
            }
        }        
        else
        {
            echo 'error en params';
            return http_response_code(400);
        }
    }
    else
    {
        echo 'Item no valido';
        return http_response_code(400);
    }
}

echo 'error general';
return http_response_code(400);