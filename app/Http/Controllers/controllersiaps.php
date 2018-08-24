<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;
class controllersiaps extends Controller
{
/*FUNCIONES PARA RECIBIR PETICIONES*/
  function checkin(){
      ini_set('soap.wsdl_cache_enabled', '0');
      ini_set('soap.wsdl_cache_ttl', '0');
      ini_set('default_socket_timeout', 120);

       //$host= $_SERVER['HTTP_HOST'];
       //list($modulo,$dominio)=explode(".", $host);
       //$requestScheme=$_SERVER['REQUEST_SCHEME'];
       $return_='';
       //$url = $requestScheme.'://siap.'.$dominio.'/app.php/soap/interfaceliswebservice';
       //echo $url;
       $url = 'http://siaps.localhost/app_dev.php/soap/interfaceliswebservice';
       $action = 'checkin';
       $soapParameters = array('trace' => true, 'exceptions' => true);

       $array = array('AppUser'=>'eautomatizado','Password'=>'34ut0m4t1z4d0');
       $json_array = json_encode($array);
       $array_param = array('json_array' => $json_array);


       try {
           $soapClient = new Soapclient($url.'?wsdl', $soapParameters);
           
           $soapClient->__setLocation($url);
           //var_dump($soapClient);exit();
           $data = $soapClient->__soapCall($action, $array_param);
           return $data;
       } catch (Exception $e) {
           return 'false';
           //return $e->__toString();
       }
  }

  function acceptMessage($arreglo){
      $respuesta = "";
      //$this->checkin();
      ini_set('soap.wsdl_cache_enabled', '0');
      ini_set('soap.wsdl_cache_ttl', '0');
      ini_set('default_socket_timeout', 120);

       //$host= $_SERVER['HTTP_HOST'];
       //list($modulo,$dominio)=explode(".", $host);
       //$requestScheme=$_SERVER['REQUEST_SCHEME'];
       $return_='';
       //$url = $requestScheme.'://siap.'.$dominio.'/app.php/soap/interfaceliswebservice';
       //echo $url;
       $url = 'http://siaps.localhost/app_dev.php/soap/interfaceliswebservice';
       $action = 'acceptMessage';
       $soapParameters = array('trace' => true, 'exceptions' => true);

       //$data=$this->checkin();


       $array = $arreglo;
       $json_array = json_encode($array);
       $array_param = array('json_array' => $json_array);
       //var_dump($array_param);
       //exit();
       try {
           $soapClient = new Soapclient($url.'?wsdl', $soapParameters);
           //  client = new \SoapClient($wsdl, $options);
       //    $soapClient->__setLocation('http://siaps.localhost/app_dev.php/soap/interfaceliswebservice');

       //    $soapClient->__setLocation($requestScheme.'://siap.'.$dominio.'/app.php/soap/interfaceliswebservice');
           $soapClient->__setLocation($url);
           //var_dump($json_array);exit();
           $data = $soapClient->__soapCall($action, $array_param);
           var_dump($data);
           return $data;

       } catch (Exception $e) {
           return 'false';
           //return $e->__toString();
       }

       return $respuesta;
  }

  function checkout($token){
    ini_set('soap.wsdl_cache_enabled', '0');
    ini_set('soap.wsdl_cache_ttl', '0');
    ini_set('default_socket_timeout', 120);

       //$host= $_SERVER['HTTP_HOST'];
       //list($modulo,$dominio)=explode(".", $host);
       //$requestScheme=$_SERVER['REQUEST_SCHEME'];
       $return_='';
       //$url = $requestScheme.'://siap.'.$dominio.'/app.php/soap/interfaceliswebservice';
       //echo $url;
       $url = 'http://siaps.localhost/app_dev.php/soap/interfaceliswebservice';
       $action = 'checkout';
       $soapParameters = array('trace' => true, 'exceptions' => true);

       $array = array('token'=>'.$token.');
       $json_array = json_encode($array);
       $array_param = array('json_array' => $json_array);


       try {
           $soapClient = new Soapclient($url.'?wsdl', $soapParameters);
           //  client = new \SoapClient($wsdl, $options);
       //    $soapClient->__setLocation('http://siaps.localhost/app_dev.php/soap/interfaceliswebservice');

       //    $soapClient->__setLocation($requestScheme.'://siap.'.$dominio.'/app.php/soap/interfaceliswebservice');
           $soapClient->__setLocation($url);
           //var_dump($json_array);exit();
           $data = $soapClient->__soapCall($action, $array_param);
           return $data;
       } catch (Exception $e) {
           return 'false';
           //return $e->__toString();
       }
  }

  /*ENVIAR RESPUESTAS AL SIAPS*/
  function responder(){
      $aregloRespuestas="";
      $aregloRespuestas =   $this->obtenerRespuestas()->generarRespuestasResult;

      $tamanio=sizeof((array)$aregloRespuestas);
      if($tamanio>0){
        //var_dump($aregloRespuestas);exit();
        $envios=$aregloRespuestas->Envio;

        foreach ($envios as $envio){
          $mensaje  = ($envio);
          $token="1111";
          if(is_object($mensaje)){
          $dato = str_replace("^~\u005Cu005C&","^~\&",$mensaje->Mensaje);
          $dato = str_replace("_z","\r",$dato);
          //$jsonChecking=json_decode($this->checkin(),true);
          //$token=$jsonChecking["token"];
          var_dump($mensaje->Mensaje);
          $array = array('token'=>$token,'Mensaje'=>$dato,'Checksum'=>MD5($dato));
            $this->marcarEnviada($mensaje->Indice);
        }else{
          if(strlen($mensaje)>50){
            $mensaje = str_replace("^~\u005Cu005C&","^~\&",$mensaje);
            $mensaje = str_replace("_z","\r",$mensaje);
            //$jsonChecking=json_decode($this->checkin(),true);
            //$token=$jsonChecking["token"];
            var_dump($mensaje);
            $array = array('token'=>$token,'Mensaje'=>$mensaje,'Checksum'=>MD5($mensaje));
          }else{

            $this->marcarEnviada($mensaje);
          }

        }
          //$this->acceptMessage($array);

        }//end for Each

      }
  }

  function obtenerRespuestas(){
    $jsonRespuestas="";
    ini_set('soap.wsdl_cache_enabled', '0');
    ini_set('soap.wsdl_cache_ttl', '0');
    ini_set('default_socket_timeout', 120);

     //$host= $_SERVER['HTTP_HOST'];
     //list($modulo,$dominio)=explode(".", $host);
     //$requestScheme=$_SERVER['REQUEST_SCHEME'];
     $return_='';
     //$url = $requestScheme.'://siap.'.$dominio.'/app.php/soap/interfaceliswebservice';
     //echo $url;
     $url = 'http://localhost:58282/hl7Services.asmx';
     $action = 'checkin';
     $soapParameters = array('trace' => true, 'exceptions' => true);

     //$array = array('AppUser'=>$user,'Password'=>$password);
     //$json_array = json_encode($array);
     $array_param = array();



     try {
         $soapClient = new Soapclient($url.'?WSDL', $soapParameters);
         $soapClient->__setLocation($url);
         $result = $soapClient->generarRespuestas();
         $jsonRespuestas=$result;
         return $jsonRespuestas;

     } catch (Exception $e) {
         return 'false';
         //return $e->__toString();
     }

    return $jsonRespuestas;
  }

  function marcarEnviada($id){
    ini_set('soap.wsdl_cache_enabled', '0');
    ini_set('soap.wsdl_cache_ttl', '0');
    ini_set('default_socket_timeout', 120);

     $host= $_SERVER['HTTP_HOST'];
     //list($modulo,$dominio)=explode(".", $host);
     $requestScheme=$_SERVER['REQUEST_SCHEME'];
     $return_='';
     //$url = $requestScheme.'://siap.'.$dominio.'/app.php/soap/interfaceliswebservice';
     //echo $url;
     $url = 'http://localhost:58282/hl7Services.asmx';
     $action = 'marcarEnvio';
     $soapParameters = array('trace' => true, 'exceptions' => true);

     $array = array('Indice'=>$id);
     $json_array = json_encode($array);
     //var_dump($json_array);
     //exit();
     $array_param = array('json_array' => $json_array);
     try {
         $soapClient = new Soapclient($url.'?WSDL', $soapParameters);

         //  client = new \SoapClient($wsdl, $options);
     //    $soapClient->__setLocation('http://siaps.localhost/app_dev.php/soap/interfaceliswebservice');

     //    $soapClient->__setLocation($requestScheme.'://siap.'.$dominio.'/app.php/soap/interfaceliswebservice');
         $soapClient->__setLocation($url);
        // var_dump($array_param);exit();

        $result = $soapClient->marcarEnvio($array_param);

        return $result;
     } catch (Exception $e) {
         return 'false';
         //return $e->__toString();
     }
  }
  /*FINAL FUNCIONES DE ENVIO DE RESPUESTA*/
}
