<?php

class RequestsManager
{
    public function Run()
    {        
        switch($_SERVER['REQUEST_METHOD'])
        {
            case 'GET':
                $this->HandleGetRequest();
                break;
            case 'POST':
                $this->HandlePostRequest();
                break;
            case 'PUT':
                $this->HandlePutRequest();
                break;
            case 'DELETE':
                $this->HandleDeleteRequest();
                break;
            default:
                $this->RequestError();
        }
    }
    
    #region [ FUNCTIONS ]
    private function HandleGetRequest()
    {
        if(isset($_GET['request']))
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
        else
        {
            $this->RequestError();
        }
    }

    private function HandlePostRequest()    
    {
        if($_POST['request'])
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
                case 'altaPizza':
                    require APP_ROOT . '/model/scripts/PizzaCarga.php';
                    break;
                default:
                    return http_response_code(400);
            }
        }
        else
        {
            $this->RequestError();
        }
    }

    private function HandlePutRequest()
    {
        $_PUT = file_get_contents("php://input");
        $_PUT = json_decode($_PUT, true);  
        
        if($_PUT['request'])
        {
            switch($_PUT['request'])
            {
                case 'modificarVenta':
                    require APP_ROOT . '/model/scripts/ModificarVenta.php';
                    break;
                default:
                return http_response_code(400);
            }
        }
        else
        {
            $this->RequestError();
        }
    }

    private function HandleDeleteRequest()
    {
        $_DELETE = $_GET;
        if($_DELETE['request'])
        {
            switch($_DELETE['request'])
            {
                case 'borrarVenta':
                    require APP_ROOT . '/model/scripts/BorrarVenta.php';
                    break;
                default:
                return http_response_code(400);
            }
        }
        else
        {
            $this->RequestError();
        }
    }

    private function RequestError()
    {
        echo "Error: no hay request.\n";
        return http_response_code(400);
    }
    #endregion
}