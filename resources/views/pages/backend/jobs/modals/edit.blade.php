
<!-- Sweet Alert css -->
<link href="{{ asset('/') }}assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
<style>
    .select2-container--open {
        z-index: 1200;
    }
</style>
<form class="form" id="form_edit">
    @csrf
    <div class="modal-body" id="modalCenterContent">
        <div class="row g-3">
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}"
                    placeholder="Input Name" readonly>
                <div class="validation-name text-danger"></div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="name" class="form-label">Role <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <select class="form-control" name="role_id" id="role_id" required>
                    <option value="" selected>--Enter Role--</option>
                    @foreach ($roles as $role)
                        <option value="{{$role->id}}" {{$user->roles(['job_historys.is_active' => true])->first() ? ($user->roles(['job_historys.is_active' => true])->first()->id == $role->id ? 'selected' : '') : ''}}>{{$role->name}}</option>
                    @endforeach
                </select>
                <div class="validation-role_id text-danger"></div>
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

        $('#role_id').select2({
            placeholder: '-- Choose Role --',
            dropdownParent: $('#modalCenter > .modal-dialog > .modal-content'),
        });
        $('#opd_id').select2({
            placeholder: '-- Choose OPD --',
            dropdownParent: $('#modalCenter > .modal-dialog > .modal-content'),
        });
    });
    //OPEN PROSES UPDATE
        $('#form_edit').on('submit', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            data = new FormData($('#form_edit')[0]);
                data.append('_method','PUT');

            var act = "{{ route('jobuser.update', [':param']) }}";
                            act = act.replace(':param', '{{encrypt($user->id)}}');
            $.ajax({
                type: "POST",
                url: act,
                data: data,
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
                    })
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;
                    if(response.messageValidate){
                        if (response.messageValidate['role_id']) {
                            $('.validation-role_id').text(response.messageValidate['role_id'][0]);
                        } else {
                            $('.validation-role_id').text('');
                        }
                        if (response.messageValidate['opd_id']) {
                            $('.validation-opd_id').text(response.messageValidate['opd_id'][0]);
                        } else {
                            $('.validation-opd_id').text('');
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
