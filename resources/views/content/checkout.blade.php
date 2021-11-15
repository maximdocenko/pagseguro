@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('message'))
            <div class="alert alert-warning" role="alert">
                {{ session('message') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @include("content.partials.forms.$form")

        <div id="res"></div>

    </div>

    <script type="application/javascript">

        $(document).ready(function () {


            function getInstallments(amount, brand) {
                PagSeguroDirectPayment.getInstallments({
                    amount: amount,
                    brand: brand,
                    success: function(response){
                        console.log(response)
                    },
                    error: function(response) {
                        console.log('error get installments')
                        console.log(response)
                    },
                    complete: function(response){
                        // Callback para todas chamadas.
                    }
                });
            }

            function getBrand(card, length) {
                if (length == 6) {
                    PagSeguroDirectPayment.getBrand({
                        cardBin: card,
                        success: function (response) {
                            $("input[name=brand]").val(response.brand.name)
                        },
                        error: function (response) {
                            console.log('error get brand')
                            console.log(response)
                        },
                        complete: function (response) {

                        }
                    });
                }
            }

            function getCardToken(data) {

                PagSeguroDirectPayment.createCardToken({
                    cardNumber: $("input[name=cardNumber]").val(), // Número do cartão de crédito
                    brand: $("input[name=brand]").val(), // Bandeira do cartão
                    cvv: $("input[name=cvv]").val(), // CVV do cartão
                    expirationMonth: $("input[name=expirationMonth]").val(), // Mês da expiração do cartão
                    expirationYear: $("input[name=expirationYear]").val(), // Ano da expiração do cartão, é necessário os 4 dígitos.
                    success: function(response) {

                        $("#creditCardToken").val(response.card.token);

                        setTimeout(function () {

                            var data = $("#checkout").serialize();

                            $.ajax({
                                method: "POST",
                                url: '{{ url('submit') }}',
                                data: data,
                                dataType: 'json',
                                success: function (response) {
                                    if(response.errors) {
                                        $.each(response.errors, function (i, e) {
                                            $("<p style='color: red;'>"+e+"</p>").appendTo("#res")
                                        })
                                    }
                                    if(response.message) {
                                        $("<p style='color: blue'>"+response.message+"</p>").appendTo("#res")
                                    }
                                }
                            });

                            $("#checkout").find("input[type=submit]").removeAttr('disabled', 1);

                        }, 100)

                    },
                    error: function(response) {
                        console.log('error submit')
                        console.log(response)
                    },
                    complete: function(response) {

                    }
                });

            }

            PagSeguroDirectPayment.setSessionId('{{ $session }}');

            PagSeguroDirectPayment.onSenderHashReady(function(response){
                $("#senderHash").val(response.senderHash);
            });

            $("#cardNumber").keyup(function () {
                var card = $(this).val();
                var length = card.length;
                getBrand(card, length)
            })

            $("#checkout").submit(function (e) {

                e.preventDefault();
                e.stopImmediatePropagation();

                $("#checkout").find("input[type=submit]").attr('disabled', 1);

                getCardToken();

                return false;

            });


            $(".listing_id").change(function () {
                console.log(123)
                price = 0;
                $(".listing_id").each(function () {

                    el = $(this);
                    if(el.is(':checked')) {
                        price += parseFloat(el.data('price'));
                    }
                })
                console.log(price)
                $("#total").html('Total: ' + price)
                getInstallments(price, 'visa');
            })

        })

    </script>

@endsection
