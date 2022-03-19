@extends('layouts.master')
@section('content')
<div class="col-md-12">
    <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
      <div class="col p-3 d-flex flex-column position-static">
        <muted class="d-inline-block mb-2 text-info">
          @foreach ($product->categories as $category)
            {{$category->name }}{{$loop->last ?'':', '}}
        @endforeach</muted>
        <h3 class="mb-4">{{ $product->title }}</h3>
       
        <span >{!!$product->description !!}</span>
        <strong class="mb-4 display-4 text-secondary">{{ $product->getPrice() }}</strong>
        <form action="{{route('panier.store')}}" method="post">
            @csrf
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <button class='btn btn-success mb-2' type="submit"><i class="fa fa-shopping-cart " aria-hidden="true" ></i> Ajouter ce produit au panier</button>
        </form>
      </div>
      <div class="col-auto d-none d-lg-block">
        <img  width="200" height="250" src="{{ asset('storage/'.$product->image) }}" alt="">
      </div>
    </div>
  </div>
  @endsection
  ️️️️️