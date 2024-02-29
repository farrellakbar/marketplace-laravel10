@extends('layouts.frontend')
@section('title','Marketplace')
@section('content')
    <div class="page-content">
        <!-- inner page banner -->
            <div class="dz-bnr-inr overlay-secondary-dark dz-bnr-inr-sm" style="background-image:url(images/background/bg3.jpg);">
                <div class="container">
                    <div class="dz-bnr-inr-entry">
                        <h1>Order</h1>
                        <nav aria-label="breadcrumb" class="breadcrumb-row">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('beranda')}}"> Beranda</a></li>
                                <li class="breadcrumb-item">Order</li>
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
                <div class="row mb-5">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table check-tbl">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Produk</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th><i class="fa fa-ellipsis-h"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td class="product">{{$order->created_at}}</td>
                                            <td class="product-item-name">
                                                @foreach ($order->keranjangDetails as $keranjang)
                                                    - {{$keranjang->produk->name}} ({{'@'.$keranjang->quantity}} item) <br>
                                                @endforeach
                                            </td>
                                            <td class="product-item-price">Rp. {{$order->total_harga}}</td>
                                            <td class="product-item-quantity">
                                                {{$order->keranjangDetails[0]->status}}
                                            </td>
                                            <td >
                                                <a href="{{route('order.detailCheckout', encrypt($order->id) )}}" type="button" class="btn btn-sm btn-outline-info"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                Tidak ada produk
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
@endsection

