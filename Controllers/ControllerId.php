<?php
include('../config/config.php');

$acao = filter_input(INPUT_GET,'acao',FILTER_SANITIZE_SPECIAL_CHARS);
$tipo = filter_input(INPUT_GET,'tipo',FILTER_SANITIZE_SPECIAL_CHARS);

echo is_callable($acao) ? $acao($tipo) : 0;

function getSessionId($tipo){
	if('chk_transp' == $tipo){
		$url = "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions?email=".EMAIL_PAGSEGURO."&token=".TOKEN_SANDBOX;
	} else if('chk_transp_split' == $tipo){
		$url = "https://ws.sandbox.pagseguro.uol.com.br/sessions?appId=".APP_ID_SANDBOX."&appKey=".APP_KEY_SANDBOX;
	} else if('chk_transp_split' == $tipo){
		$url = "https://ws.sandbox.pagseguro.uol.com.br/sessions?appId=".APP_ID_SANDBOX."&appKey=".APP_KEY_SANDBOX;
	} else {
		return false;
	}

	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/xml; charset=ISO-8859-1"));
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); // false se não atualizar certificado digital.
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$retorno = curl_exec($curl);
	curl_close($curl);

	$xml = simplexml_load_string($retorno);

	return json_encode($xml);
}
/*
function getAutorizacao(){
	//$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/authorizations/request?appId='.APP_ID.'&appKey='.APP_KEY;

	$xmlData =<<<XML
	<authorizationRequest>
	    <permissions>
	        <code>CREATE_CHECKOUTS</code>
	        <code>RECEIVE_TRANSACTION_NOTIFICATIONS</code>
	        <code>SEARCH_TRANSACTIONS</code>
	        <code>MANAGE_PAYMENT_PRE_APPROVALS</code>
	        <code>DIRECT_PAYMENT</code>
	    </permissions>
	    <redirectURL>http://www.google.com</redirectURL>
	</authorizationRequest>	
XML;

	//$url = "https://ws.pagseguro.uol.com.br/v2/authorizations/request/?appId=".APP_ID."&appKey=".APP_KEY;
	$url = "https://ws.sandbox.pagseguro.uol.com.br/v2/authorizations/request/?appId=".APP_ID_SANDBOX."&appKey=".APP_KEY_SANDBOX;
	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/xml; charset=ISO-8859-1"));
	curl_setopt($curl,CURLOPT_POST, true);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, true); // false se não atualizar certificado digital.
	curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl,CURLOPT_POSTFIELDS, $xmlData);

	// Se não funcionar, pode ser que tenha que usar instrução curl_setopt($curl,CURLOPT_POSTFIELDS,$BuildQuery) ao invés te concatenar os parâmetros na url.

	$retorno = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);

	$xml = simplexml_load_string($retorno);

	$href = "https://ws.sandbox.pagseguro.uol.com.br/v2/authorization/request.jhtml?code={$xml->code}";
	echo "<a href='{$href}' target='_blank'>Link</a>";


	//return json_encode($xml);
	//S#nh$teste
	//frase de teste
	// V%nd67@)20)(10
}
*/