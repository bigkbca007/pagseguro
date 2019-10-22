<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="libraries/stylesheet.css">
        <link rel="stylesheet" type="text/css" href="libraries/bootstrap/css/bootstrap.min.css">

        <script type="text/javascript" src="libraries/jquery.min.js"></script>
        <script type="text/javascript" src="libraries/bootstrap/js/bootstrap.min.js"></script>
        <!-- <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>-->
        <script type="text/javascript" src="libraries/javascript.js"></script>

        <style type="text/css">
            .img-cartao-credito{
                width: 28px;
            }
            .nao-selecionado{
                filter: grayscale(1);
            }
        </style>
    </head>
    <body class="container">

        <form>

            <div class="card" id="dados-do-comprador">

                <div class="card-header">Dados do Comprador</div>

                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nomeComprador">Nome do comprador</label>
                            <input type="text" class="form-control" name="nomeComprador" id="nomeComprador" placeholder="Nome do comprador">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cpf">CPF</label>
                            <input type="cpf" class="form-control" name="cpf" id="cpf" placeholder="CPF">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ddd">DDD</label>
                            <input type="ddd" class="form-control" name="ddd" id="ddd" placeholder="DDD">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ddd">Telefone</label>
                            <input type="telefone" class="form-control" name="telefone" id="telefone" placeholder="Nº de telefone">
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="card" id="dados-do-cartao">

                <div class="card-header">Dados de Pagamento</div>

                <div class="card-body">

                    <ul class="nav nav-tabs" id="formas-pagamento-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="cartao-credito-tab" data-toggle="tab" href="#cartao-credito" role="tab" aria-controls="cartao-credito" aria-selected="true">Cartão de Crédito</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="boleto-tab" data-toggle="tab" href="#boleto" role="tab" aria-controls="boleto" aria-selected="false">Boleto</a>
                        </li>
                        <!--
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                        </li>
                        -->
                    </ul>

                    <!-- Cartão de Crédito -->
                    <div class="tab-content" id="formas-pagamento-tab-content">
                        <div class="tab-pane fade show active" id="cartao-credito" role="tabpanel" aria-labelledby="cartao-credito-tab">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="numeroCartao">Número do Cartão <span id="bandeiraCartaoSelecionado"></span></label>
                                    <input type="text" class="form-control" name="numeroCartao" id="numeroCartao" placeholder="Número do cartão">
                                    <span class="img-cartao-credito nao-selecionado" id="visa"><img src="img/visa.jpg" style="width: 28px;"></span>
                                    <span class="img-cartao-credito nao-selecionado" id="mastercard"><img src="img/mastercard.jpg" style="width: 28px;"></span>
                                    <span class="img-cartao-credito nao-selecionado" id="elo"><img src="img/elo.jpg" style="width: 28px;"></span>
                                    <span class="img-cartao-credito nao-selecionado" id="hipercard"><img src="img/hipercard.jpg" style="width: 28px;"></span>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="nomeCartao">Nome Impresso no Cartão</label>
                                    <input type="text" class="form-control" name="nomeCartao" id="nomeCartao" placeholder="Nome impresso no cartão">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cpfComprador">CPF do Comprador</label>
                                    <input type="text" class="form-control" name="cpfComprador" id="cpfComprador" placeholder="CPF do comprador">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="mesValidade">Mês</label>
                                    <select class="form-control" name="mesValidade" id="mesValidade">
                                        <option>Mês</option>
                                        <?php for($mes = 1; $mes <= 12; $mes++):?>
                                        <option value="<?php echo $mes;?>"><?php echo $mes?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="anoValidade">Ano</label>
                                    <select class="form-control" name="anoValidade" id="anoValidade">
                                        <option>Ano</option>
                                        <?php $qtdAnosValidadeCartao = 14; // Deve ser parametrizado e vir do controller.?>
                                        <?php for($ano = date('Y'); $ano <= (date('Y') + $qtdAnosValidadeCartao); $ano++):?>
                                        <option value="<?php echo $ano;?>"><?php echo $ano?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cvv">CVV</label>
                                    <input type="text" class="form-control" name="cvv" id="" placeholder="cvv" maxlength="4">
                                </div>
                                <div class="form-group col-md-6"></div>

                                <div class="form-group col-md-4">
                                    <label for="qtdParcelas">Parcelar em</label>
                                    <select class="form-control" name="qtdParcelas" id="qtdParcelas">
                                        <option>1x de R$ 500,00 sem juros</option>
                                        <option>2x de R$ 250,00 sem juros</option>
                                        <option>3x de R$ 171,66</option>
                                        <option>4x de R$ 129,25</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Boleto -->
                        <div class="tab-pane fade" id="boleto" role="tabpanel" aria-labelledby="boleto-tab">
                            <div style="margin: 50px 0px 10px 0px;">
                                Valor: R$ 986,25
                            </div>
                        </div>

                        <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> -->
                    </div>

                </div>
            </div>
                <!--
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                            Check me out
                        </label>
                    </div>
                </div>
                -->
            <button type="submit" class="btn btn-success" style="margin-top: 10px;">Pagar</button>

            <input type="hidden" name="qtdParcelas" id="qtdParcelas">
            <input type="hidden" name="tokenCard" id="tokenCard">
            <input type="hidden" name="hashCard" id="hashCard">
            <input type="hidden" name="bandeiraCartao" id="bandeiraCartao">            
        </form>

    </body>
</html>