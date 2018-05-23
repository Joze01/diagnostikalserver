<?php

namespace App\Http\Controllers;
use SoapClient;
use Artisaninweb\SoapWrapper\SoapWrapper;
use App\Soap\Request\GetConversionAmount;
use App\Soap\Response\GetConversionAmountResponse;
//use Request;
use Illuminate\Http\Request;
class hl7controller extends Controller
{
  /*SECCION FUNCIONES CONSUMIDAS POR SIAPS*/
    function checkin(Request $request){
            ini_set("xdebug.var_display_max_children", -1);
            ini_set("xdebug.var_display_max_data", -1);
            ini_set("xdebug.var_display_max_depth", -1);


            //var_dump("Datos post".$request->post('AppUser'));
           // exit();
            //$jsontext = $request->post('json_array');
            $appUser = $request->post('AppUser');
            $password = $request->post('Password');
            //var_dump($datos);exit();

            $respuesta=$this->checkinAsp($appUser,$password);
            //var_dump($respuesta->checkinResult);exit();

            $jsonrespuesta = '{
                              "Estado": "false",
                              "mensaje": "error",
                              "token": ""
                            }';
            $datos = json_decode($respuesta->checkinResult);
            if($datos->Estado){
              $jsonrespuesta=$respuesta->checkinResult;
            }
            return $jsonrespuesta;
    }
    function checkout(Request $request){
        $jsontext = $request->post('token');
        $jsonrespuesta=$this->checkoutAsp($jsontext);

        return $jsonrespuesta->checkoutResult;
    }
    function acceptMessage(Request $request){
        ini_set("xdebug.var_display_max_children", -1);
        ini_set("xdebug.var_display_max_data", -1);
        ini_set("xdebug.var_display_max_depth", -1);


          $jsontext = $request->post();
          $token=$request->post('Token');

          $mensaje=$request->post('Mensaje');
          $checksum=$request->post('Checksum');
          //return($checksum);

          $md5Local = MD5($mensaje);
          //var_dump($mensaje);
          //var_dump($md5Local);
          //var_dump($checksum);
          //var_dump($request);
          //exit();
          //var_dump(expression)

          //var_dump($checksum); exit();
          $mensaje = str_replace("%26","&",$mensaje);
          $mensaje = str_replace('\\', '\u005C', $mensaje);
          try{
          $jsonArray=Array(
            "Token"=>$token,
            "Mensaje"=>$mensaje,
            "Checksum"=>$checksum);
                //var_dump($jsonArray);exit();
            $jsontext=json_encode($jsonArray);

          }catch (Exception $e){
            var_dump($e);
            exit();
          }


          $respuesta=$this->acceptMessageAsp($jsontext);

          //var_dump($respuesta);exit();
        //messagediagnostical($token,$mensaje);
        return $respuesta->acceptMessageResult;
      }
    /*SECCION FUNCIONES CONSUMIDAS POR SIAPS*/

    /*SECIONES DE ACCEP AL SOAP ASP*/
    function checkinAsp($user,$password){
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
         $action = 'checkin';
         $soapParameters = array('trace' => true, 'exceptions' => true);

         $array = array('AppUser'=>$user,'Password'=>$password);
         $json_array = json_encode($array);
         $array_param = array('json_array' => $json_array);
         try {
             $soapClient = new Soapclient($url.'?WSDL', $soapParameters);

             //  client = new \SoapClient($wsdl, $options);
         //    $soapClient->__setLocation('http://siaps.localhost/app_dev.php/soap/interfaceliswebservice');

         //    $soapClient->__setLocation($requestScheme.'://siap.'.$dominio.'/app.php/soap/interfaceliswebservice');
             $soapClient->__setLocation($url);
            // var_dump($array_param);exit();

            $result = $soapClient->checkin($array_param);

            return $result;
         } catch (Exception $e) {
             return 'false';
             //return $e->__toString();
         }
    }
    function checkoutAsp($json_array){
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
         $action = 'checkin';
         $soapParameters = array('trace' => true, 'exceptions' => true);
         $array_param = array('json_array' => $json_array);
         try {
             $soapClient = new Soapclient($url.'?WSDL', $soapParameters);

             //  client = new \SoapClient($wsdl, $options);
         //    $soapClient->__setLocation('http://siaps.localhost/app_dev.php/soap/interfaceliswebservice');

         //    $soapClient->__setLocation($requestScheme.'://siap.'.$dominio.'/app.php/soap/interfaceliswebservice');
             $soapClient->__setLocation($url);
            // var_dump($array_param);exit();

            $result = $soapClient->checkout($array_param);
            // var_dump($result);exit();
            return $result;
         } catch (Exception $e) {
             return 'false';
             //return $e->__toString();
         }
    }
    function acceptMessageAsp($json_array){
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
         $action = 'checkin';
         $soapParameters = array('trace' => true, 'exceptions' => true);

         //$array = array('AppUser'=>$user,'Password'=>$password);
         //$json_array = json_encode($array);
         $array_param = array('json_array' => $json_array);



         try {
             $soapClient = new Soapclient($url.'?WSDL', $soapParameters);

             //  client = new \SoapClient($wsdl, $options);
         //    $soapClient->__setLocation('http://siaps.localhost/app_dev.php/soap/interfaceliswebservice');

         //    $soapClient->__setLocation($requestScheme.'://siap.'.$dominio.'/app.php/soap/interfaceliswebservice');
             $soapClient->__setLocation($url);
             //var_dump($array_param);exit();

            $result = $soapClient->acceptMessage($array_param);
             //var_dump($array_param);exit();
            return $result;
         } catch (Exception $e) {
             return 'false';
             //return $e->__toString();
         }
    }
      /* !!SECIONES DE ACCEP AL SOAP ASP*/





}
