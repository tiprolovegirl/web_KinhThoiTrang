@extends('Layout.app')

@section('content')
    <div class="container mt-5">
        <h2>Result search</h2>
        @if (isset($products) && $products->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset($product->picture) ?? 'https://via.placeholder.com/400' }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ number_format($product->price, 0, ',', '.') }} ₫</p>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->proc_id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                You have no favorite products yet!
            </div>
        @endif
    </div>
@endsection
