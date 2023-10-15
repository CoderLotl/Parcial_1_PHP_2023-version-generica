<?php

if(isset($_DELETE['id']))
{
    $ventas = DataAccess::ReadFile('Ventas');
    foreach($ventas as $key => $venta)
    {
        if($venta['attributes']['id'] == $_DELETE['id'])
        {
            $params =   [
                            $venta['attributes']['tipo'],
                            $venta['attributes']['sabor'],
                            $venta['attributes']['email'],
                            $venta['attributes']['date']
                        ];
            if(Extras::RemoveImage($params, SALES_IMAGES, SALES_BACKUP_IMAGES))
            {
                unset($ventas[$key]);
                echo "Venta borrada.\n";
                return http_response_code(200);
            }
        }
    }
    echo "No se encontró la venta.\n";
    return http_response_code(200);    
}
else
{    
    echo "Error general en params.";
    return http_response_code(400);
}