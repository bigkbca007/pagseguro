jQuery(document).ready(function($){

	// Iniciar a sessão de pagamento
	var root = document.location.href;
	var amount = 500.00;

	function iniciarSessao()
	{
		$.ajax({
			url: root+'Controllers/ControllerId.php?acao=iniciarSessao',
			type: 'POST',
			dataType: 'json',
			success: function(data){
				PagSeguroDirectPayment.setSessionId(data.id);
			},
			complete: function(){
				listaMeiosPagamento();
			}
		});
	}

	// Lista os meios de pagamento disponíveis no Pagseguro
	function listaMeiosPagamento()
	{
		PagSeguroDirectPayment.getPaymentMethods({
			amount: amount, // Valor para teste
			success: function(data){
				// Cartões de crédito
				$.each(data.paymentMethods.CREDIT_CARD.options, function(i, obj){
					$('.cartaoCredito').append('<div><img src="https://stc.pagseguro.uol.com.br/'+obj.images.SMALL.path+'"> '+obj.name+'</div>');
				});

				// Boleto
				$('.boleto').append('<div><img src="https://stc.pagseguro.uol.com.br/'+data.paymentMethods.BOLETO.options.BOLETO.images.SMALL.path+'"> '+data.paymentMethods.BOLETO.name+'</div>');

				// Débito online
				$.each(data.paymentMethods.ONLINE_DEBIT.options, function(i, obj){
					$('.debito').append('<div><img src="https://stc.pagseguro.uol.com.br/'+obj.images.SMALL.path+'"> '+obj.name+'</div>');
				});
			},
		});
	}

	$('#numeroCartao').keyup(function(){
		var numeroCartao = $(this).val();
		var qtdCaracteres = numeroCartao.length;

		if(qtdCaracteres == 6){
			$('.img-cartao-credito').addClass('nao-selecionado');
			var bandeiraImg = (111111 == numeroCartao) ? 'visa' : 'mastercard';
			$('#'+bandeiraImg).removeClass('nao-selecionado');
			$('#bandeiraCartaoSelecionado').html('<img src="img/'+bandeiraImg+'.jpg" style="width: 28px;">');

			getParcelas(bandeiraImg);
			/*
			PagSeguroDirectPayment.getBrand({
				cardBin: numeroCartao,
				success: function(response){
					var bandeiraImg = response.brand.name;
					$('#bandeiraCartao').val(bandeiraImg);
					$('#bandeiraCartaoSelecionado').html('<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/'+bandeiraImg+'.png">');
					$('#'+bandeiraImg).removeClass('nao-selecionado');
					getParcelas(bandeiraImg);
				},
				error: function(response){
					alert('Cartão não reconhecido.');
					$('#bandeiraCartaoSelecionado').empty();
				}
			});
			*/
		}
	});

	// Exibe a quantidade e valores da parcelas
	function getParcelas(bandeira){
		/*
		PagSeguroDirectPayment.getInstallments({
			amount: amount,
			maxInstallmentNoInterest: 2,
			brand: bandeira,
			success: function(response){
				$.each(response.installments, function(i, cartao){
					$.each(cartao, function(j, d){
						valorParcela = 'R$ '+d.installmentAmount.toFixed(2).replace('.',',');
						$('#valorParcelas').append('<option value="'+d.installmentAmount.toFixed(2)+'" data-quantity='+d.quantity+'>'+d.quantity+' parcelas de '+valorParcela +'</option>');
					});
				});
			},
			error:function(resp){
				console.log(resp);
			}
		});
		*/
	}

	function getTokenCard(){
		PagSeguroDirectPayment.createCardToken({
			cardNumber: $('#numeroCartao').val(),
			brand: $('#bandeiraCartao').val(),
			cvv: $('#cvv').val(),
			expirationMonth: $('#mesValidade').val(),
			expirationYear: $('#anoValidade').val(),
			success: function(response){
				$('#tokenCard').val(response.card.token);
			},
			error:function(response){
				console.log('porra');
				console.log(response);
			}
		});
	}

	// Obter o hash do cartão
	$('#botaoComprar').on('click', function(event){
		if('creditCard' == $('input[name=paymentMethod]:checked').val()){
				PagSeguroDirectPayment.onSenderHashReady(function(response){
					$('#hashCard').val(response.senderHash);

			        if(response.status=='success'){
		        		$("#form1").trigger('submit');
					}
				});
		} else {
			$("#form1").trigger('submit');
		}
	});

	// Seta a quantidade de parcelas
	$('#valorParcelas').on('change', function(){
		$('#qtdParcelas').val($(this).find('option:selected').data().quantity);
	});

	$('#cvv').on('blur', function(){
		getTokenCard();
	});

	$('input[name=paymentMethod]').on('change', function(){
		if('creditCard' == $(this).val()){
			$('#fieldsCreditCard').removeClass('d-none');
		} else if('boleto' == $(this).val()){
			$('#fieldsCreditCard').addClass('d-none');
		}
	});

	//iniciarSessao();
});