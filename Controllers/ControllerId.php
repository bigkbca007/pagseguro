<?php
include('../config/config.php');

$acao = filter_input(INPUT_GET,'acao',FILTER_SANITIZE_SPECIAL_CHARS);
$tipo = filter_input(INPUT_GET,'tipo',FILTER_SANITIZE_SPECIAL_CHARS);

echo is_callable($acao) ? $acao() : 0;

function getSessionId(){
	if('chk_transp' == $tipo){
		$url = "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions?email=".EMAIL_PAGSEGURO."&token=".TOKEN_SANDBOX;
	} else if('chk_transp_split' == $tipo){
		$url = "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions?appId=".APP_ID."&appKey=".APP_KEY;
	} else {
		return false;
	}

	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; chaset=UTF-8"));
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); // false se não atualizar certificado digital.
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$retorno = curl_exec($curl);
	curl_close($curl);

	$xml = simplexml_load_string($retorno);

	return json_encode($xml);
}

function getAutorizacao(){
	$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/authorizations/request/?appId='.APP_ID.'&appKey='.APP_KEY;
	$curl = curl_init($url);
	curl_setopt($curl,CURLOPT_HTTPHEADER,Array("Content-Type: application/xml; charset=ISO-8859-1"));
	curl_setopt($curl,CURLOPT_POST,true);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,true); // false se não atualizar certificado digital.
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

	// Se não funcionar, pode ser que tenha que usar instrução curl_setopt($curl,CURLOPT_POSTFIELDS,$BuildQuery) ao invés te concatenar os parâmetros na url.
	$retorno = curl_exec($curl);
	curl_close($curl);

	$xml = simplexml_load_string($retorno);

	return json_encode($xml);
}