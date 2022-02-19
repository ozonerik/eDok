<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('File Management') }}
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
    @include('livewire.back.form.formotherfile-modal')
    <x-CardLayout>
        <!-- table menu -->
        <x-TableMenu mdperhal="perhal" :table="$myfile" :checked="$checked" mdsearch="inpsearch">
            <x-slot:dropdownmenu>
                <li><button wire:click="removeselection" class="dropdown-item">Delete</button></li>
                <li><button wire:click="zipdownload" class="dropdown-item">Download (.zip)</button></li>
            </x-slot>
        </x-TableMenu>
        <!-- .table menu -->
        <!-- selection messages -->
        <x-SelMsg :table="$myfile" :selectPage="$selectPage" :selectAll="$selectAll" :checked="$checked" linkDeselect="deselectAll" linkSelect="selectAll"/>
        <!-- .selection messages -->
        <!-- table -->
        <x-TableSlot :table="$myfile" ncol="8">
            <x-slot:thead>
                <tr>
                    <th class="text-center"><input type="checkbox" wire:model="selectPage"></th>
                    <th>No</th>
                    <th style="cursor:pointer;" wire:click="sortBy('category_name')"><x-SortState colName="category_name"  :sortBy="$sortBy" :sortDir="$sortDirection">Category</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('name')"><x-SortState colName="name"  :sortBy="$sortBy" :sortDir="$sortDirection">File Name</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('user_name')"><x-SortState colName="user_name"  :sortBy="$sortBy" :sortDir="$sortDirection">Owner</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('file_size')"><x-SortState colName="file_size"  :sortBy="$sortBy" :sortDir="$sortDirection">File Size</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('updated_at')"><x-SortState colName="updated_at"  :sortBy="$sortBy" :sortDir="$sortDirection">Updated At</x-SortState></th>
                    <th>Action</th>
                </tr>
            </x-slot>
            <x-slot:tbody>
                @foreach($myfile as $key => $row)
                <tr class="@if($this->is_checked($row->id)) table-primary @endif">
                    <td class="text-center"><input type="checkbox" value="{{ $row->id }}" wire:model="checked"></td>
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
                    <button wire:click.prevent="removesingle({{$row->id}})" class="btn btn-danger btn-sm text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="bi bi-trash-fill"></i></button> 
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
