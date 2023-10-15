<?php

if(isset($_REQUEST['busqueda']))
{
    switch($_REQUEST['busqueda'])
    {
        case 'ventas':
            return ContarVentas();
            break;
        case 'fechas':
            return VentasEntreFechas();
            break;
        case 'usuario':
            return VentasPorUsuario();
            break;
        case 'sabor':
            return VentasPorSabor();
            break;
    }
    
}

echo 'error general';
return http_response_code(400);

function ContarVentas()
{
    $ventas = ItemManager::CountItems('Ventas');
    if($ventas > 0)
    {
        if($ventas > 1)
        {
            echo "Hubo {$ventas} ventas.\n";
        }
        else
        {
            echo "Hubo {$ventas} venta.\n";
        }
    }
    else
    {
        echo "No hubo ventas.\n";
    }    
    return http_response_code(200);
}

function VentasEntreFechas()
{
    if(isset($_REQUEST['fecha1']) && Extras::CheckDate($_REQUEST['fecha1']) && isset($_REQUEST['fecha2']) && Extras::CheckDate($_REQUEST['fecha2']))
    {
        $date1 = $_REQUEST['fecha1'];
        $date2 = $_REQUEST['fecha2'];

        $ventas = DataAccess::ReadFile('Ventas');
        $filteredSales = [];
        if(count($ventas) > 0)
        {
            foreach($ventas as $venta)
            {
                $date = $venta['attributes']['date'];                
                if($date >= $date1 && $date <= $date2)
                {                    
                    $filteredSales[] = $venta;
                }
            }

            if(count($filteredSales) > 0)
            {
                usort($filteredSales, function($a, $b)
                {
                    return strcmp($a['attributes']['sabor'], $b['attributes']['sabor']);
                });
                foreach($filteredSales as $sale)
                {
                    $venta = new Venta($sale['attributes']);
                    echo $venta->__toString() . "\n";
                }
            }
            else
            {
                echo "No hubo ventas entre esas fechas.";
            }
        }
        else
        {
            echo "No hay ventas para buscar.\n";            
        }
        return http_response_code(200);
    }
    else
    {
        echo "Error de params.\n";
        return http_response_code(400);
    }
}

function VentasPorUsuario()
{
    if(isset($_REQUEST['usuario']) && !empty($_REQUEST['usuario']))
    {
        $ventas = DataAccess::ReadFile('Ventas');
        $ventasFiltradas = [];
        foreach($ventas as $venta)
        {
            if($venta['attributes']['email'] == $_REQUEST['usuario'])
            {
                $unaVenta = new Venta($venta['attributes']);
                $ventasFiltradas[] = $unaVenta;
            }
        }
        if(count($ventasFiltradas) > 0)
        {
            foreach($ventasFiltradas as $venta)
            {
                echo $venta->__toString() . "\n";
            }
        }
        else
        {
            echo "No hubo ventas a este usuario.\n";
        }
        return http_response_code(200);
    }
    else
    {
        echo "Error de params.\n";
        return http_response_code(400);
    }
}

function VentasPorSabor()
{
    if(isset($_REQUEST['sabor']) && !empty($_REQUEST['sabor']))
    {
        $ventas = DataAccess::ReadFile('Ventas');
        $ventasFiltradas = [];
        foreach($ventas as $venta)
        {
            if($venta['attributes']['sabor'] == $_REQUEST['sabor'])
            {
                $unaVenta = new Venta($venta['attributes']);
                $ventasFiltradas[] = $unaVenta;
            }
        }
        if(count($ventasFiltradas) > 0)
        {
            foreach($ventasFiltradas as $venta)
            {
                echo $venta->__toString() . "\n";
            }
        }
        else
        {
            echo "No hubo ventas de este sabor.\n";
        }
        return http_response_code(200);
    }
    else
    {
        echo "Error de params.\n";
        return http_response_code(400);
    }
}