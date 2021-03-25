<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SoapClient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Aramex extends Model
{
     function makeOrder($order,$type,$info){

        $soapClient = new SoapClient('storage/shipping-services-api-wsdl.wsdl');
        $params = array(
            'Shipments' => array(
                'Shipment' => array(
                    'Shipper' => array(
                        'Reference1' => '',
                        'Reference2' => '',
                        'AccountNumber' => '163316',
                        'PartyAddress' => array(
                            'Line1' => 'Av Mly Smail Res Mly Smail',
                            'Line2' => '',
                            'Line3' => '',
                            'City' => 'Tanger',
                            'StateOrProvinceCode' => '',
                            'PostCode' => '90000',
                            'CountryCode' => 'MA'
                        ) ,
                        'Contact' => array(
                            'Department' => '',
                            'PersonName' => 'Meryam',
                            'Title' => 'MR',
                            'CompanyName' => 'Delivered Sarl',
                            'PhoneNumber1' => '0664902434',
                            'PhoneNumber1Ext' => '',
                            'PhoneNumber2' => '',
                            'PhoneNumber2Ext' => '',
                            'FaxNumber' => '',
                            'CellPhone' => '0664902434',
                            'EmailAddress' => '',
                            'Type' => ''
                        ) ,
                    ) ,

                    'Consignee' => array(
                        'Reference1' => '',
                        'Reference2' => '',
                        'AccountNumber' => '',
                        'PartyAddress' => array(
                            'Line1' => $order->address_12_billing,
                            'Line2' => $order->state_name_billing,
                            'Line3' => '',
                            'City' => $order->city_billing,
                            'StateOrProvinceCode' => '',
                            'PostCode' => $order->postcode_billing,
                            'CountryCode' => $order->country_code_billing
                        ) ,

                        'Contact' => array(
                            'Department' => '',
                            'PersonName' => $order->full_name_billing,
                            'Title' => '',
                            'CompanyName' => $order->full_name_billing,
                            'PhoneNumber1' => $order->phone_billing,
                            'PhoneNumber1Ext' => '',
                            'PhoneNumber2' => '',
                            'PhoneNumber2Ext' => '',
                            'FaxNumber' => '',
                            'CellPhone' => $order->phone_billing,
                            'EmailAddress' => $order->email_billing,
                            'Type' => ''
                        ) ,
                    ) ,

                    'ThirdParty' => array(
                        'Reference1' => '',
                        'Reference2' => '',
                        'AccountNumber' => '',
                        'PartyAddress' => array(
                            'Line1' => '',
                            'Line2' => '',
                            'Line3' => '',
                            'City' => '',
                            'StateOrProvinceCode' => '',
                            'PostCode' => '',
                            'CountryCode' => ''
                        ) ,
                        'Contact' => array(
                            'Department' => '',
                            'PersonName' => '',
                            'Title' => '',
                            'CompanyName' => '',
                            'PhoneNumber1' => '',
                            'PhoneNumber1Ext' => '',
                            'PhoneNumber2' => '',
                            'PhoneNumber2Ext' => '',
                            'FaxNumber' => '',
                            'CellPhone' => '',
                            'EmailAddress' => '',
                            'Type' => ''
                        ) ,
                    ) ,

                    'Reference1' => '',
                    'Reference2' => '',
                    'Reference3' => '',
                    'ForeignHAWB' => '',
                    'TransportType' => 0,
                    'ShippingDateTime' => time() ,
                    'DueDate' => time() ,
                    'PickupLocation' => 'Reception',
                    'PickupGUID' => '',
                    'Comments' => 'Call Center',
                    'AccountingInstrcutions' => '',
                    'OperationsInstructions' => '',

                    'Details' => array(
                        'Dimensions' => array(
                            'Length' => 10,
                            'Width' => 10,
                            'Height' => 10,
                            'Unit' => 'cm',

                        ) ,

                        'ActualWeight' => array(
                            'Value' => 0.5,
                            'Unit' => 'Kg'
                        ) ,

                        'ProductGroup' => Str::upper($type)=='CODS'?'DOM':'EXP',
                        'ProductType' =>Str::upper($type)=='CODS'?'ONP':'PPX',
                        'PaymentType' => 'P',
                        'PaymentOptions' => '',
                        'Services' => $type,
                        'NumberOfPieces' => 1,
                        'DescriptionOfGoods' => $order->invoice_content,
                        'GoodsOriginCountry' => 'MA',

                        'CashOnDeliveryAmount' => array(
                            'Value' => Str::upper($type)=='CODS'?strval($order->price):'',
                            'CurrencyCode' => Str::upper($type)=='CODS'?'':$order->currency
                        ) ,

                        'InsuranceAmount' => array(
                            'Value' => 0,
                            'CurrencyCode' => ''
                        ) ,

                        'CollectAmount' => array(
                            'Value' => 0,
                            'CurrencyCode' => ''
                        ) ,

                        'CashAdditionalAmount' => array(
                            'Value' => 0,
                            'CurrencyCode' => ''
                        ) ,

                        'CashAdditionalAmountDescription' => '',

                        'CustomsValueAmount' => array(
                            'Value' => Str::upper($type)=='CODS'?0:15,
                            'CurrencyCode' => Str::upper($type)=='CODS'?'MAD':$order->currency
                        ) ,

                        'Items' => array(
        )
                    ) ,
                ) ,
            ) ,

            'ClientInfo' => array(
                'AccountCountryCode' =>$info->CountryCode,
                'AccountEntity' => $info->Ac_Entity,
                'AccountNumber' =>$info->Ac_Number,
                'AccountPin' =>$info->Ac_Pin,
                'UserName' =>$info->UserName,
                'Password' =>$info->Password,
                'Version' => '1.0'
            ) ,

            'Transaction' => array(
                'Reference1' => '001',
                'Reference2' => '',
                'Reference3' => '',
                'Reference4' => '',
                'Reference5' => '',
            ) ,
            'LabelInfo' => array(
                'ReportID' => 9201,
                'ReportType' => 'URL',
            ) ,
        );

        $params['Shipments']['Shipment']['Details']['Items'][] = array(
            'PackageType' => 'Box',
            'Quantity' => 1,
            'Weight' => array(
                'Value' => 0.5,
                'Unit' => 'Kg',
            ) ,
            'Comments' => 'Docs',
            'Reference' => ''
        );



        try {
            $result='';
            $auth_call = $soapClient->CreateShipments($params);
            if ($auth_call->Shipments->ProcessedShipment->HasErrors) {
                if ($auth_call->Shipments->ProcessedShipment->Notifications->code='ERR52') {
                    $msg=$auth_call->Shipments->ProcessedShipment->Notifications->Notification->Message;
                    //print_r($msg);
                    $spl=strpos($msg, '-');
                    $result= substr($msg, $spl+1, strlen($msg)-$spl);
                }
            } else {
                $id=$auth_call->Shipments->ProcessedShipment->ID;
                $doc=$auth_call->Shipments->ProcessedShipment->ShipmentLabel->LabelURL;
                $result=array('track'=>$id,'doc'=>$doc,'Error'=>null);
            }
        } catch (SoapFault $fault) {
            $error='Error : ' . $fault->faultstring;
            $result=array('Error'=>$error);
        }
        return $result;
    }

}
