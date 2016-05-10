@extends('layouts.main')

@section('breadcrumb')

<ol class="breadcrumb">
    <li><a href="/shop">Shop</a></li>
    <li><a href="/cart">Cart</a></li>
    <li><a href="/checkout">Checkout</a></li>
    <li class="active">Pay</li>
</ol>

@endsection

@section('content')

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

        <input type="hidden" name="order_id" value="{{ $order->id }}">

        <div class="row">
            <div class="form-group col-md-6 col-xs-12" v-bind:class="{'has-error':validation_failure.card}">
                <label for="cc-number" class="control-label">Card number</label>
                <div class="input-group">
                <input id="cc-number" type="tel" class="form-control cc-number" autocomplete="cc-number" placeholder="•••• •••• •••• ••••" v-model="card.number" required>
                <span class="input-group-addon cc-icon-addon"><i class="cc-icon @{{ card_type }}"></i></span>
                </div>
            </div>
            <div class="form-group col-md-3 col-xs-6" v-bind:class="{'has-error':validation_failure.exp}">
                <label for="cc-exp" class="control-label">Card expiry (MM/YY)</label>
                <input id="cc-exp" type="tel" class="form-control cc-exp" autocomplete="cc-exp" placeholder="•• / ••" v-model="card.exp" required>
            </div>

            <div class="form-group col-md-3 col-xs-6" v-bind:class="{'has-error':validation_failure.cvc}">
                <label for="cc-cvc" class="control-label">Security Code (CVV) <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" title="3 digits on back. 4 digits on front of American Express."></i></label>

                <input id="cc-cvc" type="tel" class="form-control cc-cvc" autocomplete="off" placeholder="•••" v-model="card.cvc" required>

            </div>

            <p v-if="error_message" class="text-danger col-md-12">@{{ error_message }}</p>
            
            <div class="col-sm-4 col-md-2 col-sm-push-8 col-md-push-10">
                <input type="submit" class="btn btn-lg btn-success btn-block" value="Place Order" :disabled="isLoading">
            </div>
            <div class="col-sm-8 col-md-10  col-sm-pull-4 col-md-pull-2">
                <p class="top-buffer"><i class="fa fa-lock"></i> Your card details are securely encrypted and handled by our payment processor. You are safe.</p>
            </div>
        </div>

        {!! Form::close() !!}
    </div>

    @stop

    @section('scripts')

    <style>
        .cc-icon {
            display: inline-block;
            background: url('/img/cc-sprite2.css.svg');
            background-repeat: no-repeat;
            background-position: -1000px -1000px;
            white-space: nowrap;
            background-size: 30px auto;
            width:30px;
            height: 21px;
            margin-bottom: -4px;

        }
        .cc-icon-addon {
            padding: 5px;
        }
        .cc-icon.amex {
            background-position: 0 40%;
        }

        .cc-icon.visa {
            background-position: 0 0;
        }
        .cc-icon.mastercard {
            background-position: 0 20%;
        }
    </style>

    <script>

    var vm = new Vue({
        el: '#checkout-form',
        data: {
            stripe_publishable_key: '{{ config('services.stripe.publishable') }}',
            stripe_token: null,
            card: {
                number: '',
                cvc: '',
                exp: '',
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
            },
            isLoading: false,
        },
        ready: function() {
            $('input.cc-number').payment('formatCardNumber');
            $('input.cc-exp').payment('formatCardExpiry');
            $('input.cc-cvc').payment('formatCardCVC');

            Stripe.setPublishableKey(this.stripe_publishable_key);


            $('[data-toggle="tooltip"]').tooltip();
        },
        methods: {
            getStripeToken: function() {
                this.isLoading = true;
                // We extend the card object to clone it which prevent the stripe-modified version ending up in our vm
                try {
                    Stripe.card.createToken(Vue.util.extend({}, this.card), this.stripeResponseHandler);
                } catch (e) {
                    this.handleStripeError(e);
                }
            },
            stripeResponseHandler: function(status, response) {
                if (response.error) {
                    this.error_message = response.error.message;
                    this.checkValidation();
                    this.isLoading = false;

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
            },
            handleStripeError: function(e) {
                this.isLoading = false;
                if (e.message.indexOf("expiration date") > -1) {
                    this.error_message = "Your expiry date looks wrong. Please provide it in MM/YY format.";
                    this.validation_failure.exp = true;
                    return;
                }
                this.error_message = "Something was wrong with your input";
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
                var exp;

                if (exp = $.payment.cardExpiryVal(this.card.exp)){
                    return $.payment.validateCardExpiry(exp);
                }
                return false;
            },
            cvc_is_valid: function() {
                return $.payment.validateCardCVC(this.card.cvc, this.card_type);
            }
        },

    });
    </script>
    @stop
