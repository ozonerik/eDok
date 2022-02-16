<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('My Files Categories') }}
    </h2>
</x-slot>
@push('scripts')
<script>
document.addEventListener('livewire:load', function () {
    $('#mytable').DataTable({
        "paging": true,
        "pageLength": 5,
        "lengthChange": true,
        "lengthMenu": [ [5, 10, 50, 100, -1], [5, 10, 50, 100, "All"] ],
        "searching": true,
        "ordering": true,
        "autoWidth": false,
        "responsive": true,
        "columnDefs": [
            { "orderable": false, "targets": [5] },
            { "searchable": false, "targets": [0,5] }
        ]
    });
});
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
@endpush
<div>
    @include('livewire.back.form.formcategory-modal')
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                    <div class="mx-3 my-3" wire:ignore>
                        @php
                        $no=1;
                        @endphp
                        <button wire:click.prevent="add" class="btn btn-primary btn-sm mb-3 text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Add">
                            <i class="bi bi-plus-square"></i> <span>Category</span>
                        </button>
                        <table id="mytable" class="table table-borderless table-hover table-rounded">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Category Name</th>
                                    <th>Is Public</th>
                                    <th>Owner</th>
                                    <th>Size</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myfilecat as $row)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>@if($row->is_public) Yes @else No @endif</td>
                                    <td>{{ $row->user->name }}</td>
                                    <td>{{ get_categories_size($row->id,$row->user->id) }}</td>
                                    <td>{{ $row->updated_at }}</td>
                                    <td>
                                    <button wire:click.prevent="edit({{$row->id}})" class="btn btn-primary text-light btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" >
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button wire:click.prevent="remove({{$row->id}})" class="btn btn-danger btn-sm text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
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
