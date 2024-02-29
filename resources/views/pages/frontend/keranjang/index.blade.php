@extends('layouts.frontend')
@section('title','Marketplace')
@section('content')
    <div class="page-content">
        <!-- inner page banner -->
            <div class="dz-bnr-inr overlay-secondary-dark dz-bnr-inr-sm" style="background-image:url(images/background/bg3.jpg);">
                <div class="container">
                    <div class="dz-bnr-inr-entry">
                        <h1>Keranjang</h1>
                        <nav aria-label="breadcrumb" class="breadcrumb-row">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('beranda')}}"> Beranda</a></li>
                                <li class="breadcrumb-item">Keranjang</li>
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
                                        <th>Produk</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th class="text-end">Close</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($user->produks()->wherePivot('status', 'keranjang')->get() as $produk)
                                        <tr id='tr_{{$produk->id}}'>
                                            <td class="product-item-img"><img src="{{ asset('storage/produk/'.$produk->dokumen->filename) }}" alt=""></td>
                                            <td class="product-item-name">{{$produk->name}}</td>
                                            <td class="product-item-price">Rp. {{$produk->harga}}</td>
                                            <td class="product-item-quantity">
                                                <div class="quantity btn-quantity style-1 me-3">
                                                    <input id="demo_vertical2" type="number" value="{{$produk->pivot->quantity}}" name="quantity[{{$produk->id}}]"/>
                                                </div>
                                            </td>
                                            <td class="product-item-totle" id="subtotal{{$produk->id}}">Rp. {{$produk->pivot->quantity * $produk->harga}}</td>
                                            <td class="product-item-close">
                                                <div onclick="removeCart({{$produk->id}})">
                                                    <a href="javascript:void(0);" class="ti-close"></a>
                                                </div>
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
                <div class="row">
                    <div class="col-lg-6">

                    </div>
                    <div class="col-lg-6">
                        <div class="widget">
                            <h4 class="widget-title">Cart Total</h4>
                            <table class="table-bordered check-tbl m-b25">
                                <tbody>
                                    <tr>
                                        <td>Total</td>
                                        <td id="total"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group m-b25">
                                <button type='button' class='btn btn-primary btnhover' title='Checkout Sekarang' onClick="checkout()">
                                    Checkout
                                </button>
                            </div>
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

        calculateTotal();
    });
    $('input[name^="quantity"]').on('change', function() {
            var id = $(this).attr('name').split('[')[1].split(']')[0];
            var newQuantity = $(this).val();
            var act = "{{ route('keranjang.updateQuantityCart', ':param') }}".replace(':param', id);

            var data = new FormData();
                data.append('_method', 'PUT');
                data.append('_token', '{{ csrf_token() }}');
            // alert(newQuantity);
            $.ajax({
                url: act,
                type: "POST",
                data: {
                    _method: 'PUT',
                    _token: "{{ csrf_token() }}",
                    quantity: newQuantity
                },
                success: function(response) {
                    $('#subtotal' + id).text('Rp. ' + response.sub_total);
                    calculateTotal();
                    // alert(response.sub_total);
                },
                error: function(xhr, status, error) {
                    alert('eror');
                }
            });
        });
    function calculateTotal() {
        var total = 0;
        $('[id^="subtotal"]').each(function() {
            var subtotal = $(this).text().replace('Rp. ', '');
            total += parseFloat(subtotal);
        });
        $('#total').text('Rp. ' + total);
    }
    function removeCart(id){
        var act = "{{ route('keranjang.removeProductCart', ':param') }}".replace(':param', id);
        var data = new FormData();

        $.ajax({
            url: act,
            type: "DELETE",
            data: {
                    _token: "{{ csrf_token() }}",
                },
            success: function(response) {
                swal({
                        title: response.title,
                        text: response.message,
                        type: 'success',
                        confirmButtonClass: 'btn btn-success',
                    }).then(function(response) {
                        $(`#tr_${id}`).html('');
                        calculateTotal();
                    });
            },
            error: function(xhr, status, error) {
                alert('eror');
            }
        });
    }
    function checkout(){
        swal({
                title: 'Periksa kembali',
                text: `Apakah benar anda ingin checkout ?`,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, checkout!',
                cancelButtonText:'Cancel',
                confirmButtonClass: 'btn btn-success',
            }).then(function(result) {
                if (result == true) {
                    $.ajax({
                        url: "{{ route('keranjang.checkout') }}",
                        data:   {
                            _token: '{{ csrf_token() }}',
                        },
                        type: 'POST',
                        success: function(data) {
                            swal({
                                type: 'success',
                                title: data.title,
                                text: data.message,
                                confirmButtonClass: 'btn btn-success',
                            }).then(function () {
                                window.location.href = "{{ route('beranda') }}"
                            });
                        },
                        error: function(xhr, status, error) {
                            var response = xhr.responseJSON;
                            swal({
                                type: 'error',
                                title: response.title,
                                text: response.message,
                                confirmButtonClass: 'btn btn-success',
                            });
                        }
                    });
                }
            });
    }
    if($("input[id='demo_vertical2']").length > 0 ) {
		jQuery("input[id='demo_vertical2']").TouchSpin({
		  verticalbuttons: true,
		  verticalupclass: 'ti-plus',
		  verticaldownclass: 'ti-minus'
		});
	}

</script>
@endsection

