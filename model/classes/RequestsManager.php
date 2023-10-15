<?php

class RequestsManager
{
    public function Run()
    {
        $request = $_SERVER['REQUEST_METHOD'];

        switch($request)
        {
            case 'GET':
                $this->HandleGetRequest();
                break;
            case 'POST':
                $this->HandlePostRequest();
                break;
            default:
                return http_response_code(400);
        }
    }
    
    #region [ FUNCTIONS ]
    private function HandleGetRequest()
    {
        switch($_GET['request'])
        {
            case 'test':
                echo 'el server está vivo';
                return http_response_code(200);
            case 'altaPizza': // required params: request: altaPizza, create: Pizza, params: [...]
                require APP_ROOT . '/model/scripts/PizzaCarga.php';
                break;
            default:
                return http_response_code(400);
        }
    }

    private function HandlePostRequest()    
    {
        switch($_POST['request'])
        {
            case 'consultaPizza':
                require APP_ROOT . '/model/scripts/PizzaConsultar.php';
                break;
            case 'altaVenta':
                require APP_ROOT . '/model/scripts/AltaVenta.php';
                break;
            case 'consultaVenta':
                require APP_ROOT . '/model/scripts/ConsultasVentas.php';
                break;
            default:
                return http_response_code(400);
        }
    }
    #endregion
}