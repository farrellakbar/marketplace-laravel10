<div class="modal-body" >

    <div class="table-responsive">
        <table id="rellarphp2-datatable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td>Role</td>
                    <td>Valid From</td>
                    <td>Valid To</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>

                @foreach ($jobHistorys as $job)
                    <tr>
                        <td>
                            {{ $job->role_name}}
                        </td>
                        <td>
                            {{ Carbon\Carbon::parse($job->valid_from)->format('d-m-Y') ?? '-'}}
                        </td>
                        <td>
                            {{$job->valid_to ? Carbon\Carbon::parse($job->valid_to)->format('d-m-Y') : '-'}}
                        </td>
                        <td class="text-nowrap">
                            {!! $job->is_active ? "<i class='fa fa-circle text-success'></i> Active" : "<i class='fa fa-circle text-danger'></i> Not Active"!!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-secondary waves-effect text-left" data-bs-dismiss="modal"
        aria-label="Close">
        <i class="fa fa-times"></i> &nbsp; Close
    </button>
</div>
<script>
    $(document).ready(function() {
        $("#rellarphp2-datatable").DataTable({
                paging: false,
                searching: false,
                ordering: false,
                info: false
        });
    });
</script>
