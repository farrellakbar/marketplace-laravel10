@extends('layouts.frontend')
@section('title','Marketplace')
@section('content')
    <div class="page-content bg-white">
        <!-- Book Sale -->
        <section class="content-inner-1">
            <div class="container">
                <div class="section-head book-align">
                    <h2 class="title mb-0">Produk</h2>
                    <div class="pagination-align style-1">
                        <div class="swiper-button-prev"><i class="fa-solid fa-angle-left"></i></div>
                        <div class="swiper-pagination-two"></div>
                        <div class="swiper-button-next"><i class="fa-solid fa-angle-right"></i></div>
                    </div>
                </div>
                <div class="swiper-container books-wrapper-3 swiper-four">
                    <div class="swiper-wrapper">
                        @foreach ($produks as $produk)
                            <div class="swiper-slide">
                                <div class="books-card style-3 wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="dz-media">
                                        <img src="{{ asset('storage/produk/'.$produk->dokumen->filename) }}" alt="produk">
                                    </div>
                                    <div class="dz-content">
                                        <h5 class="title"><a href="books-grid-view.html">{{$produk->name}}</a></h5>
                                        <div class="book-footer">
                                            <div class="rate">
                                                Stok : {{$produk->stok}}
                                            </div>
                                            <div class="price">
                                                <span class="price-num">Rp. {{$produk->harga}}</span>
                                            </div>

                                        </div>
                                        <div class="my-2">
                                            <button class="btn btn-sm btn-primary w-100" onclick="addToCart('{{encrypt($produk->id)}}')">
                                                <i class="fa fa-shopping-cart"></i>&nbsp; Masukkan Keranjang
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- Book Sale End -->
    </div>
@endsection
@section('bottomscript')
<script>
    $(document).ready(function () {

    });
    function addToCart(param){
        var act = `{{route('keranjang.addToCart',':param') }}`.replace(':param',param);
        var data = new FormData();
            data.append('_method', 'PUT');
            data.append('_token', '{{ csrf_token() }}');
        $.ajax({
            type: "POST",
            url: act,
            data: data,
            processData: false,
            contentType: false,
            success: function(data){
                swal({
                        title: data.title,
                        text: data.message,
                        type: 'success',
                        confirmButtonClass: 'btn btn-success',
                    })
            }
        })
    }
</script>
@endsection

