<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('Public Files') }}
    </h2>
</x-slot>
@push('scripts')
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
    <x-LoadingState />
    <x-CardLayout>
        <!-- table menu -->
        <x-TableMenu mdperhal="perhal" :table="$myfile" :checked="[]" mdsearch="inpsearch">
            <x-slot:dropdownmenu></x-slot>
        </x-TableMenu>
        <!-- .table menu -->
        <!-- table -->
        <x-TableSlot :table="$myfile" ncol="7" ncolAdmin="7">
            <x-slot:thead>
                <tr>
                    <th>No</th>
                    <th style="cursor:pointer;" wire:click="sortBy('category_name')"><x-SortState colName="category_name"  :sortBy="$sortBy" :sortDir="$sortDirection">Category</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('name')"><x-SortState colName="name"  :sortBy="$sortBy" :sortDir="$sortDirection">File Name</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('user_name')"><x-SortState colName="user_name"  :sortBy="$sortBy" :sortDir="$sortDirection">Owner</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('file_size')"><x-SortState colName="file_size"  :sortBy="$sortBy" :sortDir="$sortDirection">Size</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('updated_at')"><x-SortState colName="updated_at"  :sortBy="$sortBy" :sortDir="$sortDirection">Updated At</x-SortState></th>
                    <th>Action</th>
                </tr>
            </x-slot>
            <x-slot:tbody>
                @foreach($myfile as $key => $row)
                <tr>
                    <td>{{ $myfile->firstItem() + $key}}</td>
                    <td>{{ $row->category_name }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->user_name }}</td>
                    <td>{{ convert_bytes($row->file_size) }}</td>
                    <td>{{ $row->updated_at }}</td>
                    <td>
                        @if(Storage::disk('public')->exists($row->path))
                        <button wire:click.prevent="export({{$row->id}})" class="btn btn-success btn-sm text-light me-1 mb-2 mb-md-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Download"><i class="bi bi-cloud-arrow-down-fill"></i></button>
                        @else
                        <button class="btn btn-secondary btn-sm text-light me-1 mb-2 mb-md-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Download" disabled><i class="bi bi-cloud-arrow-down-fill"></i></button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </x-slot>
        </x-TableSlot>
        <!-- .table -->
        <!-- pagination -->
        <x-paginating :table="$myfile" />
        <!-- .pagination -->
    </x-CardLayout>
</div>
