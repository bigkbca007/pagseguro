<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="libraries/stylesheet.css">
	</head>
	<body>

		<form>
			<label>Nº Cartão de Crédito</label>
			<input type="text" id="numeroCartao" name="numeroCartao">

			<label for="parcelas">Parcelas</label>
			<select name="parcelas" id="parcelas">
				<option>Selecione</option>
			</select>

			<input type="hidden" name="qtdParcelas" id="qtdParcelas">
			<input type="hidden" name="tokenCard" id="tokenCard">
		</form>
		<div class="bandeiraCartao"></div>

		<div class="cartaoCredito"><div class="titulo">Cartão de Crédito</div></div>
		<div class="boleto"><div class="titulo">Boleto</div></div>
		<div class="debito"><div class="titulo">Débito Online</div></div>

		<!-- <script type="text/javascript" src="libraries/zepto.min.js"></script> -->
		<script type="text/javascript" src="libraries/jquery.min.js"></script>
		<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
		<script type="text/javascript" src="libraries/javascript.js"></script>

	</body>
</html>