<?php
namespace App\Http\Controllers;

class SoapController extends BaseSoapController
{
    private $service;

    public function BienesServicios(){
        try {
            self::setWsdl('http://192.168.1.3:60927/hl7Services.asmx?WSDL');
            $this->service = InstanceSoapClient::init();

            $json_array = '';
            $vatNumber = '47458714';

            $params = [
                'countryCode' => request()->input('countryCode') ? request()->input('countryCode') : $countryCode,
                'vatNumber'   => request()->input('vatNumber') ? request()->input('vatNumber') : $vatNumber
            ];
            $response = $this->service->checkVat($params);
            return view ('bienes-servicios-soap', compact('response'));
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }


}
