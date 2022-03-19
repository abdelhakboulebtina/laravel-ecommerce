@extends('layouts.master')
@section('extra-meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('extra-script')
<script src="https://js.stripe.com/v3/"></script>
@endsection
@section('content')
<div class="col-md-12"> <h1> Page de paiement</h1>
<div class="row justify-content-center" >
    <div class="col-md-6 align-center">
        <form class="my-4" method="POST" id="payment-form" action="{{route("checkout.store")}}">
          @csrf
        <div id="card-element"></div>
        <div id="card-errors" role="alert"></div>
        <button id="submit" class="btn btn-success mt-4 col-md-12">Procéder au paiement({{getPrice(Cart::total())}})</button>
    </form>
    </div>
</div>

</div>
@endsection
@section('extra-js')
<script> 
var stripe = Stripe('pk_test_51HxXlcIGLjrMPTAQGc5sbJU0wpguo9I50LwnHOxLwxAbLxo1oxLUkP84DOEAFPboU6YrGQucJIfTCGwGG1YQIWYP00QvdtlxCo');
var elements = stripe.elements();
var style = {
    base: {
      color: "#32325d",
      fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
      fontSmoothing: "antialiased",
      fontSize: "16px",
      "::placeholder": {
        color: "#aab7c4"
      }
    },
    invalid: {
      color: "#fa755a",
      iconColor: "#fa755a"
    }
  };
  var card = elements.create("card", { style: style });
  card.mount("#card-element");
  card.addEventListener("change", ({error}) =>{
     const DisplayErrors = document.getElementById('card-errors');
     if(error)
     {
        DisplayErrors.textContent=error.message;
        DisplayErrors.classList.add('alert','alert-warning');
     }
     else
     {
        DisplayErrors.textContent='';
        DisplayErrors.classList.remove('alert','alert-warning');
     } });
     var submitbutton = document.getElementById('submit');

     submitbutton.addEventListener('click', function(ev) {
  ev.preventDefault();
  submitbutton.disabled=true;
  stripe.confirmCardPayment('{{$clientSecret}}', {
    payment_method: {
      card: card,
    }}).then(function(result) {
    if (result.error) {
      // Show error to your customer (e.g., insufficient funds)
      submitbutton.disabled=false;
      console.log(result.error.message);
    } else {
      // The payment has been processed!
      if (result.paymentIntent.status === 'succeeded') {
      var paymentIntent=result.paymentIntent;
      var form=document.getElementById('payment-form');
      var token=document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      var url=form.action;
      var redirect='/merci';
      fetch(url,
      {
          headers:
          {
           "Content-type":"application/json",
           "Accept":"application/json,text-plain,*/*",
           "X-Requested-Width":"XMLHttpRequest",
           "X-CSRF-TOKEN":token

          },
          method:'post',
          body:JSON.stringify({
            paymentIntent:paymentIntent
          })

      }).then((data)=>
      {
        console.log(data);
        form.reset();
       window.location.href=redirect;
       }).catch((error)=>
      {
        console.log(error);
      })
      
      }
    }
  }); 
});

</script>
@endsection