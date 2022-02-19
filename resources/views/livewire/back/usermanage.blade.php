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
    window.addEventListener('hide-form-multiedit', event => {
        $('#form-multiedit').modal('hide');
    })
</script>
@endpush
<div>
<x-LoadingState /> 
@include('livewire.back.form.formuser-modal')
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">  
                    <div class="mx-3 my-3">
                        <!-- table menu -->
                        <div class="d-flex flex-column flex-md-row mb-3">
                            <div class="mb-2 mb-md-0 me-md-2">
                                <div class="btn-group w-100">
                                    <button wire:click.prevent="add" class="btn btn-primary text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Add">
                                        <i class="bi bi-plus-square"></i> <span>User</span>
                                    </button>
                                </div>  
                            </div>
                            <div class="mb-2 mb-md-0 me-md-2">
                                <div class="input-group">
                                    <span class="input-group-text">Per Page :</span>
                                    <select wire:model="perhal" class="form-select">
                                    <option value="2" selected>2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="{{$users->total()}}">All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="@if(empty($checked)) d-none @endif mb-2 mb-md-0 me-md-2 ">
                                <div class="btn-group w-100">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="fw-bold">Selection ( {{count($checked)}} )</span>
                                    </button>
                                    <ul class="dropdown-menu w-100">
                                        <li><button wire:click="removeselection" class="dropdown-item">Delete</button></li>
                                        <li><button wire:click="editselection" class="dropdown-item">Edit</button></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex-fill">
                                <input type="text" wire:model.debounce.500ms="inpsearch" class="form-control" placeholder="Search...">
                            </div>
                        </div>
                        <!-- .table menu -->
                        <!-- selection messages -->
                        @if($selectPage)
                        <div class="d-flex flex-column flex-md-row justify-content-center mb-3">
                                @if($selectAll)
                                <div class="text-center">
                                You have selected All <strong>{{$users->total()}}</strong> items. <a href="#" wire:click="deselectAll">Deselect All</a>
                                </div>
                                @else
                                <div class="me-md-2 text-center">
                                You have selected <strong>{{ count($checked) }}</strong> items. 
                                </div>
                                <div class="text-center">
                                Do you want to Select All <strong>{{$users->total()}}</strong> items ? <a href="#" wire:click="selectAll">Select All</a>
                                </div>
                                @endif
                        </div>
                        @endif
                        <!-- .selection messages -->
                        <!-- table -->
                        <x-TableSlot :table="$users" ncol="7">
                            <x-slot:thead>
                                <tr>
                                    <th class="text-center"><input type="checkbox" wire:model="selectPage"></th>
                                    <th>No</th>
                                    <th style="cursor:pointer;" wire:click="sortBy('name')"><x-SortState colName="name"  :sortBy="$sortBy" :sortDir="$sortDirection">User Name</x-SortState></th>
                                    <th style="cursor:pointer;" wire:click="sortBy('email')"><x-SortState colName="email"  :sortBy="$sortBy" :sortDir="$sortDirection">Email</x-SortState></th>
                                    <th style="cursor:pointer;" wire:click="sortBy('roles')"><x-SortState colName="roles"  :sortBy="$sortBy" :sortDir="$sortDirection">Roles</x-SortState></th>
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
                                    <td>{{ $row->updated_at }}</td>
                                    <td>
                                        <button wire:click.prevent="edit({{ $row->id }})" class="btn btn-primary text-light btn-sm me-md-1 mb-2 mb-md-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button wire:click.prevent="removesingle({{ $row->id }})" class="btn btn-danger btn-sm text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </x-slot>
                        </x-TableSlot>
                        <!-- .table -->
                        <!-- pagination -->
                        <x-paginating :table="$users" />
                        <!-- .pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
