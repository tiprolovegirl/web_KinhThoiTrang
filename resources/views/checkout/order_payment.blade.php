@extends('Layout.app')

@section('content')
    <div class="container mt-5">
        <h2>Checkout Payment</h2>

        <div class="row" style="margin-top: 50px">
            <!-- Cột bên trái: Thông tin giỏ hàng -->
            <div class="col-md-6">
                <h4>Thông tin giỏ hàng</h4>
                <hr />
                @if (!empty($cart) && count($cart) > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $cartTotal = 0;
                            @endphp
                            @foreach ($cart as $id => $details)
                                @php
                                    $itemTotal = $details['price'] * $details['quantity'];
                                    $cartTotal += $itemTotal;
                                @endphp
                                <tr>
                                    <td>{{ $details['name'] }}</td>
                                    <td>{{ $details['quantity'] }}</td>
                                    <td>{{ number_format($details['price'], 0, ',', '.') }} ₫</td>
                                    <td>{{ number_format($itemTotal, 0, ',', '.') }} ₫</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Tổng tiền của giỏ hàng -->
                    <div class="mt-3">
                        <h5><strong>Tổng tiền trong giỏ:</strong> {{ number_format($cartTotal, 0, ',', '.') }} ₫</h5>
                    </div>
                @else
                    <p>Giỏ hàng của bạn đang trống.</p>
                @endif
            </div>

            <!-- Cột bên phải: Thông tin thanh toán -->
            <div class="col-md-6">
                <h4>Thông tin thanh toán</h4>
                <hr />
                <p><strong>Tổng tiền cần thanh toán:</strong> {{ number_format($total, 0, ',', '.') }} ₫</p>
                <hr />

                <div style="display: flex">
                    <div style="margin: 10px">
                        <input type="radio" name="payment_method" onclick="hiddenQR()"/>
                        <label for="">Thanh toán tiền mặt</label>
                    </div>
                    <div style="margin: 10px">
                        <input type="radio" name="payment_method" onclick="showQR()" />
                        <label for="">Thanh toán qua QR</label>
                    </div>

                </div>
                <div id="qr_bank" class="qr_bank">
                    <style>
                        .qr_bank{
                            display: none;
                        }
                    </style>
                    <h4>Quét mã QR để chuyển khoản thanh toán</h4>
                    <h5>{{ $bank_name }}</h5> <br/>
                    <img src="{{ $img }}" alt="qrcode" class="img-fluid" />


                </div>

                 <!-- Nút hoàn tất thanh toán -->
                 <div class="mt-4">
                    <form action="{{ route('checkout.paymentComplete') }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg">Đặt hàng</button>
                    </form>
                </div>

            </div>
        </div>

    </div>

    <script>
        function showQR(){
            document.getElementById('qr_bank').style.display='block';
        }
        function hiddenQR(){
            document.getElementById('qr_bank').style.display='none';
        }
    </script>
@endsection
