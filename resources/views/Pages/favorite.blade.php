@extends('Layout.app')

@section('content')
    <div class="container mt-5">
        <h2>Your Favorite Products</h2>

        @php
            $favorites = session()->get('favorites', []);
        @endphp

        @if (count($favorites) > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                @foreach ($favorites as $favoriteId)
                    @php
                        $product = \App\Models\Product::where('MaSP', $favoriteId)->first();
                        $category = $product->category;
                    @endphp

                    @if ($product)
                        <div class="col">
                            <a href="{{ route('product.detail', ['id' => $product->MaSP]) }}"
                                class="card text-decoration-none">
                                <div class="card">
                                    <img src="{{ $product->AnhSP ?? 'https://via.placeholder.com/400' }}" class="card-img-top"
                                        alt="{{ $product->TenSP }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->TenSP }}</h5>
                                        <p class="card-text">{{ number_format($product->GiaBan, 0, ',', '.') }} ₫</p>
                                        <p class="card-text">{{ $product->TenSP }}</p>
                                        <p class="card-text"><small class="text-muted">Category:
                                                {{ $category->TenLoai }}</small></p>
                                        <div style="display: flex">
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->MaSP }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                                            </form>

                                            <form class="btn-outline-danger" style="margin-left: 10px"
                                                action="{{ in_array($product->MaSP, $favorites) ? route('favorite.remove', $product->MaSP) : route('favorite.add', $product->MaSP) }}"
                                                method="POST" style="display: inline;" onsubmit="updateFavoriteCount()">
                                                @csrf

                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" id="wishlistBtn{{ $product->MaSP }}"
                                                    aria-label="Add to wishlist">
                                                    Bỏ thích
                                                </button>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                You have no favorite products yet!
            </div>
        @endif
    </div>
@endsection
