@extends('Layout.app')

@section('content')
    <!-- Success message with close button -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Main Content -->
    <main class="container mt-4">
        <!-- Featured Image -->
        <section class="mb-4">
            <img src="https://via.placeholder.com/1920x906" class="img-fluid" alt="Featured product">
        </section>
        @php
            // Lấy danh sách yêu thích từ session
            $favorites = session()->get('favorites', []);
        @endphp

        <section class="deals row mb-4">
            <!-- Left Column for First Product -->
            <div class="col-lg-4">
                <div class="row row-cols-1 g-4">
                    @if (isset($products) && $products->count() > 0)
                        @php
                            $firstProduct = $products->first();
                            $category = $firstProduct->category;
                        @endphp
                        <div class="col">
                            <a href="{{ route('product.detail', ['id' => $firstProduct->MaSP]) }}"
                                class="card text-decoration-none">
                                <img src="{{ $firstProduct->AnhSP ?? 'https://via.placeholder.com/100' }}"
                                    class="card-img-top" alt="{{ $firstProduct->TenSP }}">
                                <div class="card-body">
                                    <h5 class="card-title">Price: {{ number_format($firstProduct->GiaBan, 0, ',', '.') }} ₫
                                    </h5>

                                    <p class="card-text">Product Name: {{ $firstProduct->TenSP }}</p>
                                    <p class="card-text">Product Description: {{ $firstProduct->MoTaChiTiet }}</p>
                                    <p class="card-text">Category: {{ $category->TenLoai }}</p>
                                    <div class="action-buttons d-none">
                                        <div class="col col-3">
                                            <form class="btn-outline-danger"
                                                action="{{ in_array($firstProduct->MaSP, $favorites) ? route('favorite.remove', $firstProduct->MaSP) : route('favorite.add', $firstProduct->MaSP) }}"
                                                method="POST" style="display: inline;"
                                                onsubmit="updateFavoriteCount()">
                                                @csrf
                                                @if (in_array($firstProduct->MaSP, $favorites))
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger"
                                                        id="wishlistBtn{{ $firstProduct->MaSP }}"
                                                        aria-label="Add to wishlist">
                                                        <i style="color: red" class="bi bi-heart"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-outline-danger"
                                                        id="wishlistBtn{{ $firstProduct->MaSP }}"
                                                        aria-label="Add to wishlist">
                                                        <i style="color: gray" class="bi bi-heart"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                        <div class="col col-3">
                                            <form class="btn-outline-primary"
                                                action="{{ route('cart.add') }}" method="POST"
                                                onsubmit="updateCartCount()">
                                                @csrf
                                                <input type="hidden" name="product_id"
                                                    value="{{ $firstProduct->MaSP }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button class="btn btn-outline-primary"
                                                    id="cartBtn{{ $firstProduct->MaSP }}">
                                                    <i class="bi bi-cart"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col col-3">
                                            <button class="btn btn-outline-secondary"
                                                onclick="window.location.href='{{ route('product.detail', ['id' => $firstProduct->MaSP]) }}'">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>

                                        <div class="col col-3">
                                            <button class="btn btn-outline-secondary">

                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">No products available</h5>
                                    <p class="card-text">Please check back later.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column with Tabs -->
            <div class="col-lg-8">
                <ul class="nav nav-tabs" id="productTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="featured-tab" data-bs-toggle="tab" data-bs-target="#featured"
                            type="button" role="tab" aria-controls="featured" aria-selected="true">Featured</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sale-tab" data-bs-toggle="tab" data-bs-target="#sale" type="button"
                            role="tab" aria-controls="sale" aria-selected="false">Best Sale</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="new-arrivals-tab" data-bs-toggle="tab" data-bs-target="#new-arrivals"
                            type="button" role="tab" aria-controls="new-arrivals" aria-selected="false">New
                            Arrivals</button>
                    </li>
                </ul>

                <div class="tab-content" id="productTabContent">
                    <!-- Featured Tab -->
                    <div class="tab-pane fade show active" id="featured" role="tabpanel"
                        aria-labelledby="featured-tab">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mt-3">
                            @if (isset($chuck_products) && $chuck_products->count() > 0)
                                @foreach ($chuck_products as $product)
                                    @php
                                        $category = $product->category; // Lấy Category sản phẩm
                                    @endphp
                                    <div class="col">
                                        <a href="{{ route('product.detail', ['id' => $product->MaSP]) }}"
                                            class="card text-decoration-none">
                                            <img src="{{ $product->AnhSP ?? 'https://via.placeholder.com/100' }}"
                                                class="card-img-top" alt="{{ $product->TenSP }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ number_format($product->GiaBan, 0, ',', '.') }}
                                                    ₫
                                                </h5>
                                                <p class="card-text">{{ $product->TenSP }}</p>
                                                <p class="card-text"><small class="text-muted">Category:
                                                        {{ $category->TenLoai }}</small></p>
                                                <!-- Hiển thị Category sản phẩm -->
                                                <!-- Action Buttons, hidden initially -->
                                                <div class="action-buttons d-none">
                                                    <div class="col col-3">
                                                        <form class="btn-outline-danger"
                                                            action="{{ in_array($product->MaSP, $favorites) ? route('favorite.remove', $product->MaSP) : route('favorite.add', $product->MaSP) }}"
                                                            method="POST" style="display: inline;"
                                                            onsubmit="updateFavoriteCount()">
                                                            @csrf
                                                            @if (in_array($product->MaSP, $favorites))
                                                                @method('DELETE')
                                                                <button class="btn btn-outline-danger"
                                                                    id="wishlistBtn{{ $product->MaSP }}"
                                                                    aria-label="Add to wishlist">
                                                                    <i style="color: red" class="bi bi-heart"></i>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-outline-danger"
                                                                    id="wishlistBtn{{ $product->MaSP }}"
                                                                    aria-label="Add to wishlist">
                                                                    <i style="color: gray" class="bi bi-heart"></i>
                                                                </button>
                                                            @endif
                                                        </form>
                                                    </div>
                                                    <div class="col col-3">
                                                        <form class="btn-outline-primary"
                                                            action="{{ route('cart.add') }}" method="POST"
                                                            onsubmit="updateCartCount()">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->MaSP }}">
                                                            <input type="hidden" name="quantity" value="1">
                                                            <button class="btn btn-outline-primary"
                                                                id="cartBtn{{ $product->MaSP }}">
                                                                <i class="bi bi-cart"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col col-3">
                                                        <button class="btn btn-outline-secondary"
                                                            onclick="window.location.href='{{ route('product.detail', ['id' => $product->MaSP]) }}'">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>

                                                    <div class="col col-3">
                                                        <button class="btn btn-outline-secondary">

                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">No products available</h5>
                                            <p class="card-text">Please check back later.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Best Sale Tab -->
                    <div class="tab-pane fade" id="sale" role="tabpanel" aria-labelledby="sale-tab">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mt-3">
                            @if (isset($products) && $products->count() > 0)
                                @foreach ($products as $product)
                                    @php
                                        $category = $product->category; // Lấy Category sản phẩm
                                    @endphp
                                    <div class="col">
                                        <a href="{{ route('product.detail', ['id' => $product->MaSP]) }}"
                                            class="card text-decoration-none">
                                            <img src="{{ $product->AnhSP ?? 'https://via.placeholder.com/100' }}"
                                                class="card-img-top" alt="{{ $product->TenSP }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ number_format($product->GiaBan, 0, ',', '.') }}
                                                    ₫
                                                </h5>
                                                <p class="card-text">{{ $product->TenSP }}</p>
                                                <p class="card-text"><small class="text-muted">Category:
                                                        {{ $category->TenLoai }}</small></p>
                                                <!-- Hiển thị Category sản phẩm -->
                                                <!-- Action Buttons, hidden initially -->
                                                <div class="action-buttons d-none">
                                                    <div class="col col-3">
                                                        <form class="btn-outline-danger"
                                                            action="{{ in_array($product->MaSP, $favorites) ? route('favorite.remove', $product->MaSP) : route('favorite.add', $product->MaSP) }}"
                                                            method="POST" style="display: inline;"
                                                            onsubmit="updateFavoriteCount()">
                                                            @csrf
                                                            @if (in_array($product->MaSP, $favorites))
                                                                @method('DELETE')
                                                                <button class="btn btn-outline-danger"
                                                                    id="wishlistBtn{{ $product->MaSP }}"
                                                                    aria-label="Add to wishlist">
                                                                    <i style="color: red" class="bi bi-heart"></i>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-outline-danger"
                                                                    id="wishlistBtn{{ $product->MaSP }}"
                                                                    aria-label="Add to wishlist">
                                                                    <i style="color: gray" class="bi bi-heart"></i>
                                                                </button>
                                                            @endif
                                                        </form>
                                                    </div>
                                                    <div class="col col-3">
                                                        <form class="btn-outline-primary"
                                                            action="{{ route('cart.add') }}" method="POST"
                                                            onsubmit="updateCartCount()">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->MaSP }}">
                                                            <input type="hidden" name="quantity" value="1">
                                                            <button class="btn btn-outline-primary"
                                                                id="cartBtn{{ $product->MaSP }}">
                                                                <i class="bi bi-cart"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col col-3">
                                                        <button class="btn btn-outline-secondary"
                                                            onclick="window.location.href='{{ route('product.detail', ['id' => $product->MaSP]) }}'">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>

                                                    <div class="col col-3">
                                                        <button class="btn btn-outline-secondary">

                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">No products available</h5>
                                            <p class="card-text">Please check back later.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- New Arrivals Tab -->
                    <div class="tab-pane fade" id="new-arrivals" role="tabpanel" aria-labelledby="new-arrivals-tab">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mt-3">
                            @if (isset($products) && $products->count() > 0)
                                @foreach ($products as $product)
                                    @php

                                        $category = $product->category; // Lấy loại sản phẩm
                                    @endphp
                                    <div class="col">
                                        <a href="{{ route('product.detail', ['id' => $product->MaSP]) }}"
                                            class="card text-decoration-none">
                                            <img src="{{ $product->picture ?? 'https://via.placeholder.com/100' }}"
                                                class="card-img-top" alt="{{ $product->TenSP }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ number_format($product->GiaBan, 0, ',', '.') }}
                                                    ₫
                                                </h5>
                                                <p class="card-text">{{ $product->TenSP }}</p>
                                                <p class="card-text"><small class="text-muted">Category:
                                                        {{ $category->TenLoai }}</small></p>
                                                <!-- Hiển thị Category sản phẩm -->
                                                <!-- Action Buttons, hidden initially -->
                                                <div class="action-buttons d-none">
                                                    <div class="col col-3">
                                                        <form class="btn-outline-danger"
                                                            action="{{ in_array($product->MaSP, $favorites) ? route('favorite.remove', $product->MaSP) : route('favorite.add', $product->MaSP) }}"
                                                            method="POST" style="display: inline;"
                                                            onsubmit="updateFavoriteCount()">
                                                            @csrf
                                                            @if (in_array($product->MaSP, $favorites))
                                                                @method('DELETE')
                                                                <button class="btn btn-outline-danger"
                                                                    id="wishlistBtn{{ $product->MaSP }}"
                                                                    aria-label="Add to wishlist">
                                                                    <i style="color: red" class="bi bi-heart"></i>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-outline-danger"
                                                                    id="wishlistBtn{{ $product->MaSP }}"
                                                                    aria-label="Add to wishlist">
                                                                    <i style="color: gray" class="bi bi-heart"></i>
                                                                </button>
                                                            @endif
                                                        </form>
                                                    </div>
                                                    <div class="col col-3">
                                                        <form class="btn-outline-primary"
                                                            action="{{ route('cart.add') }}" method="POST"
                                                            onsubmit="updateCartCount()">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->MaSP }}">
                                                            <input type="hidden" name="quantity" value="1">
                                                            <button class="btn btn-outline-primary"
                                                                id="cartBtn{{ $product->MaSP }}">
                                                                <i class="bi bi-cart"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col col-3">
                                                        <button class="btn btn-outline-secondary"
                                                            onclick="window.location.href='{{ route('product.detail', ['id' => $product->MaSP]) }}'">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>

                                                    <div class="col col-3">
                                                        <button class="btn btn-outline-secondary">

                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">No products available</h5>
                                            <p class="card-text">Please check back later.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </section>



        <!-- Hot New Arrivals Section -->
        <section>
            <h2>Hot New Arrivals</h2>
            <div id="newArrivalsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @if (isset($products) && $products->count() > 0)
                        @foreach ($products->chunk(4) as $chunkIndex => $chunk)
                            @php
                                $category = $product->category; // Lấy loại sản phẩm
                            @endphp
                            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                                <div class="row row-cols-2 row-cols-md-4 g-4 mt-3">
                                    @foreach ($chunk as $product)
                                        <div class="col">
                                            <a href="{{ route('product.detail', ['id' => $product->MaSP]) }}"
                                                class="card text-decoration-none">
                                                <img src="{{ $product->AnhSP ?? 'https://via.placeholder.com/100' }}"
                                                    class="card-img-top" alt="{{ $product->TenSP }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        {{ number_format($product->GiaBan, 0, ',', '.') }} ₫
                                                    </h5>

                                                    <p class="card-text">{{ $product->TenSP }}</p>
                                                    <p class="card-text"><small class="text-muted">Category:
                                                            {{ $category->TenLoai }}</small></p>
                                                    <div class="action-buttons d-none">
                                                        <div class="col col-3">
                                                            <form class="btn-outline-danger"
                                                                action="{{ in_array($product->MaSP, $favorites) ? route('favorite.remove', $product->MaSP) : route('favorite.add', $product->MaSP) }}"
                                                                method="POST" style="display: inline;"
                                                                onsubmit="updateFavoriteCount()">
                                                                @csrf
                                                                @if (in_array($product->MaSP, $favorites))
                                                                    @method('DELETE')
                                                                    <button class="btn btn-outline-danger"
                                                                        id="wishlistBtn{{ $product->MaSP }}"
                                                                        aria-label="Add to wishlist">
                                                                        <i style="color: red" class="bi bi-heart"></i>
                                                                    </button>
                                                                @else
                                                                    <button class="btn btn-outline-danger"
                                                                        id="wishlistBtn{{ $product->MaSP }}"
                                                                        aria-label="Add to wishlist">
                                                                        <i style="color: gray" class="bi bi-heart"></i>
                                                                    </button>
                                                                @endif
                                                            </form>
                                                        </div>
                                                        <div class="col col-3">
                                                            <form class="btn-outline-primary"
                                                                action="{{ route('cart.add') }}" method="POST"
                                                                onsubmit="updateCartCount()">
                                                                @csrf
                                                                <input type="hidden" name="product_id"
                                                                    value="{{ $product->MaSP }}">
                                                                <input type="hidden" name="quantity" value="1">
                                                                <button class="btn btn-outline-primary"
                                                                    id="cartBtn{{ $product->MaSP }}">
                                                                    <i class="bi bi-cart"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <div class="col col-3">
                                                            <button class="btn btn-outline-secondary"
                                                                onclick="window.location.href='{{ route('product.detail', ['id' => $product->MaSP]) }}'">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                        </div>

                                                        <div class="col col-3">
                                                            <button class="btn btn-outline-secondary">

                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="carousel-item active">
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <img src="https://via.placeholder.com/100" class="card-img-top" alt="Product">
                                        <div class="card-body">
                                            <h5 class="card-title">No products available</h5>
                                            <p class="card-text">Please check back later.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#newArrivalsCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#newArrivalsCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                <div class="carousel-indicators">
                    @foreach ($products->chunk(4) as $chunkIndex => $chunk)
                        <button type="button" data-bs-target="#newArrivalsCarousel"
                            data-bs-slide-to="{{ $chunkIndex }}" class="{{ $chunkIndex === 0 ? 'active' : '' }}"
                            aria-current="true" aria-label="Slide {{ $chunkIndex + 1 }}"></button>
                    @endforeach
                </div>
            </div>
        </section>

    </main>
    <style>
        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
        }

        .carousel-control-prev {
            left: 0;
            margin-left: -20px;
        }

        .carousel-control-next {
            margin-right: -20px;
            right: 0;
        }

        .carousel-indicators {
            margin-top: 20px;
            position: relative !important;
            right: 0;
            left: 0;
            z-index: 2;
            display: flex;
            justify-content: center;
            padding: 0;
            margin-right: 15%;
            margin-left: 15%;
        }

        .carousel-indicators [data-bs-target] {
            background-color: gray
        }

        .carousel-indicators .active {
            background-color: royalblue;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            margin-left: 10px;
        }

        /* General Styling for Card */
        .card {
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        /* Image Styling */
        .card-img-top {
            height: 250px;
            object-fit: cover;
        }

        /* Tab Content */
        .tab-content .row-cols-md-2 .col {
            margin-bottom: 20px;
        }

        .product-card {
            position: relative;
            overflow: hidden;
        }

        /* General Styling for Card */
        .product-card {
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            transition: transform 0.3s ease-in-out;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        /* Hide buttons initially */
        .product-buttons {
            display: none;
            bottom: 20px;
            /* Adjust position inside the card */
        }

        /* Show buttons on hover */
        .product-card:hover .product-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            /* Space between buttons */
        }

        /* Ensure buttons are displayed above the card content */
        .product-buttons button {
            flex: 1;
            z-index: 1;
        }

        /* Image Styling */
        .card-img-top {
            height: 250px;
            object-fit: cover;
        }



        .action-buttons {
            width: 100%;
            display: none;
            /* Ẩn các nút khi chưa hover */
        }

        .card:hover .action-buttons {
            list-style-type: none;
            padding: 0;
            margin: 10px;
            display: flex !important;
            /* display: block */

        }
    </style>

    <script>
        function updateCounts() {
            // Update cart count
            fetch("{{ route('cart.count') }}")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('cart-count').innerText = data.count || 0;
                })
                .catch(error => console.error('Error updating cart count:', error));

            // Update favorite count
            fetch("{{ route('favorite.count') }}")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.count);
                    document.getElementById('favorite-count').innerText = data.count || 0;
                })
                .catch(error => console.error('Error updating favorite count:', error));
        }

        $(document).ready(function() {
            $('.card').hover(
                function() {
                    $(this).find('.action-buttons').removeClass('d-none');
                },
                function() {
                    $(this).find('.action-buttons').addClass('d-none');
                }
            );
        });
    </script>

@endsection
