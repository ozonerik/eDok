<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('Category Management') }}
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
    @include('livewire.back.form.formothercat-modal')
    <x-CardLayout>
        <!-- table menu -->
        <x-TableMenu mdperhal="perhal" :table="$myfilecat" :checked="$checked" mdsearch="inpsearch">
            <x-slot:dropdownmenu>
                <li><button wire:click="removeselection" class="dropdown-item">Delete</button></li>
                <li><button wire:click="zipdownload" class="dropdown-item">Download (.zip)</button></li>
            </x-slot>
        </x-TableMenu>
        <!-- .table menu -->
        <!-- selection messages -->
        <x-SelMsg :table="$myfilecat" :selectPage="$selectPage" :selectAll="$selectAll" :checked="$checked" linkDeselect="deselectAll" linkSelect="selectAll"/>
        <!-- .selection messages -->
        <!-- table -->
        <x-TableSlot :table="$myfilecat" ncol="8">
            <x-slot:thead>
                <tr>
                    <th class="text-center"><input type="checkbox" wire:model="selectPage"></th>
                    <th>No</th>
                    <th style="cursor:pointer;" wire:click="sortBy('category_name')"><x-SortState colName="category_name"  :sortBy="$sortBy" :sortDir="$sortDirection">Category Name</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('owner')"><x-SortState colName="owner"  :sortBy="$sortBy" :sortDir="$sortDirection">Owner</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('cat_size')"><x-SortState colName="cat_size"  :sortBy="$sortBy" :sortDir="$sortDirection">Size</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('updated_at')"><x-SortState colName="updated_at"  :sortBy="$sortBy" :sortDir="$sortDirection">Updated At</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('is_public')"><x-SortState colName="is_public"  :sortBy="$sortBy" :sortDir="$sortDirection">Is Public</x-SortState></th>
                    <th>Action</th>
                </tr>
            </x-slot>
            <x-slot:tbody>
                @foreach($myfilecat as $key => $row)
                <tr class="@if($this->is_checked($row->id)) table-primary @endif">
                    <td class="text-center"><input type="checkbox" value="{{ $row->id }}" wire:model="checked"></td>
                    <td>{{ $myfilecat->firstItem() + $key}}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->user_name }}</td>
                    <td>{{ convert_bytes($row->file_size_category) }}</td>
                    <td>{{ $row->updated_at }}</td>
                    <td>@if($row->is_public) Yes @else No @endif</td>
                    <td>
                    @if(Storage::disk('public')->exists('myfiles/'.$row->user_id.'/'.$row->filecategory_id.'/'))
                    <button wire:click.prevent="export({{$row->id}})" class="btn btn-success btn-sm text-light me-1 mb-2 mb-md-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Download"><i class="bi bi-cloud-arrow-down-fill"></i></button>
                    @else
                    <button class="btn btn-secondary btn-sm text-light me-1 mb-2 mb-md-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Download" disabled><i class="bi bi-cloud-arrow-down-fill"></i></button>
                    @endif
                    @if(($row->user->roles->pluck('name')->implode(',') != 'admin') or ($auth_id == $row->user_id))
                    <button wire:click.prevent="removesingle({{ $row->id }})" class="btn btn-danger btn-sm text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
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
            </x-slot>
        </x-TableSlot>
        <!-- .table -->
        <!-- pagination -->
        <x-paginating :table="$myfilecat" />
        <!-- .pagination -->
    </x-CardLayout>
</div>
