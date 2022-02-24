<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('My Files Manager') }}
    </h2>
</x-slot>
@push('scripts')
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
    window.addEventListener('show-form-multiedit', event => {
        $('#form-multiedit').modal('show');
    })
</script>
<script>
    window.addEventListener('hide-form-multiedit', event => {
        $('#form-multiedit').modal('hide');
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
    <x-LoadingState />
    @include('livewire.back.form.formmyfile-modal')
    <x-CardLayout>
        <!-- table menu -->
        <x-TableMenu mdperhal="perhal" :table="$myfile" :checked="$checked" mdsearch="inpsearch">
            <x-slot:dropdownmenu>
                <li><button wire:click="removeselection" class="dropdown-item">Delete</button></li>
                <li><button wire:click="editselection" class="dropdown-item">Edit</button></li>
                <li><button wire:click="zipdownload" class="dropdown-item">Download (.zip)</button></li>
            </x-slot>
            <div class="mb-2 mb-md-0 me-md-2">
                <div class="btn-group w-100">
                    <button wire:click.prevent="add" class="btn btn-primary text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Add">
                        <i class="bi bi-plus-square"></i> <span>File</span>
                    </button>
                </div>  
            </div>
        </x-TableMenu>
        <!-- .table menu -->
        <!-- selection messages -->
        <x-SelMsg :table="$myfile" :selectPage="$selectPage" :selectAll="$selectAll" :checked="$checked" linkDeselect="deselectAll" linkSelect="selectAll"/>
        <!-- .selection messages -->
        <!-- table -->
        <x-TableSlot :table="$myfile"  ncol="9" ncolAdmin="10"  >
            <x-slot:thead>
                <tr>
                    <th class="text-center"><input type="checkbox" wire:model="selectPage"></th>
                    <th>No</th>
                    <th style="cursor:pointer;" wire:click="sortBy('category_name')"><x-SortState colName="category_name"  :sortBy="$sortBy" :sortDir="$sortDirection">Category</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('name')"><x-SortState colName="name"  :sortBy="$sortBy" :sortDir="$sortDirection">File Name</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('user_name')"><x-SortState colName="user_name"  :sortBy="$sortBy" :sortDir="$sortDirection">Owner</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('file_size')"><x-SortState colName="file_size"  :sortBy="$sortBy" :sortDir="$sortDirection">Size</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('updated_at')"><x-SortState colName="updated_at"  :sortBy="$sortBy" :sortDir="$sortDirection">Updated At</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('is_public')"><x-SortState colName="is_public"  :sortBy="$sortBy" :sortDir="$sortDirection">Is Public</x-SortState></th>
                    @hasrole('admin')
                    <th style="cursor:pointer;" wire:click="sortBy('is_pinned')"><x-SortState colName="is_pinned"  :sortBy="$sortBy" :sortDir="$sortDirection">Is Pinned</x-SortState></th>
                    @endhasrole
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
                    <td>@if($row->is_public) Yes @else No @endif</td>
                    @hasrole('admin')
                    <td>@if($row->is_pinned) Yes @else No @endif</td>
                    @endhasrole
                    <td>
                        <button wire:click.prevent="edit({{ $row->id }})" class="btn btn-primary text-light btn-sm me-md-1 mb-2 mb-md-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button wire:click.prevent="removesingle({{$row->id}})" class="btn btn-danger btn-sm text-light me-1 mb-2 mb-md-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="bi bi-trash-fill"></i></button>
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
