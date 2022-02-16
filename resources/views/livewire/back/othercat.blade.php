<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('Category Management') }}
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
    @include('livewire.back.form.formothercat-modal')
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                    <div class="mx-3 my-3" wire:ignore>
                        @php
                        $no=1;
                        @endphp
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
                                    @if(($row->user->roles->pluck('name')->implode(',')!=='admin') or ($auth_id == $row->user_id))
                                    <button wire:click.prevent="remove({{$row->id}})" class="btn btn-danger btn-sm text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-secondary btn-sm text-light" disabled>
                                        <i class="bi bi-trash"></i>
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
