<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="libraries/stylesheet.css">
		<link rel="stylesheet" type="text/css" href="libraries/bootstrap/css/bootstrap.min.css">
	</head>
	<body class="container">

		<form id="form1" name="form1" action="Controllers/ControllerPedido.php" method="POST" class="form-horizontal">
			<div class="form-group row">
				<label>Meio de Pagamento&nbsp;&nbsp;&nbsp;</label> 

				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" value="creditCard" checked>
					<label class="form-check-label" for="creditCard">Cartão de Crédito</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="paymentMethod" id="boleto" value="boleto">
					<label class="form-check-label" for="boleto">Boleto</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="paymentMethod" id="split" value="split">
					<label class="form-check-label" for="split">Split</label>
				</div>
			</div>
			<div id="fieldsCreditCard">

				<div class="form-group row">
					<div class="col-md-4">
						<label>Nº Cartão de Crédito</label>
						<input type="text" id="numeroCartao" name="numeroCartao" class="form-control">
						<div class="bandeiraCartao"></div>
					</div>

					<div class="col-md-3">
						<label>Mês Validade</label>
						<select name="mesValidade" id="mesValidade" class="form-control">
							<option>Selcione</option>
							<?php for($mes = 1; $mes <= 12; $mes++):?>
								<option value="<?php echo $mes?>"><?php echo $mes?></option>
							<?php endfor;?>
						</select>
					</div>
					<div class="col-md-3">
						<label>Ano Validade</label>
						<select type="text" name="anoValidade" id="anoValidade" class="form-control">
							<option>Selecione</option>
							<?php for($ano = date('Y'); $ano < (date('Y') + 20); $ano++):?>
								<option value="<?php echo $ano?>"><?php echo $ano?></option>
							<?php endfor;?>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-4">
						<label for="valorParcelas">Parcelas</label>
						<select name="valorParcelas" id="valorParcelas" class="form-control">
							<option>Selecione</option>
						</select>
					</div>

					<div class="col-md-3">
						<label>CVV</label>
						<input type="text" id="cvv" name="cvv" maxlength="3" class="form-control">
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-4">
						<label>CPF do Dono do Cartão</label>
						<input type="text" name="cpfDonoCartao" id="cpfDonoCartao" class="form-control">
					</div>
				</div>

				<input type="hidden" name="qtdParcelas" id="qtdParcelas">
				<input type="hidden" name="tokenCard" id="tokenCard">
				<input type="hidden" name="hashCard" id="hashCard">
				<input type="hidden" name="bandeiraCartao" id="bandeiraCartao">
			</div>

			<div class="cartaoCredito"><div class="titulo">Cartão de Crédito</div></div>
			<div class="boleto"><div class="titulo">Boleto</div></div>
			<div class="debito"><div class="titulo">Débito Online</div></div>

			<input type="button" name="botaoComprar" id="botaoComprar" value="Comprar" class="btn btn-primary">
		</form>

		<!-- <script type="text/javascript" src="libraries/zepto.min.js"></script> -->
		<script type="text/javascript" src="libraries/jquery.min.js"></script>
		<script type="text/javascript" src="libraries/bootstrap/js/bootstrap.min.js"></script>
		<!-- <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>-->
		<script type="text/javascript" src="libraries/javascript.js"></script>

	</body>
</html>