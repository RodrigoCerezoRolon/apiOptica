<?php
require_once "AccesoDatos.php";
class Venta
{
  #ATRIBUTOS

  public $id;//autoincremental
  public $id_anteojos;
  public $cantidad;
  public $fecha;

  #CONSTRUCTOR

  public function __construct($id=null,$id_anteojos=null,$cantidad=null,$fecha=null)
  {
      $this->id=$id;
      $this->id_anteojos=$id_anteojos;
      $this->cantidad=$cantidad;
      $this->fecha=$fecha;
  }

  public static function Alta($request,$response,$next)
  {
    //json de media
    $ArrayDeParametros = $request->getParsedBody();
    $venta=json_decode ($ArrayDeParametros['venta']);

    //json de retorno
    $objJson= new stdClass();
    $objJson->Exito=true;
    $objJson->Mensaje="Se agrego la venta";

    $ventaObj = new Venta($venta->id,$venta->id_anteojos,$venta->cantidad,$venta->fecha);

    $ventaObj->AltaVentaBd();


   return $response->withJson($objJson,200);
  }

  private function AltaVentaBd()
  {
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into ventas_anteojos (id_anteojos,cantidad,fecha)values(:id_anteojos, :cantidad, :fecha)");

    // return $objetoAccesoDato->RetornarUltimoIdInsertado();
    $consulta->bindValue(':id_anteojos', $this->id_anteojos, PDO::PARAM_INT);
    $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
    $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
    return $consulta->execute();
  }

  public static function TraerTodos($request,$response,$next)
  {
    $objJson= new stdClass();

    $venta = new Venta();
    $arrayVentas=$venta->TraerTodasLasVentasBD();

    $objJson->Exito=true;
    $objJson->Mensaje="Se recuperaron todas las ventas";
    $objJson->arrayJson=$arrayVentas;

    return $response->withJson($arrayVentas,200);
  }

  private function TraerTodasLasVentasBD()
  {
    $ventas = array();
    $objetoDatos =AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoDatos->RetornarConsulta('SELECT * FROM ventas_anteojos'); //Se prepara la consulta, aquí se podrían poner los alias
    $consulta->execute();

    while($fila = $consulta->fetch())
    {
      $venta= new Venta($fila[0],$fila[1],$fila[2],$fila[3]);
      array_push($ventas,$venta);
    }
    return $ventas;
  }
}