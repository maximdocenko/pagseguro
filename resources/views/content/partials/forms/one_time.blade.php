<div class="card">
    <div class="card-header">Checkout</div>
    <div class="card-body">
        @if(count($listings))
        <form id="checkout" method="POST" action="{{ url('submit') }}">
            @csrf


            <p><strong>Listings to activate</strong></p>

            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Plan</th>
                    <th>Price</th>
                </tr>
                @foreach($listings as $listing)
                    <tr>

                        <td><input class="listing_id" name="listing_id[]" type="checkbox" data-price="{{ $listing->listing_plan->plan->price }}" value="{{ $listing->id }}"></td>
                        <td>{{ $listing->title }} ${{ $listing->listing_plan->plan->price }} {{ $listing->listing_plan->plan->name }}</td>
                        <td>{{ $listing->listing_plan->plan->name }}</td>
                        <td>${{ $listing->listing_plan->plan->price }}</td>

                    </tr>
                @endforeach
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Total: <span id="total">$1 555 555</span></th>
                </tr>
            </table>


            @include('content.partials.forms.card')


            <p><input id="one_time_submit" class="btn btn-primary" type="submit" value="Submit"></p>

            <p class="d-none"><label for="">Payment Mode</label><input type="text" class="form-control" name="paymentMode" value="default"></p>
            <p class="d-none"><label for="">Payment Method</label><input type="text" class="form-control" name="paymentMethod" value="creditCard"></p>
            <p class="d-none"><label for="">Receiver Email</label><input type="text" class="form-control" name="receiverEmail" value="{{ env('PAGSEGURO_EMAIL') }}"></p>
            <p class="d-none"><label for="">Currency</label><input type="text" class="form-control" name="currency" value="BRL"></p>
            <p class="d-none"><label for="">Extra Amount</label><input type="text" class="form-control" name="extraAmount" value="0.00"></p>

            <p class="d-none"><label for="">Notification URL</label><input type="text" class="form-control" name="notificationURL" value="https://ualoja.com.br/notifica.html"></p>
            <p class="d-none"><label for="">Reference</label><input type="text" class="form-control" name="reference" value="REF1234"></p>
            <p class="d-none"><label for="">Sender Name</label><input type="text" class="form-control" name="senderName" value="Jose Comprador"></p>
            <p class="d-none"><label for="">Sender CPF</label><input type="text" class="form-control" name="senderCPF" value="22111944785"></p>
            <p class="d-none"><label for="">Sender AreaCode</label><input type="text" class="form-control" name="senderAreaCode" value="11"></p>
            <p class="d-none"><label for="">Sender Phone</label><input type="text" class="form-control" name="senderPhone" value="56273440"></p>
            <p class="d-none"><label for="">Email</label><input type="text" class="form-control" name="senderEmail" value="c18188310766617859030@sandbox.pagseguro.com.br"></p>
            <p class="d-none ###"><label for="">Sender Hash</label><input id="senderHash" type="text" class="form-control" name="senderHash" value="senderHash"></p>
            <p class="d-none"><label for="">Shipping Address Street</label><input type="text" class="form-control" name="shippingAddressStreet" value="Av.Brig.FariaLima"></p>
            <p class="d-none"><label for="">Shipping Address Number</label><input type="text" class="form-control" name="shippingAddressNumber" value="1384"></p>
            <p class="d-none"><label for="">Shipping Address Complement</label><input type="text" class="form-control" name="shippingAddressComplement" value="5oandar"></p>
            <p class="d-none"><label for="">Shipping Address District</label><input type="text" class="form-control" name="shippingAddressDistrict" value="JardimPaulistano"></p>
            <p class="d-none"><label for="">Shipping Address Postal Code</label><input type="text" class="form-control" name="shippingAddressPostalCode" value="01452002"></p>
            <p class="d-none"><label for="">Shipping Address City</label><input type="text" class="form-control" name="shippingAddressCity" value="SaoPaulo"></p>
            <p class="d-none"><label for="">Shipping Address State</label><input type="text" class="form-control" name="shippingAddressState" value="SP"></p>
            <p class="d-none"><label for="">Shipping Address Country</label><input type="text" class="form-control" name="shippingAddressCountry" value="BRA"></p>
            <p class="d-none"><label for="">Shipping Type</label><input type="text" class="form-control" name="shippingType" value="3"></p>
            <p class="d-none"><label for="">Shipping Cost</label><input type="text" class="form-control" name="shippingCost" value="0.00"></p>
            <p class="d-none ###"><label for="">Credit Card Token</label><input id="creditCardToken" type="text" class="form-control creditCardToken" name="creditCardToken" value=""></p>
            <p class="d-none"><label for="">Credit CardHolder Name</label><input type="text" class="form-control" name="creditCardHolderName" value="Jose Comprador"></p>
            <p class="d-none"><label for="">Credit CardHolder CPF</label><input type="text" class="form-control" name="creditCardHolderCPF" value="22111944785"></p>
            <p class="d-none"><label for="">Credit CardHolder BirthDate</label><input type="text" class="form-control" name="creditCardHolderBirthDate" value="27/10/1987"></p>
            <p class="d-none"><label for="">Credit CardHolder AreaCode</label><input type="text" class="form-control" name="creditCardHolderAreaCode" value="11"></p>
            <p class="d-none"><label for="">Credit CardHolder Phone</label><input type="text" class="form-control" name="creditCardHolderPhone" value="56273440"></p>
            <p class="d-none"><label for="">Billing Address Street</label><input type="text" class="form-control" name="billingAddressStreet" value="Av.Brig.FariaLima"></p>
            <p class="d-none"><label for="">Billing Address Number</label><input type="text" class="form-control" name="billingAddressNumber" value="1384"></p>
            <p class="d-none"><label for="">Billing Address Complement</label><input type="text" class="form-control" name="billingAddressComplement" value="5oandar"></p>
            <p class="d-none"><label for="">Billing Address District</label><input type="text" class="form-control" name="billingAddressDistrict" value="JardimPaulistano"></p>
            <p class="d-none"><label for="">Billing Address PostalCode</label><input type="text" class="form-control" name="billingAddressPostalCode" value="01452002"></p>
            <p class="d-none"><label for="">Billing Address City</label><input type="text" class="form-control" name="billingAddressCity" value="SaoPaulo"></p>
            <p class="d-none"><label for="">Billing Address State</label><input type="text" class="form-control" name="billingAddressState" value="SP"></p>
            <p class="d-none"><label for="">Billing Address Country</label><input type="text" class="form-control" name="billingAddressCountry" value="BRA"></p>


        </form>

        @else
            <h3>You have no listings</h3>
        @endif
    </div>
</div>