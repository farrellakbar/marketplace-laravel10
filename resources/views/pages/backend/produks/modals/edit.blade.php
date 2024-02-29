<!-- Sweet Alert css -->
<link href="{{ asset('/') }}assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">


<form class="form" id="form_edit" enctype="multipart/form-data">
    @csrf
    <div class="modal-body" id="modalCenterContent">
        <div class="row g-3">
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <input type="text" class="form-control" name="name" id="name" value="{{$produk->name}}"
                    placeholder="Input Name" required>
                <div class="validation-name text-danger"></div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <input type="number" class="form-control" name="stok" id="stok" value="{{$produk->stok}}"
                    placeholder="Input Name" required>
                <div class="validation-stok text-danger"></div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <input type="text" class="form-control" name="harga" id="harga" value="{{$produk->harga}}"
                    placeholder="Input Name" required>
                <div class="validation-harga text-danger"></div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="dokumen" class="form-label">Foto</label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <input type="file" class="form-control" name="dokumen" id="dokumen">
                <p class="validation-cover_id text-danger" style="font-size: 12px">Catatan: Jika tidak ada perubahan pada sampul buku, silakan biarkan kolom ini kosong.</p>
                <div class="validation-dokumen text-danger"></div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="isActive" class="form-label">Status <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <div class="form-check form-switch form-switch">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{$produk->is_active == true ? 'checked' : ''}}>
                  </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary waves-effect text-left" data-bs-dismiss="modal"
            aria-label="Close">
            <i class="fa fa-times"></i> &nbsp; Cancel
        </button>
        <button type="submit" class="btn btn-sm btn-success waves-effect text-left" id="btn_s">
            <i class="fa fa-save"></i> &nbsp; Save
        </button>
    </div>
</form>
 <!-- Sweet-Alert js -->
 <script src="{{ asset('/') }}assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
<script>
    $(document).ready(function() {

    });
    //OPEN PROSES edit
        $('#form_edit').on('submit', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            idata = new FormData($('#form_edit')[0]);
            idata.append('_method','PUT');

            var act = "{{ route('produk.update', [':param']) }}";
                            act = act.replace(':param', '{{encrypt($produk->id)}}');
            $.ajax({
                type: "POST",
                url: act,
                data: idata,
                processData: false,
                contentType: false,
                cache: false,

                success: function(data) {
                    $("#form_edit")[0].reset();
                    $("#modalCenter").modal('hide');
                    swal({
                        title: data.title,
                        text: data.message,
                        type: 'success',
                        confirmButtonClass: 'btn btn-success',
                    }).then(function () {
                        datatable().ajax.reload();
                        if(data.dokumen){
                            $(`#productImage-${data.dokumen}`).html('src', `{{ asset('storage/${data.dokumen.file_path}') }}`);
                        }
                    })
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;
                    if(response.messageValidate){
                        if (response.messageValidate['name']) {
                            $('.validation-name').text(response.messageValidate['name'][0]);
                        } else {
                            $('.validation-name').text('');
                        }
                        if (response.messageValidate['stok']) {
                            $('.validation-stok').text(response.messageValidate['stok'][0]);
                        } else {
                            $('.validation-stok').text('');
                        }
                        if (response.messageValidate['harga']) {
                            $('.validation-harga').text(response.messageValidate['harga'][0]);
                        } else {
                            $('.validation-harga').text('');
                        }
                        if (response.messageValidate['dokumen']) {
                            $('.validation-dokumen').text(response.messageValidate['dokumen'][0]);
                        } else {
                            $('.validation-dokumen').text('');
                        }
                    }
                    swal({
                        title: response.title,
                        text: response.message,
                        type: 'error',
                        confirmButtonClass: 'btn btn-success',
                    })
                }
            });
        });
    //CLOSE PROSES edit
</script>
