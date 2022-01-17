<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Braintree-Demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://js.braintreegateway.com/web/dropin/1.31.2/js/dropin.js"></script>
  <script src="https://js.braintreegateway.com/web/3.81.0/js/client.min.js"></script>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <div class="container">
     <div class="row">
       <div class="col-md-8 col-md-offset-2">
        <div id="dropin-container"></div>
        <button id="submit-button">Request payment method</button>
       </div>
     </div>
  </div>
  <script>
    var button = document.querySelector('#submit-button');

braintree.dropin.create({
  authorization: "{{ Braintree_ClientToken::generate() }}",
  container: '#dropin-container'
}, function (createErr, instance) {
  button.addEventListener('click', function () {
    instance.requestPaymentMethod(function (err, payload) {
      $.get('{{ route('payment.process') }}', {payload}, function (response) {
        if (response.success) {
          alert('Payment successfull!');
        } else {
          alert('Payment failed');
        }
      }, 'json');
    });
  });
});
  </script>
</body>
</html>
