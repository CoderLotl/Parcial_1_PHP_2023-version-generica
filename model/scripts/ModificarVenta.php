<?php

if(isset($_PUT['id']) && count(array_intersect( array_intersect(array_keys($_PUT['params']), ITEMS['Ventas']))) == count(ITEMS['Ventas']) /*&& array_intersect($_PUT['newParams'], ITEMS['Ventas']) === count(ITEMS['Ventas'])*/)
{
    $searchParams = $_PUT['params'];
    $searchParams['id'] = $_PUT['id'];
    
    if(ItemManager::SearchMultipleParams($searchParams, 'Ventas', true))
    {
        $ventas = DataAccess::ReadFile('Ventas');

        foreach($ventas as &$venta)
        {
            //echo count( array_diff_assoc($searchParams, $venta['attributes']) );
            if( count( array_diff_assoc($searchParams, $venta['attributes']) ) == 0 )
            {
                $venta['attributes'] = array_replace($venta['attributes'], $_PUT['newParams']);
                echo "ding!";
                break;
            }
            /**
             * NOTA: si hubiera sabido de array_diff_assoc antes me habría ahorrado como 1 o 2 horas de desarrollo,
             * inventando un mecanismo cuyo resultado me llevara a JUSTAMENTE ESO, LPM!!
             * Debería reescribir SearchMultipleParams, pero la verdad... Mejor que quede como testimonio.
             * */ 
            
        }
        DataAccess::WriteFile('Ventas', $ventas);
        echo "Venta modificada con éxito.\n";
        return http_response_code(200);
    }
    else
    {
        echo "La venta buscada no existe.\n";
        return http_response_code(200);
    }
}
else
{    
    echo "Error general en params.";
    return http_response_code(400);
}