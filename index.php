<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="libraries/stylesheet.css">
	</head>
	<body>

		<form id="form1" name="form1" action="Controllers/ControllerPedido.php" method="POST">
			<label>Nº Cartão de Crédito</label>
			<input type="text" id="numeroCartao" name="numeroCartao">

			<label for="valorParcelas">Parcelas</label>
			<select name="valorParcelas" id="valorParcelas">
				<option>Selecione</option>
			</select>

			<input type="hidden" name="qtdParcelas" id="qtdParcelas">
			<input type="hidden" name="tokenCard" id="tokenCard">
			<input type="hidden" name="hashCard" id="hashCard">

		</form>
		<input type="button" name="botaoComprar" id="botaoComprar" value="Comprar">
		
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