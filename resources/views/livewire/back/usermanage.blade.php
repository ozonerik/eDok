<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('User Management') }}
    </h2>
</x-slot>
@push('css')
<link type="text/css" href="//cdn.datatables.net/select/1.3.4/css/select.dataTables.min.css" rel="stylesheet" />
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
@endpush
@push('scripts')
<script type="text/javascript" src="//cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
<script>
document.addEventListener('livewire:load', function () {
    var events = $('#events');
    var table = $('#mytable').DataTable({
        "paging": true,
        "pageLength": 3,
        "lengthChange": true,
        "lengthMenu": [ [3, 10, 50, 100, -1], [3, 10, 50, 100, "All"] ],
        "searching": true,
        "ordering": true,
        "autoWidth": false,
        "responsive": true,
        "bInfo" : false,
        "order": [[ 1, "asc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [0,2,7] },
            { "searchable": false, "targets": [0,2,7] },
            { "visible": false, "targets": [2] },
            { 'checkboxes': {
                'selectRow': true,
                'selectAllPages':false,
                'selectAllRender':'<input type="checkbox" class="form-check-input">'
            }, 'targets': 0}
        ],
        "select": {
            "style": "multi"
        },
    });
    
    table
        .on( 'select', function ( e, dt, type, indexes ) {
            var ids = $.map(table.rows('.selected').data(), function (item) {
            return item[2]
            });
            @this.checked=ids;
        })
        .on( 'deselect', function ( e, dt, type, indexes ) {
            var ids = $.map(table.rows('.selected').data(), function (item) {
            return item[2]
            });
            @this.checked=ids;
        });
} );
</script>
<script>
    window.addEventListener('show-form', event => {
        $('#form').modal('show');
    })
</script>
<script>
    window.addEventListener('hide-form', event => {
        $('#form').modal('hide');
    })
</script>
<script>
    window.addEventListener('show-form-del', event => {
        $('#form-del').modal('show');
    })
</script>
<script>
    window.addEventListener('hide-form-del', event => {
        $('#form-del').modal('hide');
    })
</script>
<script>
    window.addEventListener('show-form-delsel', event => {
        $('#form-delsel').modal('show');
    })
</script>
<script>
    window.addEventListener('hide-form-delsel', event => {
        $('#form-delsel').modal('hide');
    })
</script>
@endpush
<div> 
@include('livewire.back.form.formuser-modal')
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">  
                    <div class="mx-3 my-3">
                        @php
                        $no=1;
                        @endphp
                        <div class="row text-center text-md-start ">
                            <div class="col-12 col-md-2">
                                <button wire:click.prevent="add" class="btn btn-primary btn-sm mb-3 text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Add">
                                    <i class="bi bi-plus-square"></i> <span>User</span>
                                </button>
                            </div>
                            <div class="col-12 col-md-10">
                                <button wire:click.prevent="removesel" class="btn btn-danger btn-sm mb-3 text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Add">
                                    Delete {{ count($checked) }} selected items
                                </button>
                            </div>
                        </div>
                        <div wire:ignore>
                            <table id="mytable" class="table table-borderless table-hover table-rounded">
                                <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th class="d-none">id</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $row)
                                    <tr>
                                        <td></td>
                                        <td>{{ $no++}}</td>
                                        <td class="d-none">{{ $row->id }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>{{ $row->roles->pluck('name')->implode(', ') }}</td>
                                        <td>{{ $row->updated_at }}</td>
                                        <td>
                                        <button wire:click.prevent="edit({{ $row->id }})" class="btn btn-primary text-light btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button wire:click.prevent="remove({{ $row->id }})" class="btn btn-danger btn-sm text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
