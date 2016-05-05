<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Creuset</title>

    <!-- Bootstrap -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
    <style>
        body {
            font-family: 'Muli', sans-serif;
          background-color: #191919;  
          margin-top: 50px;
        }
        .top-buffer {
         padding-top:20px;
        }
        
        .bg {
           background-color: #fff; 
        }
        .space-deck {
            background-color: #eee;
        }


        .sections {
            background-color: #fff;
            padding:15px;
        }

        .navbar-login
        {
            width: 305px;
            padding: 10px;
            padding-bottom: 0px;
        }

        .navbar-login-session
        {
            padding: 10px;
            padding-bottom: 0px;
            padding-top: 0px;
        }

        /* Shop index */
        .product-grid-element {
            position: relative;
            display: block;
            background-color: #000;
        }
        .product-flex {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;

        }
        .product-grid-price, .product-description {
            text-align: center;
        }
        .product-description {
            color: #fff;
            padding: 0 10px;
        }
        .product-grid-price {
            margin-bottom: 0;

            position: absolute;
            bottom:0;
            left:0;
            width:100%;
        }
        .product-grid-price span {
            color: #fff;
            background-color: #000;
            padding: 5px 10px;
            display: inline-block;
        }
        .product-grid-image {
            opacity: 0.9;
            transition: opacity .3s ease;
            -webkit-backface-visibility: hidden;
        }
        .product-grid-element:hover .product-grid-image {
            opacity: 0.6;
        }
    </style>

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    @include('partials._navbar')
    <div class="bg {{ isset($spaceDeck) ? 'space-deck' : '' }}">
    <div class="container {{ !isset($spaceDeck) ? 'top-buffer' : '' }}">
{{--    <header class="clearfix">
        <h1>Creuset</h1>
        <div class="row">
              <div class="col-md-6">
                @include('partials._auth')
            </div>    
            <div class="col-md-6 text-right">
                @include('partials.cart')
            </div>
        </div> 
    </header>--}}
    @include('partials.alert')
    @yield('content')
    </div>
</div>
    @include('partials._footer')
    <script src="/js/main.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.3.2/jquery.payment.min.js"></script>

@yield('scripts')
</body>
</html>
