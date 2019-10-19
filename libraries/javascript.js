//jQuery(document).ready(function($){

	// Iniciar a sessão de pagamento
	var root = document.location.href;
	var amount = 500.00;

	function iniciarSessao()
	{
		$.ajax({
			url: root+'Controllers/ControllerId.php',
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
			erro: function(response){},
			complete: function(response){
				getTokenCard();
			}
		});
	}

	$('#numeroCartao').keyup(function(){
		var numeroCartao = $(this).val();
		var qtdCaracteres = numeroCartao.length;

		if(qtdCaracteres == 6){
			PagSeguroDirectPayment.getBrand({
				cardBin: numeroCartao,
				success: function(response){
					if(response.brand){
						var bandeiraImg = response.brand.name;
						$('.bandeiraCartao').html('<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/'+bandeiraImg+'.png">');
						getParcelas(bandeiraImg);
					} else {
						$('.bandeiraCartao').empty();
					}
				},
				erro: function(response){
					alert('Cartão não reconhecido.');
					$('.bandeiraCartao').empty();
				}
			});
		} else {
			$('.bandeiraCartao').empty();
		}
	});

	// Exibe a quantidade e valores da parcelas
	function getParcelas(bandeira){
		PagSeguroDirectPayment.getInstallments({
			amount: amount,
			maxInsallmentNoInterest: 2,
			brand: bandeira,
			success: function(response){
				$.each(response.installments, function(i, cartao){
					$.each(cartao, function(j, d){
						valorParcela = 'R$ '+d.installmentAmount.toFixed(2).replace('.',',');
						$('#parcelas').append('<option value="'+d.installmentAmount+'" data-quantity='+d.quantity+'>'+d.quantity+' parcelas de '+valorParcela +'</option>');
					});
				});
			}
		});
	}

	function getTokenCard(){
		alert('carai1');
		PagSeguroDirectPayment.createCardToken({
			cardNumber: '4111111111111111',
			brand: 'visa ',
			cvv: '123',
			expirationMonth: '12',
			expirationYear: '2030',
			success: function(response){
				alert('carai2');
				console.log(response);
				$('#tokenCard').val(response.card.token);
			}
		});
	}

	// Seta a quantidade de parcelas
	$('#parcelas').on('change', function(){
		$('#qtdParcelas').val($(this).find('option:selected').data().quantity);
	});

	iniciarSessao();
//});