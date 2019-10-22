<?php

include("../config/Config.php");

$tokenCard=$_POST['tokenCard'];
$hashCard=$_POST['hashCard'];
$qtdParcelas=filter_input(INPUT_POST,'qtdParcelas',FILTER_SANITIZE_SPECIAL_CHARS);
$valorParcelas=filter_input(INPUT_POST,'valorParcelas',FILTER_SANITIZE_SPECIAL_CHARS);
$cpfDonoCartao=filter_input(INPUT_POST,'cpfDonoCartao',FILTER_SANITIZE_SPECIAL_CHARS);
$paymentMethod=filter_input(INPUT_POST,'paymentMethod',FILTER_SANITIZE_SPECIAL_CHARS);

$Data["email"]=EMAIL_PAGSEGURO;
$Data["token"]=TOKEN_SANDBOX;
$Data["paymentMode"]="default";
$Data["paymentMethod"]=$paymentMethod;
$Data["receiverEmail"]=EMAIL_PAGSEGURO;
$Data["currency"]="BRL";
$Data["itemId1"] = 1;
$Data["itemDescription1"] = 'Website';
$Data["itemAmount1"] = "500.00";
$Data["itemQuantity1"] = 1;
$Data["notificationURL="]="https://www.meusite.com.br/notificacao.php";
$Data["reference"]="83783783737";
$Data["senderName"]='José Comprador';
$Data["senderCPF"]='22111944785'; // Cpf do comprador
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

if('creditCard' == $paymentMethod){
	$Data["creditCardToken"]=$tokenCard;
	$Data["installmentQuantity"]=$qtdParcelas;
	$Data["installmentValue"]=$valorParcelas;
	$Data["noInterestInstallmentQuantity"]=2;

	$Data["creditCardHolderName"]='Jose Comprador';
	$Data["creditCardHolderCPF"]=$cpfDonoCartao;
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
}


$BuildQuery=http_build_query($Data);
$Url="https://ws.sandbox.pagseguro.uol.com.br/v2/transactions";

$Curl=curl_init($Url);
curl_setopt($Curl,CURLOPT_HTTPHEADER,Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
curl_setopt($Curl,CURLOPT_POST,true);
curl_setopt($Curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($Curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($Curl,CURLOPT_POSTFIELDS,$BuildQuery);
$retorno=curl_exec($Curl);
curl_close($Curl);

$xml=simplexml_load_string($retorno);

if('creditCard' == $paymentMethod){
	echo "<pre>"; print_r($_POST);print_r($xml); echo "</br>";
} elseif('boleto' == $paymentMethod){
	echo "
		<script>
		    window.location.href='$xml->paymentLink';
		</script>";
}

/*
$TokenCard=$_POST['TokenCard'];
$HashCard=$_POST['HashCard'];
$QtdParcelas=filter_input(INPUT_POST,'QtdParcelas',FILTER_SANITIZE_SPECIAL_CHARS);
$ValorParcelas=filter_input(INPUT_POST,'ValorParcelas',FILTER_SANITIZE_SPECIAL_CHARS);
$CPFCartao=filter_input(INPUT_POST,'CPFCartao',FILTER_SANITIZE_SPECIAL_CHARS);
$NomeComprador=filter_input(INPUT_POST,'NomeComprador',FILTER_SANITIZE_SPECIAL_CHARS);
$CPFComprador=filter_input(INPUT_POST,'CPFComprador',FILTER_SANITIZE_SPECIAL_CHARS);
$DDDComprador=filter_input(INPUT_POST,'DDDComprador',FILTER_SANITIZE_SPECIAL_CHARS);
$TelefoneComprador=filter_input(INPUT_POST,'TelefoneComprador',FILTER_SANITIZE_SPECIAL_CHARS);
$NomeCartao=filter_input(INPUT_POST,'NomeCartao',FILTER_SANITIZE_SPECIAL_CHARS);
$Endereco=filter_input(INPUT_POST,'Endereco',FILTER_SANITIZE_SPECIAL_CHARS);
$Numero=filter_input(INPUT_POST,'Numero',FILTER_SANITIZE_SPECIAL_CHARS);
$Complemento=filter_input(INPUT_POST,'Complemento',FILTER_SANITIZE_SPECIAL_CHARS);
$Bairro=filter_input(INPUT_POST,'Bairro',FILTER_SANITIZE_SPECIAL_CHARS);
$Cidade=filter_input(INPUT_POST,'Cidade',FILTER_SANITIZE_SPECIAL_CHARS);
$UF=filter_input(INPUT_POST,'UF',FILTER_SANITIZE_SPECIAL_CHARS);
$CEP=filter_input(INPUT_POST,'CEP',FILTER_SANITIZE_SPECIAL_CHARS);

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
$Data["senderName"]=$NomeComprador;
$Data["senderCPF"]=$CPFComprador;
$Data["senderAreaCode"]=$DDDComprador;
$Data["senderPhone"]=$TelefoneComprador;
$Data["senderEmail"]="c51994292615446022931@sandbox.pagseguro.com.br";
$Data["senderHash"]=$HashCard;
$Data["shippingType"]="1";
$Data["shippingAddressStreet"]=$Endereco;
$Data["shippingAddressNumber"]=$Numero;
$Data["shippingAddressComplement"]=$Complemento;
$Data["shippingAddressDistrict"]=$Bairro;
$Data["shippingAddressPostalCode"]=$CEP;
$Data["shippingAddressCity"]=$Cidade;
$Data["shippingAddressState"]=$UF;
$Data["shippingAddressCountry"]="BRA";
$Data["shippingType"]="1";
$Data["shippingCost"]="0.00";
$Data["creditCardToken"]=$TokenCard;
$Data["installmentQuantity"]=$QtdParcelas;
$Data["installmentValue"]=$ValorParcelas;
$Data["noInterestInstallmentQuantity"]=2;
$Data["creditCardHolderName"]=$NomeCartao;
$Data["creditCardHolderCPF"]=$CPFCartao;
$Data["creditCardHolderBirthDate"]='27/10/1987';
$Data["creditCardHolderAreaCode"]=$DDDComprador;
$Data["creditCardHolderPhone"]=$TelefoneComprador;
$Data["billingAddressStreet"]=$Endereco;
$Data["billingAddressNumber"]=$Numero;
$Data["billingAddressComplement"]=$Complemento;
$Data["billingAddressDistrict"]=$Bairro;
$Data["billingAddressPostalCode"]=$CEP;
$Data["billingAddressCity"]=$Cidade;
$Data["billingAddressState"]=$UF;
$Data["billingAddressCountry"]="BRA";
*/