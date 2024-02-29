<!-- Sweet Alert css -->
<link href="{{ asset('/') }}assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">


<form class="form" id="form_create" enctype="multipart/form-data">
    @csrf
    <div class="modal-body" id="modalCenterContent">
        <div class="row g-3">
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <input type="text" class="form-control" name="name" id="name" value=""
                    placeholder="Input Name" required>
                <div class="validation-name text-danger"></div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <input type="number" class="form-control" name="stok" id="stok" value=""
                    placeholder="Input Name" required>
                <div class="validation-stok text-danger"></div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <input type="text" class="form-control" name="harga" id="harga" value=""
                    placeholder="Input Name" required>
                <div class="validation-harga text-danger"></div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="dokumen" class="form-label">Foto <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <input type="file" class="form-control" name="dokumen" id="dokumen" required>
                <div class="validation-dokumen text-danger"></div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="isActive" class="form-label">Status <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <div class="form-check form-switch form-switch">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
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
    //OPEN PROSES STORE
        $('#form_create').on('submit', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            idata = new FormData($('#form_create')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('produk.store') }}",
                data: idata,
                processData: false,
                contentType: false,
                cache: false,

                success: function(data) {
                    $("#form_create")[0].reset();
                    $("#modalCenter").modal('hide');
                    swal({
                        title: data.title,
                        text: data.message,
                        type: 'success',
                        confirmButtonClass: 'btn btn-success',
                    }).then(function () {
                        datatable().ajax.reload();
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
    //CLOSE PROSES STORE
</script>
