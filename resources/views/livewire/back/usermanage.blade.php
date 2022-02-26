<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('User Management') }}
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
    window.addEventListener('show-form-delsel', event => {
        $('#form-delsel').modal('show');
    })
</script>
<script>
    window.addEventListener('hide-form-delsel', event => {
        $('#form-delsel').modal('hide');
    })
</script>
<script>
    window.addEventListener('show-form-multiedit', event => {
        $('#form-multiedit').modal('show');
    })
</script>
<script>
    window.addEventListener('hide-form-delsel', event => {
        $('#form-delsel').modal('hide');
    })
</script>
<script>
    window.addEventListener('show-import', event => {
        $('#form-import').modal('show');
    })
</script>
<script>
    window.addEventListener('hide-import', event => {
        $('#form-import').modal('hide');
    })
</script>
@endpush
<div>
    <x-LoadingState /> 
    @include('livewire.back.form.formuser-modal')
    <x-CardLayout>
        <!-- table menu -->
        <x-TableMenu mdperhal="perhal" :table="$users" :checked="$checked" mdsearch="inpsearch">
            <x-slot:dropdownmenu>
                <li><button wire:click="removeselection" class="dropdown-item">Delete</button></li>
                <li><button wire:click="editselection" class="dropdown-item">Edit</button></li>
                <li><button wire:click="zipdownload" class="dropdown-item">Download (.zip)</button></li>
            </x-slot>
            <div class="mb-2 mb-md-0 me-md-2">
                <div class="btn-group w-100">
                    <button wire:click.prevent="add" class="btn btn-primary text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Add">
                        <i class="bi bi-plus-square"></i> <span>User</span>
                    </button>
                </div>  
            </div>
            <div class="mb-2 mb-md-0 me-md-2">
                <div class="btn-group w-100">
                    <button wire:click.prevent="addimport" class="btn btn-success text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Import">
                        <i class="bi bi-arrow-bar-up"></i> <span>Import Users</span>
                    </button>
                </div>  
            </div>
        </x-TableMenu>
        <!-- .table menu -->
        <!-- selection messages -->
        <x-SelMsg :table="$users" :selectPage="$selectPage" :selectAll="$selectAll" :checked="$checked" linkDeselect="deselectAll" linkSelect="selectAll"/>
        <!-- .selection messages -->
        <!-- table -->
        <x-TableSlot :table="$users" ncol="8" ncolAdmin="8">
            <x-slot:thead>
                <tr>
                    <th class="text-center"><input type="checkbox" wire:model="selectPage"></th>
                    <th>No</th>
                    <th style="cursor:pointer;" wire:click="sortBy('name')"><x-SortState colName="name"  :sortBy="$sortBy" :sortDir="$sortDirection">User Name</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('email')"><x-SortState colName="email"  :sortBy="$sortBy" :sortDir="$sortDirection">Email</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('roles')"><x-SortState colName="roles"  :sortBy="$sortBy" :sortDir="$sortDirection">Roles</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('user_size')"><x-SortState colName="user_size"  :sortBy="$sortBy" :sortDir="$sortDirection">Size</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('updated_at')"><x-SortState colName="updated_at"  :sortBy="$sortBy" :sortDir="$sortDirection">Updated</x-SortState></th>
                    <th>Action</th>
                </tr>
            </x-slot>
            <x-slot:tbody>
                @foreach($users as $key => $row)
                <tr class="@if($this->is_checked($row->id)) table-primary @endif">
                    <td class="text-center"><input type="checkbox" value="{{ $row->id }}" wire:model="checked"></td>
                    <td>{{ $users->firstItem() + $key}}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->roles_name }}</td>
                    <td>{{ convert_bytes($row->user_size) }}</td>
                    <td>{{ $row->updated_at }}</td>
                    <td>
                        <button wire:click.prevent="edit({{ $row->id }})" class="btn btn-primary text-light btn-sm me-md-1 mb-2 mb-md-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button wire:click.prevent="removesingle({{ $row->id }})" class="btn btn-danger btn-sm text-light me-md-1 mb-2 mb-md-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                        @if(!empty(getfilesuser($row->id)))
                        <button wire:click.prevent="export({{$row->id}})" class="btn btn-success btn-sm text-light me-md-1 mb-2 mb-md-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Download"><i class="bi bi-cloud-arrow-down-fill"></i></button>
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
        <x-paginating :table="$users" />
        <!-- .pagination -->
    </x-CardLayout>
</div>
