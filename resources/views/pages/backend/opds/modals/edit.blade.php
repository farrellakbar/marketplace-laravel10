
<!-- Sweet Alert css -->
<link href="{{ asset('/') }}assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

<form class="form" id="form_edit">
    @csrf
    <div class="modal-body" id="modalCenterContent">
        <div class="row g-3">
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <input type="text" class="form-control" name="name" id="name" value="{{$opd->name}}"
                    placeholder="Input Name" required>
                <div class="validation-name text-danger"></div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="isActive" class="form-label">Status <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <div class="form-check form-switch form-switch">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{$opd->is_active == true ? 'checked' : ''}}>
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
    //OPEN PROSES UPDATE
        $('#form_edit').on('submit', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            data = {
                name: $("#name").val(),
                is_active: $('#is_active').is(':checked'),
                _token: '{{ csrf_token() }}'
            }
            var act = "{{ route('opd.update', [':param']) }}";
                            act = act.replace(':param', '{{encrypt($opd->id)}}');
            $.ajax({
                type: "PUT",
                url: act,
                data: data,

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
    //CLOSE PROSES UPDATE
</script>
