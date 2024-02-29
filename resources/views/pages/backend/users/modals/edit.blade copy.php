
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
                <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}"
                    placeholder="Input Name" required>
                <div class="validation-name text-danger"  style="font-size: 10px;"></div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <input type="email" class="form-control" name="email" id="email" value="{{$user->email}}"
                    placeholder="Input Email" required>
                <div class="validation-email text-danger" style="font-size: 10px;"></div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="password" class="form-label">Password</label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <div class="input-group">
                    <input class="form-control" name="password" type="password" value="" placeholder="Input Password" id="password">
                    <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="validation-password text-danger" style="font-size: 10px;">
                    <p class="text-muted">
                        Minimum 8 characters combination of uppercase letters, lowercase letters, numbers and symbols(@$!#%*?&)
                        <br><b>If the password is not changed, there is no need to enter it</b>
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label class="form-label">Re-Type Password</label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <div class="input-group">
                    <input class="form-control" type="password" value="" placeholder="Input Re-Type Password" id="confirmPassword">
                    <button type="button" id="toggleConfirmPassword" class="btn btn-outline-secondary">
                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                    </button>
                </div>
                <div id="msg" style="font-size: 10px;"></div>
                <div class="invalid-feedback" style="font-size: 10px;">
                    Passwords Must Match!
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label for="isActive" class="form-label">Status <span class="text-danger">*</span></label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <div class="form-check form-switch form-switch">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{$user->is_active ? 'checked' : ''}}>
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
        //OPEN SEE PASSWROD
            var passwordInput = $('#password');
            var togglePasswordButton = $('#togglePassword');

            togglePasswordButton.click(function () {
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    togglePasswordButton.html('<i class="fa fa-eye" aria-hidden="true"></i>');
                } else {
                    passwordInput.attr('type', 'password');
                    togglePasswordButton.html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
                }
            });
        //CLOSE SEE PASSWROD
        //OPEN SEE PASSWORD CONFIRM
            var confirmPasswordInput = $('#confirmPassword');
            var toggleConfirmPasswordButton = $('#toggleConfirmPassword');

            toggleConfirmPasswordButton.click(function () {
                if (confirmPasswordInput.attr('type') === 'password') {
                    confirmPasswordInput.attr('type', 'text');
                    toggleConfirmPasswordButton.html('<i class="fa fa-eye" aria-hidden="true"></i>');
                } else {
                    confirmPasswordInput.attr('type', 'password');
                    toggleConfirmPasswordButton.html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
                }
            });
        //CLOSE SEE PASSWORD CONFIRM
        // OPEN VALIDATION CONFIRM PASSWORD (MATCH OR NOT)
            $("#confirmPassword").keyup(function() {
                if ($("#password").val() != $("#confirmPassword").val()) {
                    $("#msg").html("Password Don't Match").css("color", "red");
                    $("#btn_s").prop('disabled', true);
                } else {
                    $("#msg").html("Password Match").css("color", "green");
                    $("#btn_s").prop('disabled', false);
                }
            });
        // CLOSE VALIDATION CONFIRM PASSWORD  (MATCH OR NOT)
    });
    //OPEN PROSES STORE
        $('#form_edit').on('submit', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            // Check password
            if ($("#password").val() != $("#confirmPassword").val()) {
                $("#msg").html("Password Don't Match").css("color", "red");
                return;
            }
            var data = new FormData($('#form_edit')[0]);
                data.append('_token', '{{ csrf_token() }}');
            var act = "{{ route('user.update', [':param']) }}".replace(':param', '{{ encrypt($user->id) }}');

            $.ajax({
                type: "PUT",
                url: act,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
                    if (response.messageValidate['name']) {
                        $('.validation-name').text(response.messageValidate['name'][0]);
                    } else {
                        $('.validation-name').text('');
                    }
                    if (response.messageValidate['email']) {
                        $('.validation-email').text(response.messageValidate['email'][0]);
                    } else {
                        $('.validation-email').text('');
                    }
                    if (response.messageValidate['password']) {
                        $('.validation-password').text(response.messageValidate['password'][0]);
                    } else {
                        $('.validation-password').text('');
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
