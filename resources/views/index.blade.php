@extends('layouts.main')
@section('top-heading')
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Your shopping Kart</h1>
    <p class="lead">Buy your favourite items now.</p>
</div>
@endsection
@section('content')
<div class="card-deck mb-3 text-center">
    @forelse($products as $product)
    <div class="card mb-3 shadow-sm">
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">{{$product->name}}</h4>
        </div>
        <div class="card-body">
            <h1 class="card-title pricing-card-title">$ {{$product->price}}</h1>
            <ul class="list-unstyled mt-3 mb-4">
                <li>{{$product->brand}}</li>
                <li>{{$product->description}}</li>
            </ul>
            <button type="button" onclick="addCart({{$product->id}})" class="btn btn-lg btn-block btn-outline-primary">Add Cart</button>
        </div>
    </div>
    @empty
     There is no product found!
    @endforelse

   
  
</div>
<div>
{{$products->links('pagination::bootstrap-4')}}
</div>

@endsection