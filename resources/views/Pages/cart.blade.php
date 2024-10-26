@extends('Layout.app')

@section('content')
    <div class="container">
        <h2>Your Cart</h2>

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
        @if (!empty($cart) && count($cart) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Độ trái</th>
                        <th>Độ phải</th>
                        <th>Tròng</th>
                        <th>Gọng</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($cart as $id => $details)
                        @php
                            $itemTotal = $details['price'] * $details['quantity'];
                            $total += $itemTotal;
                        @endphp
                        <tr>
                            <td>
                                <img src="{{ $details['picture'] }}" width="50" height="50"
                                    alt="{{ $details['name'] }}">
                                {{ $details['name'] }}
                            </td>
                            <td>
                                {{ $details['do_trai'] ?? '' }}
                            </td>
                            <td>
                                {{ $details['do_phai'] ?? '' }}
                            </td>
                            <td>
                                {{ $details['trong'] ?? '' }}
                            </td>
                            <td>
                                {{ $details['gong'] ?? '' }}
                            </td>
                            <td>
                                <!-- Input để thay đổi số lượng -->
                                <form action="{{ route('cart.update', $id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1"
                                        style="width: 60px;" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td>{{ number_format($details['price'], 0, ',', '.') }} ₫</td>
                            <td>{{ number_format($itemTotal, 0, ',', '.') }} ₫</td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                <h4>Total Amount: {{ number_format($total, 0, ',', '.') }} ₫</h4>
            </div>

            <!-- Nút Checkout -->
            <div class="mt-3">
                <a href="{{ route('checkout.payment') }}" class="btn btn-success">Proceed to Checkout</a>
            </div>
        @else
            <p>Your cart is empty.</p>
        @endif

        <div class="mt-3">
            <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
@endsection
