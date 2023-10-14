<?php

if(isset($_REQUEST['search']) && $_REQUEST['search'] === 'Pizzas' && isset($_REQUEST['params']))
{
    if(in_array($_REQUEST['search'], array_keys(ITEMS)))
    {
        $requestParamsKeys = array_keys($_REQUEST['params']);

        foreach($requestParamsKeys as $param)
        {
            if(!in_array($param, ITEMS[$_REQUEST['search']]))
            {
                echo "{$param} no existe.";
                return http_response_code(400);
            }
            if( ItemManager::SearchMultipleParams($_REQUEST['params'], $_REQUEST['search']))
            {
                echo 'Si hay.';
                return http_response_code(200);
            }
            else
            {
                echo 'No hay.';
                return http_response_code(400);
            }
        }
    }
}

echo 'error general';
return http_response_code(400);