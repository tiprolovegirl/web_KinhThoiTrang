@extends('Layout.app')

@section('content')
    <div class="container mt-5">
        <h2>{{ Str::upper($product->name) }}</h2>
        <!-- Hiển thị thông báo nếu có -->
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
        <div class="product-detail">
            <div class="row">
                <div class="col-md-6">
                    <!-- Hình ảnh sản phẩm chính -->
                    <img id="mainImage" style="border-radius: 8px"
                        src="{{ asset($product->AnhSP) ?? 'https://via.placeholder.com/400' }}" class="img-fluid"
                        alt="{{ $product->name }}">

                    <!-- Hình ảnh con -->
                    <div class="mt-3 d-flex justify-content-between">
                        <img onclick="changeImage(this)"
                            src="{{ asset($product->AnhSP) ?? 'https://via.placeholder.com/100' }}"
                            style="border-radius: 8px; width: 200px; height: 100px; cursor: pointer;" alt="Thumbnail 1">
                        <img onclick="changeImage(this)"
                            src="{{ asset($product->AnhSP) ?? 'https://via.placeholder.com/100' }}"
                            style="border-radius: 8px; width: 200px; height: 100px; cursor: pointer;" alt="Thumbnail 2">
                        <img onclick="changeImage(this)"
                            src="{{ asset($product->AnhSP) ?? 'https://via.placeholder.com/100' }}"
                            style="border-radius: 8px; width: 200px; height: 100px; cursor: pointer;" alt="Thumbnail 3">
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-between align-items-start">
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <h5 class="mb-0">Tên sản phẩm: {{ $product->TenSP }}</h5>
                        <h5 class="mb-0">Giá: {{ number_format($product->GiaBan, 0, ',', '.') }} ₫</h5>
                        <!-- Mô tả sản phẩm -->
                        <h5 class="mb-0">Mô tả sản phẩm:</h5>
                        <p>{{ $product->MoTaChiTiet ?? 'Chưa có mô tả cho sản phẩm này.' }}</p>

                        @php
                            // Lấy danh sách yêu thích từ session
                            $favorites = session()->get('favorites', []);
                        @endphp
                        <!-- Form thêm vào giỏ hàng -->
                        <form action="{{ route('cart.add') }}" method="POST" onsubmit="updateCartCount()">
                            @csrf

                            <!-- Lựa chọn số lượng -->
                            <div class="mb-3 gap-3">
                                <label for="quantity{{ $product->MaSP }}" class="form-label">Số lượng</label>
                                <input type="number" name="quantity" id="quantity{{ $product->MaSP }}"
                                    class="form-control" value="1" min="1"
                                    onchange="updateHiddenQuantity({{ $product->MaSP }})" onkeydown="return false">
                            </div>

                            <div class="mb-3 gap-3">
                                <label for="degree_of_glass{{ $product->MaSP }}" class="form-label">Độ trái</label>
                                <input type="text" name="do_trai" class="form-control" placeholder="Nhập thông số">
                            </div>

                            <div class="mb-3 gap-3">
                                <label for="degree_of_glass{{ $product->MaSP }}" class="form-label">Độ phải</label>
                                <input type="text" name="do_phai" class="form-control" placeholder="Nhập thông số">
                            </div>

                            <!-- Select Gọng -->
                            <div class="mb-3 gap-3">
                                <label for="gong{{ $product->MaSP }}" class="form-label">Chọn Gọng</label>
                                <select name="gong" class="form-select">
                                    @foreach ($gongs as $gong)
                                        <!-- Assuming you pass $gongs to the view -->
                                        <option value="{{ $gong->MaCLG }}">
                                            {{ $gong->TenCLG }} - Màu: {{ $gong->MauGong }} - Dài:
                                            {{ $gong->ChieuDaiGongKinh }} - Rộng: {{ $gong->ChieuRongGongKinh }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select Tròng -->
                            <div class="mb-3 gap-3">
                                <label for="trong{{ $product->MaSP }}" class="form-label">Chọn Tròng</label>
                                <select name="trong" class="form-select">
                                    @foreach ($trongs as $trong)
                                        <!-- Assuming you pass $trongs to the view -->
                                        <option value="{{ $trong->MaCLT }}">
                                            {{ $trong->TenCLT }} - Màu: {{ $trong->MauTrong }} - Rộng:
                                            {{ $trong->DoRongTrong }} - Cao: {{ $trong->DoCaoTrong }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="product_id" value="{{ $product->MaSP }}">
                            <input type="hidden" name="quantity" id="quantityInput{{ $product->MaSP }}" value="1">
                            <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
                        </form>
                    </div>

                    <!-- Nút yêu thích -->
                    <form
                        action="{{ in_array($product->MaSP, $favorites) ? route('favorite.remove', $product->MaSP) : route('favorite.add', $product->MaSP) }}"
                        method="POST" style="display: inline;" onsubmit="updateFavoriteCount()">
                        @csrf
                        @if (in_array($product->proc_id, $favorites))
                            @method('DELETE')
                            <button class="btn p-0 ms-2" type="submit" aria-label="Remove from wishlist">
                                <i class="bi bi-heart-fill" style="font-size: 1.5rem; color: red;"></i>
                            </button>
                        @else
                            <button class="btn p-0 ms-2" type="submit" aria-label="Add to wishlist">
                                <i class="bi bi-heart" style="font-size: 1.5rem; color: gray;"></i>
                            </button>
                        @endif
                    </form>
                </div>
            </div>


        </div>
    </div>

    <script>
        function updateHiddenQuantity(productId) {
            const quantityValue = document.getElementById('quantity' + productId).value;
            if (quantityValue < 0) {
                alert("Số lượng phải lớn hơn 0!!!");
                return;
            }
            document.getElementById('quantityInput' + productId).value = quantityValue;
        }
    </script>
    <script>
        function changeImage(element) {
            // Lấy src của ảnh con được nhấp vào
            const newSrc = element.src;
            // Đổi ảnh chính thành ảnh con
            document.getElementById('mainImage').src = newSrc;
        }
    </script>
@endsection
