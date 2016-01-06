@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li><a href="/shop">Shop</a></li>
  <li><a href="/cart">Cart</a></li>
  <li><a href="/checkout">Checkout</a></li>
  <li class="active">Pay</li>
</ol>

<h1>Pay</h1>

<h2>Order Details</h2>


@include('orders._summary')

<div class="well">
      {!! Form::model($order, [
        'method'    => 'POST', 
        'route'     => ['payments.store'], 
        'id'        => 'checkout-form', 
        'v-el'      => 'checkoutForm',
        'v-on:submit.prevent'   => 'getStripeToken'
        ]) !!}

      <div class="row">
      <div class="form-group col-md-6 col-xs-12" v-bind:class="{'has-error':validation_failure.card}">
        <label for="cc-number" class="control-label">Card number<small class="text-muted">[<span class="cc-brand">@{{ card_type }}</span>]</small></label>
        <input id="cc-number" type="tel" class="form-control cc-number" autocomplete="cc-number" placeholder="•••• •••• •••• ••••" v-model="card.number" required>
      </div>
       <div class="form-group col-md-3 col-xs-6" v-bind:class="{'has-error':validation_failure.exp}">
        <label for="cc-exp" class="control-label">Card expiry</label>
        <input id="cc-exp" type="tel" class="form-control cc-exp" autocomplete="cc-exp" placeholder="•• / ••" v-model="card.exp" required>
      </div>

      <div class="form-group col-md-3 col-xs-6" v-bind:class="{'has-error':validation_failure.cvc}">
        <label for="cc-cvc" class="control-label">Card CVC</label>
        <input id="cc-cvc" type="tel" class="form-control cc-cvc" autocomplete="off" placeholder="•••" v-model="card.cvc" required>
      </div>
      </div>

      <p v-if="error_message" class="text-danger">@{{ error_message }}</p>

      <input type="hidden" name="order_id" value="{{ $order->id }}">

      <input type="submit" class="btn btn-success" value="Confirm Payment">
      <pre>@{{ $data | json }}</pre>
      {!! Form::close() !!}
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.13/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.3.2/jquery.payment.min.js"></script>
<script>

    var vm = new Vue({
        el: '#checkout-form',
        data: {
            stripe_publishable_key: '{{ config('services.stripe.publishable') }}',
            stripe_token: null,
            card: {
                number: null,
                cvc: null,
                exp: null,
                name: '{{ $order->billing_address->name }}',
                address_line1: '{{ $order->billing_address->line_1 }}',
                address_line2: '{{ $order->billing_address->line_2 }}',
                address_city: '{{ $order->billing_address->city ?: $order->billing_address->line_2 }}',
                address_zip: '{{ $order->billing_address->postcode }}',
                address_country: '{{ $order->billing_address->country }}'
            },
            error_message: null,
            validation_failure: {
              card: false,
              exp: false,
              cvc: false,
            }
        },
        ready: function() {
            $('input.cc-number').payment('formatCardNumber');
            $('input.cc-exp').payment('formatCardExpiry');
            $('input.cc-cvc').payment('formatCardCVC');

            Stripe.setPublishableKey(this.stripe_publishable_key);
        },
        methods: {
            getStripeToken: function() {
                // We extend the card object to clone it which prevent the stripe-modified version ending up in our vm
                Stripe.card.createToken(Vue.util.extend({}, this.card), this.stripeResponseHandler);
            },
            stripeResponseHandler: function(status, response) {
                  if (response.error) {
                    this.error_message = response.error.message;
                    this.checkValidation();

                  } else {
                    // response contains id and card, which contains additional card details
                    var form = this.$el;

                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'stripe_token';
                    input.value = response.id;

                    form.appendChild(input);
                    form.submit();
                  }
                console.log(status, response);
            },
            checkValidation: function() {
              this.validation_failure.card = !this.card_is_valid;
              this.validation_failure.exp  = !this.expiry_is_valid;
              this.validation_failure.cvc  = !this.cvc_is_valid;
            }
        },
        computed: {
            card_type: function() {
                return $.payment.cardType(this.card.number)
            },
            card_is_valid: function() {
                return $.payment.validateCardNumber(this.card.number);
            },
            expiry_is_valid: function() {
                return $.payment.validateCardExpiry($.payment.cardExpiryVal(this.card.exp));
            },
            cvc_is_valid: function() {
                return $.payment.validateCardCVC(this.card.cvc, this.card_type);
            }
        },          

    });
</script>
@stop