<?php

include("../config/Config.php");

$tokenCard=$_POST['tokenCard'];
$hashCard=$_POST['hashCard'];
$qtdParcelas=filter_input(INPUT_POST,'qtdParcelas',FILTER_SANITIZE_SPECIAL_CHARS);
$valorParcelas=filter_input(INPUT_POST,'valorParcelas',FILTER_SANITIZE_SPECIAL_CHARS);

$Data["email"]=EMAIL_PAGSEGURO;
$Data["token"]=TOKEN_SANDBOX;
$Data["paymentMode"]="default";
$Data["paymentMethod"]="creditCard";
$Data["receiverEmail"]=EMAIL_PAGSEGURO;
$Data["currency"]="BRL";
$Data["itemId1"] = 1;
$Data["itemDescription1"] = 'Website';
$Data["itemAmount1"] = '500.00';
$Data["itemQuantity1"] = 1;
$Data["notificationURL="]="https://www.meusite.com.br/notificacao.php";
$Data["reference"]="83783783737";
$Data["senderName"]='José Comprador';
$Data["senderCPF"]='22111944785';
$Data["senderAreaCode"]='37';
$Data["senderPhone"]='99999999';
$Data["senderEmail"]="c82586467082250380775@sandbox.pagseguro.com.br";
$Data["senderHash"]=$hashCard;
$Data["shippingType"]="1";
$Data["shippingAddressStreet"]='Av. Brig. Faria Lima';
$Data["shippingAddressNumber"]='1384';
$Data["shippingAddressComplement"]='5 Andar';
$Data["shippingAddressDistrict"]='Jardim Paulistano';
$Data["shippingAddressPostalCode"]='01452002';
$Data["shippingAddressCity"]='Sao Paulo';
$Data["shippingAddressState"]='SP';
$Data["shippingAddressCountry"]="BRA";
$Data["shippingType"]="1";
$Data["shippingCost"]="0.00";
$Data["creditCardToken"]=$tokenCard;
$Data["installmentQuantity"]=$qtdParcelas;
$Data["installmentValue"]=$valorParcelas;
$Data["noInterestInstallmentQuantity"]=2;
$Data["creditCardHolderName"]='Jose Comprador';
$Data["creditCardHolderCPF"]='22111944785';
$Data["creditCardHolderBirthDate"]='27/10/1987';
$Data["creditCardHolderAreaCode"]='37';
$Data["creditCardHolderPhone"]='99999999';
$Data["billingAddressStreet"]='Av. Brig. Faria Lima';
$Data["billingAddressNumber"]='1384';
$Data["billingAddressComplement"]='5 Andar';
$Data["billingAddressDistrict"]='Jardim Paulistano';
$Data["billingAddressPostalCode"]='01452002';
$Data["billingAddressCity"]='Sao Paulo';
$Data["billingAddressState"]='SP';
$Data["billingAddressCountry"]="BRA";

$BuildQuery=http_build_query($Data);
$Url="https://ws.sandbox.pagseguro.uol.com.br/v2/transactions";

$Curl=curl_init($Url);
curl_setopt($Curl,CURLOPT_HTTPHEADER,Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
curl_setopt($Curl,CURLOPT_POST,true);
curl_setopt($Curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($Curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($Curl,CURLOPT_POSTFIELDS,$BuildQuery);
$Retorno=curl_exec($Curl);
curl_close($Curl);

$Xml=simplexml_load_string($Retorno);
var_dump($Xml);

/*
include('../config/config.php');

$tokenCard = $_POST['tokenCard'];
$hashCard = $_POST['hashCard'];
$qtdParcelas = $_POST['qtdParcelas'];
$valorParcelas = $_POST['valorParcelas'];

$data = [
	'email' => EMAIL_PAGSEGURO,
	'token' => TOKEN_PAGSEGURO,
	'currncy' => 'BRL',
	'itemId1' => '1',
	'itemDescription1' => 'Website teste Pagseguro',
	'itemAmount1' => '500.00',
	'itemQuantity1' => '1',
	'itemWeight1' => '1000',
	'reference' => '87678378787878',
	'senderName' => 'Jaoão da Silva',
	'senderAreaCode' => '37',
	'senderPhone' => '999999999',
	'senderEmail' => 'xpto@sandbox.pagseguro.uol.com.br',
	'shippingType' => '1', // 1 - PAC, 2 - SEDEX, 3 - NÃO INFORMADO
	'shippingAddressRequired' => true,
	'shippingAddressStreet' => 'Rua xpto',
	'shippingAddressNumber' => '10',
	'shippingAddressComplement' => 'Casa',
	'shippingAddressDistrict' => 'Distrito xpto',
	'shippingAddressPostalCode' => '14452685',
	'shippingAddressCity' => 'Salvador',
	'shippingAddressState' => 'BA',
	'shippingAddressCountry' => 'BRA',
	'paymentMode' => 'default',
	'paymentMethod' => 'creditCard',
	'receiverEmail' => EMAIL_PAGSEGURO,
	'currency' => 'BRL',
	'extraAmount' => 1.00,
	'notificationURL' => 'https://sualoja.com.br/notifica.html',
	'reference' => 'REF1234',
	'senderName' => 'Jose Comprador',
	'senderCPF' => '22111944785',
	'senderAreaCode' => 11,
	'senderPhone' => '56273440',
	'senderHash' => $hashCard,
	'shippingType' => 1, // 1 - APC, 2 - Sedex, 3 - Desconhecido
	'shippingCost' => 0.00,
	'creditCardToken' => $tokenCard,
	'installmentQuantity' => $qtdParcelas,
	'installmentValue' => $valorParcelas,
	'noInterestInstallmentQuantity' => 2,
	'creditCardHolderName' => 'Jose Comprador',
	'creditCardHolderCPF' => 22111944785,
	'creditCardHolderBirthDate' => '27/10/1987',
	'creditCardHolderAreaCode' => 11,
	'creditCardHolderPhone' => '56273440',
	'billingAddressStreet' => 'Av. Brig. Faria Lima',
	'billingAddressNumber' => '1384',
	'billingAddressComplement' => '5o andar',
	'billingAddressDistrict' => 'Jardim Paulistano',
	'billingAddressPostalCode' => '01452002',
	'billingAddressCity' => 'Sao Paulo',
	'billingAddressState' => 'SP',
	'billingAddressCountry' => 'BRA'
];


$buildQuery = http_build_query($data);
$url = ' https://ws.pagseguro.uol.com.br/v2/transactions?{{credenciais}}';

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; chaset=UTF-8"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); // false se não atualizar certificado digital.
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);

$retorno = curl_exec($curl);
curl_close($curl);

$xml = simplexml_load_string($retorno);

var_dump($xml);
*/