<?php
require_once "Usuario.php";
use Firebase\JWT\JWT;
class Login
{
    public static function LoginIngreso($request,$response,$next)
    {
        $ArrayDeParametros = $request->getParsedBody();
        $login=json_decode($ArrayDeParametros["usuario"]);
        /*$clave=$ArrayDeParametros['clave'];
        $correo=$ArrayDeParametros['correo'];*/
        $clave=$login->clave;
        $correo=$login->correo;
        $usuario=Usuario::UsuarioValido($correo,$clave);
        $ahora=time();

        //creamos el payload pasandole un usuario
        $payload = array(
            'iat'=>$ahora,  
            'exp'=>$ahora+20, 
            'data'=>$usuario,
            //'app'=>"API REST 2019",
            );
        
        //retornamos el jwt con la clave
        $token = JWT::encode($payload,"claveSecreta");
        
        return $response->withJson($token,200);
    }

    public static function VerificarJWTLogin($request,$response,$next)
    {
        
        $token = $_GET['token'];

        $flag=false;

        $objJson= new stdClass();
        $objJson->Mensaje="";
        

        $mensajeError="";

        if(empty($token)  || $token==="")
        {
            $mensajeError="El token esta vacio!";
        }

        try
        {
            $decodificado=JWT::decode(
                $token,
                //tenemos que pasarle la clave tambien con la que lo guardamos
                "claveSecreta",
                ['HS256']
            );

            $flag=true;
        }
        catch(Exception $e)
        {
        // throw new Exception ("Token no valido!!! -->" .$e->getMessage() );
          $mensajeError=$e->getMessage();
        }

        if($flag==true)
        {
           $objJson->Mensaje="Token valido!";
           $newResponse = $response->withJson($objJson,200);
        }
        else
        {
            $objJson->Mensaje=$mensajeError;
            $newResponse=$response->withJson($objJson,409);
        }

        return $newResponse;
    }
}


?>