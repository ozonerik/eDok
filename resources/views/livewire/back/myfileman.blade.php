<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('My Files Manager') }}
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
            { "orderable": false, "targets": [8] },
            { "searchable": false, "targets": [0,8] }
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
<script>
    window.addEventListener('show-form-searchcat', event => {
        $('#form-searchcat').modal('show');
    })
</script>
<script>
    window.addEventListener('hide-form-searchcat', event => {
        $('#form-searchcat').modal('hide');
    })
</script>
@endpush
<div>
    @include('livewire.back.form.formmyfile-modal')
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                    <div class="mx-3 my-3" wire:ignore>
                        @php
                        $no=1;
                        @endphp
                        <button wire:click.prevent="add" class="btn btn-primary btn-sm mb-3 text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Add">
                        <i class="bi bi-plus-square"></i> <span>File</span>
                        </button>
                        <table id="mytable" class="table table-borderless table-hover table-rounded">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
                                    <th>File Name</th>
                                    @hasrole('admin')
                                    <th>Is Pinned</th>
                                    @endhasrole
                                    <th>Is Public</th>
                                    <th>Owner</th>
                                    <th>File Size</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myfile as $row)
                                <tr>
                                    <td>{{ $no++}}</td>
                                    <td>{{ $row->filecategory->name }}</td>
                                    <td>{{ $row->name }}</td>
                                    @hasrole('admin')
                                    <td>@if($row->is_pinned) Yes @else No @endif</td>
                                    @endhasrole
                                    <td>@if($row->is_public) Yes @else No @endif</td>
                                    <td>{{ $row->user->name }}</td>
                                    <td>{{ convert_bytes($row->file_size) }}</td>
                                    <td>{{ $row->updated_at }}</td>
                                    <td>
                                    <button wire:click.prevent="edit({{$row->id}})" class="btn btn-primary text-light btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button wire:click.prevent="remove({{$row->id}})" class="btn btn-danger btn-sm text-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @if(Storage::disk('local')->exists($row->path))
                                    <button wire:click.prevent="export({{$row->id}})" class="btn btn-success btn-sm text-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Download">
                                        <i class="bi bi-cloud-arrow-down"></i> 
                                    </button>
                                    @else
                                    <button class="btn btn-secondary btn-sm text-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Download" disabled>
                                        <i class="bi bi-cloud-arrow-down"></i>
                                    </button>
                                    @endif
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
