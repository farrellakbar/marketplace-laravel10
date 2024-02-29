@extends('layouts.frontend')
@section('title','Marketplace')
@section('content')
<div class="page-content">
    <!-- inner page banner -->
    <div class="dz-bnr-inr overlay-secondary-dark dz-bnr-inr-sm" style="background-image:url(images/background/bg3.jpg);">
        <div class="container">
            <div class="dz-bnr-inr-entry">
                <h1>Checkout</h1>
                <nav aria-label="breadcrumb" class="breadcrumb-row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('beranda')}}"> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{route('order.index')}}"> Order</a></li>
                        <li class="breadcrumb-item">Checkout</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- inner page banner End-->

    <!-- contact area -->
    <section class="content-inner shop-account">
        <!-- Product -->
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="widget">
                        <h4 class="widget-title">Checkout Orderan Kamu</h4>
                        <table class="table-bordered check-tbl">
                            <thead class="text-center">
                                <tr>
                                    <th>Foto</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produks as $produk)
                                    <tr>
                                        <td class="product-item-img"><img src="{{ asset('storage/produk/'.$produk->dokumen->filename) }}" alt=""></td>
                                        <td class="product-item-name">{{$produk->name}}</td>
                                        <td class="product-price">{{$produk->pivot->quantity}}</td>
                                        <td class="product-price">Rp. {{$produk->pivot->sub_total}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form class="shop-form widget">
                        <h4 class="widget-title">Total Order</h4>
                        <table class="table-bordered check-tbl mb-4">
                            <tbody>
                                <tr>
                                    <td>Total</td>
                                    <td class="product-price-total">Rp. {{$order->total_harga}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group" id='btnChange'>
                            @if ($snapToken != null)
                                <button id="pay-button" class="btn btn-danger btnhover" type="button">Bayar Sekarang</button>
                            @else
                                <button id="" class="btn btn-success btnhover disabled" type="button">Lunas</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Product END -->
    </section>
    <!-- contact area End-->
</div>
@endsection
@section('bottomscript')
<script>
    $(document).ready(function () {

    });
</script>
{{-- MIDTRANS --}}
    @if ($snapToken != null)
        <script type="text/javascript">
            // For example trigger on button clicked, or any time you need
            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function () {
                // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
                // Also, use the embedId that you defined in the div above, here.
                window.snap.pay('{{$snapToken}}', {
                    // embedId: 'snap-container',
                    onSuccess: function (result) {
                        /* You may add your own implementation here */
                        alert("payment success!");
                        $('#btnChange').html('<button id="" class="btn btn-success btnhover disabled" type="button">Lunas</button>');
                        console.log(result);
                    },
                    onPending: function (result) {
                        /* You may add your own implementation here */
                        alert("wating your payment!"); console.log(result);
                    },
                    onError: function (result) {
                        /* You may add your own implementation here */
                        alert("payment failed!"); console.log(result);
                    },
                    onClose: function () {
                        /* You may add your own implementation here */
                        alert('you closed the popup without finishing the payment');
                    }
                });
            });
        </script>
    @endif
@endsection

