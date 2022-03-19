@extends('layouts.master')
@section('content')
@foreach ($products as $product)
<div class="col-md-6">
  <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
    <div class="col p-4 d-flex flex-column position-static">
      <p class="d-inline-block mb-2 text-primary">
        @foreach ($product->categories as $category)
            {{$category->name}}
        @endforeach
      </p>
      <h5 class="mb-0">{{ $product->title }}</h5>
      <p class="mb-auto text-muted">{{ $product->subtitle }}</p>
      <h1 class="mb-auto font-weight-normal text-secondary">{{ $product->getPrice() }}</h1>
      <a href="{{ route('products.show', $product->slug) }}" class=" btn btn-primary">Consulter le produit</a>
    </div>
    <div class="col-auto d-none d-lg-block">
      <img  width="200" height="250" src="{{ asset('storage/'.$product->image) }}" alt="">
    </div>
  </div>
</div>
@endforeach
{{$products->appends(request()->input())->links()}}
@endsection