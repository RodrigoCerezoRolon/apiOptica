<?php
require_once "Usuario.php";
require_once "AccesoDatos.php";
class Anteojo
{
  #ATRIBUTOS

  public $id;//autoincremental
  public $color;
  public $marca;
  public $precio;
  public $aumento;


  #CONSTRUCTOR

  public function __construct($id=null,$color=null,$marca=null,$precio=null,$aumento=null)
  {
      $this->id=$id;
      $this->color=$color;
      $this->marca=$marca;
      $this->precio=$precio;
      $this->aumento=$aumento;
      
  }

  #Metodos Apis

  /*Alta con VALIDACIONES directo en la API*/
  /*
  public static function Alta($request,$response,$next)
  {
    //json de media
    $ArrayDeParametros = $request->getParsedBody();
    $media=json_decode ($ArrayDeParametros['media']);

    //json de retorno
    $objJson= new stdClass();
    $objJson->Exito=false;
    $objJson->Mensaje="Error no se pudo agregar la media en la BD";

    $mediaObj = new Media($media->id,$media->color,$media->marca,$media->precio,$media->talle);

    if($mediaObj->AltaMediaBd())
    {
        $objJson->Exito=true;
        $objJson->Mensaje="Se pudo agregar la media en la BD";
        $newResponse=$response->withJson($objJson,200);

    }
    else
    {
        $newResponse = $response->withJson($objJson,404);
    }

   return $newResponse;

  }
  */
  /*Alta sin VALIDACIONES sobre la API*/
  public static function Alta($request,$response,$next)
  {
    //json de media
    $ArrayDeParametros = $request->getParsedBody();
    $anteojo=json_decode ($ArrayDeParametros['anteojo']);

    //json de retorno
    $objJson= new stdClass();
    $objJson->Exito=true;
    $objJson->Mensaje="Se agrego el anteojo";

    $anteojoObj = new Anteojo($anteojo->id,$anteojo->color,$anteojo->marca,$anteojo->precio,$anteojo->aumento);

    $anteojoObj->AltaAnteojoBd();


   return $response->withJson($objJson,200);
   //return $response->getBody()->write("Se ha insertado el anteojo.");

  }


  /*TraerTodos con VALIDACIONES directo en la API*/
  /*public static function TraerTodos($request,$response,$next)
  {
    $objJson= new stdClass();
    $objJson->Exito=false;
    $objJson->Mensaje="Error no se pudo recuperar todas las medias!";
    $objJson->arrayJson=null;

    $media = new Media();
    $arrayMedias=$media->TraerTodasLasMediasBD();

    if(count($arrayMedias)>0)
    {
        $objJson->Exito=true;
        $objJson->Mensaje="Se recuperaron todos las medias";
        $objJson->arrayJson=$arrayMedias;

        $newResponse= $response->withJson($objJson,200);
    }
    else
    {
       $newResponse= $response->withJson($objJson,404);
    }

   return $newResponse;
  }
  */

  /*TraerTodos sin VALIDACIONES sobre la API*/
  public static function TraerTodos($request,$response,$next)
  {
    $objJson= new stdClass();

    $anteojo = new Anteojo();
    $arrayAnteojos=$anteojo->TraerTodosLosAnteojosBD();

    $objJson->Exito=true;
    $objJson->Mensaje="Se recuperaron todos los anteojos";
    $objJson->arrayJson=$arrayAnteojos;

  // return $response->withJson($objJson,200);
   return $response->withJson($arrayAnteojos,200);
  }

  public static function Borrar($request,$response,$next)
  {
    $ArrayDeParametros = $request->getParsedBody();

    $id_anteojo=$ArrayDeParametros['id_anteojo'];

  
    $anteojo= new Anteojo($id_anteojo);

    $objJson= new stdClass();
    $objJson->Exito=false;
    $objJson->Mensaje="No se pudo borrar el anteojo";

    $cantidadDeBorrados= $anteojo->BorrarAnteojoBD();
    if($cantidadDeBorrados>0)
    {
      $objJson->Exito=true;
      $objJson->Mensaje="Se pudo borrar el anteojo";

      $newResponse=$response->withJson($objJson,200);
    }
    else
    {
      $newResponse=$response->withJson($objJson,404);
    }

    return $newResponse;
  }

  public static function Modificar($request,$response,$next)
  {
    //json de media
    $ArrayDeParametros = $request->getParsedBody();
    $anteojo=json_decode ($ArrayDeParametros['anteojo']);
    

    //json de retorno
    $objJson= new stdClass();
    $objJson->Exito=false;
    $objJson->Mensaje="Error no se pudo modificar el anteojo en la BD";

    $anteojoObj = new Anteojo($anteojo->id,$anteojo->color,$anteojo->marca,$anteojo->precio,$anteojo->aumento);


    if($anteojoObj->ModificarAnteojoBD())
    {
        $objJson->Exito=true;
        $objJson->Mensaje="Se pudo modifcar el anteojo en la BD";
        $newResponse=$response->withJson($objJson,200);

    }
    else
    {
        $newResponse = $response->withJson($objJson,404);
    }

   return $newResponse;

  }



  #Metodos Base de Datos
  
  private function AltaAnteojoBd()
  {
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into anteojos (color,marca,precio,aumento)values(:color, :marca, :precio, :aumento)");

    // return $objetoAccesoDato->RetornarUltimoIdInsertado();
    $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
    $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
    $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
    $consulta->bindValue(':aumento', $this->aumento, PDO::PARAM_INT);

    return $consulta->execute();
  }

  private function TraerTodosLosAnteojosBD()
  {
    $anteojos = array();
    $objetoDatos =AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoDatos->RetornarConsulta('SELECT * FROM anteojos'); //Se prepara la consulta, aquí se podrían poner los alias
    $consulta->execute();

    /*v1
    $consulta->setFetchMode(PDO::FETCH_LAZY);

    foreach ($consulta as $tele) {
        $auxTele = new Televisor($tele->tipo,$tele->precio,$tele->pais,$tele->foto);
        array_push($auxReturn, $auxTele);
    }*/

    //v2
    while($fila = $consulta->fetch())
    {
      $anteojo= new Anteojo($fila[0],$fila[1],$fila[2],$fila[3],$fila[4]);
      array_push($anteojos,$anteojo);
    }
    return $anteojos;
  }

  private function BorrarAnteojoBD()
  {
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("
    DELETE 
    FROM anteojos 				
    WHERE id=:id");	
    $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
    $consulta->execute();
    return $consulta->rowCount();
  }

  private function ModificarAnteojoBD()
  {
    $objetoDatos = AccesoDatos::DameUnObjetoAcceso();

    //ejecuto la consulta de eliminar un usuario en el "legajo" especificado en la base de datos
    $consulta =$objetoDatos->RetornarConsulta('UPDATE anteojos SET color = :color, marca = :marca, precio = :precio, aumento = :aumento WHERE id = :idAUX' );

    $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
    $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
    $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
    $consulta->bindValue(':aumento', $this->aumento, PDO::PARAM_STR);

    $consulta->bindValue(':idAUX', $this->id, PDO::PARAM_INT);

    return $consulta->execute();
  }

}

?>