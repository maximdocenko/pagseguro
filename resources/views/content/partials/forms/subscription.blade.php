<div class="card">
    <div class="card-header">Checkout</div>
    <div class="card-body">
        @if(isset($status) && $status == 'active')
            <h3>You agreement status is active right now</h3>
        @else
            <form id="checkout" method="POST" action="{{ url('submit') }}">
                @csrf

                @include('content.partials.forms.card')

                <p><strong>Activate an agreement</strong></p>

                <p class="d-none"><label for="">Reference</label><input type="text" class="form-control" name="reference" value="TESTE"></p>
                <p class="d-none"><label for="">Sender name</label><input type="text" class="form-control" name="sender[name]" value="nome comprador"></p>
                <p class="d-none"><label for="">Sender email</label><input type="text" class="form-control" name="sender[email]" value="c18188310766617859030@sandbox.pagseguro.com.br"></p>
                <p class="d-none"><label for="">Sender hash</label><input id="senderHash" type="text" class="form-control" name="sender[hash]" value="5"></p>
                <p class="d-none"><label for="">Sender phone area code</label><input type="text" class="form-control" name="sender[phone][areaCode]" value="11"></p>
                <p class="d-none"><label for="">Sender phone number</label><input type="text" class="form-control" name="sender[phone][number]" value="20516250"></p>
                <p class="d-none"><label for="">Sender address street</label><input type="text" class="form-control" name="sender[address][street]" value="Rua Vi Jose De Castro"></p>
                <p class="d-none"><label for="">Sender address number</label><input type="text" class="form-control" name="sender[address][number]" value="99"></p>
                <p class="d-none"><label for="">Sender address complement</label><input type="text" class="form-control" name="sender[address][complement]" value=""></p>
                <p class="d-none"><label for="">Sender address district</label><input type="text" class="form-control" name="sender[address][district]" value="It"></p>
                <p class="d-none"><label for="">Sender address city</label><input type="text" class="form-control" name="sender[address][city]" value="Sao Paulo"></p>
                <p class="d-none"><label for="">Sender address state</label><input type="text" class="form-control" name="sender[address][state]" value="SP"></p>
                <p class="d-none"><label for="">Sender address country</label><input type="text" class="form-control" name="sender[address][country]" value="BRA"></p>
                <p class="d-none"><label for="">Sender address postalCode</label><input type="text" class="form-control" name="sender[address][postalCode]" value="06240300"></p>
                <p class="d-none"><label for="">Sender documents type</label><input type="text" class="form-control" name="sender[documents][0][type]" value="CPF"></p>
                <p class="d-none"><label for="">Sender documents value</label><input type="text" class="form-control" name="sender[documents][0][value]" value="00000000000"></p>
                <p class="d-none"><label for="">Payment method type</label><input type="text" class="form-control" name="paymentMethod[type]" value="CREDITCARD"></p>
                <p class="d-none"><label for="">CreditCard token</label><input id="creditCardToken" type="text" class="form-control" name="paymentMethod[creditCard][token]" value=""></p>
                <p class="d-none"><label for="">CreditCard holder name</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][name]" value="teste Teste"></p>
                <p class="d-none"><label for="">CreditCard holder birth date</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][birthDate]" value="04/12/1991"></p>
                <p class="d-none"><label for="">CreditCard holder documents type</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][documents][0][type]" value="CPF"></p>
                <p class="d-none"><label for="">CreditCard holder documents value</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][documents][0][value]" value="00000000000"></p>
                <p class="d-none"><label for="">CreditCard holder phone areaCode</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][phone][areaCode]" value="11"></p>
                <p class="d-none"><label for="">CreditCard holder phone number</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][phone][number]" value="20516250"></p>
                <p class="d-none"><label for="">CreditCard holder street</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][billingAddress][street]" value="Rua Vi Jose De Castro"></p>
                <p class="d-none"><label for="">CreditCard holder number</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][billingAddress][number]" value="99"></p>
                <p class="d-none"><label for="">CreditCard holder complement</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][billingAddress][complement]" value=""></p>
                <p class="d-none"><label for="">CreditCard holder district</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][billingAddress][district]" value="It"></p>
                <p class="d-none"><label for="">CreditCard holder city</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][billingAddress][city]" value="Sao Paulo"></p>
                <p class="d-none"><label for="">CreditCard holder state</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][billingAddress][state]" value="SP"></p>
                <p class="d-none"><label for="">CreditCard holder country</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][billingAddress][country]" value="BRA"></p>
                <p class="d-none"><label for="">CreditCard holder postal code</label><input type="text" class="form-control" name="paymentMethod[creditCard][holder][billingAddress][postalCode]" value="06240300"></p>

                <p><input class="btn btn-primary" type="submit" value="Submit"></p>

            </form>
        @endif
    </div>
</div>