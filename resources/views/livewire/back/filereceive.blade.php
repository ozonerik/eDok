<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('Received Files') }}
    </h2>
</x-slot>
@push('scripts')
<script>
    window.addEventListener('show-form-receive', event => {
        $('#form-receive').modal('show');
    })
</script>
<script>
    window.addEventListener('hide-form-receive', event => {
        $('#form-receive').modal('hide');
    })
</script>
@endpush
<div>
    <x-LoadingState />
    @include('livewire.back.form.formreceived-modal')
    <x-CardLayout>
        <!-- table menu -->
        <x-TableMenu mdperhal="perhal" :table="$received" :checked="[]" mdsearch="inpsearch">
            <x-slot:dropdownmenu></x-slot>
            <div class="mb-2 mb-md-0 me-md-2">
                <div class="btn-group w-100">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-funnel"></i> <span class="fw-bold">Filter</span>
                    </button>
                    <ul class="dropdown-menu w-100">
                        <li><button wire:click="is_read('none')" class="dropdown-item">Show All</button></li>    
                        <li><button wire:click="is_read('no')" class="dropdown-item">Show Unread</button></li>
                        <li><button wire:click="is_read('yes')" class="dropdown-item">Show Read</button></li>
                    </ul>
                </div>
            </div>
        </x-TableMenu>
        <!-- .table menu -->
        <!-- table -->
        <x-TableSlot :table="$received" ncol="5" ncolAdmin="5">
            <x-slot:thead>
                <tr>
                    <th>No</th>
                    <th style="cursor:pointer;" wire:click="sortBy('from_name')"><x-SortState colName="from_name"  :sortBy="$sortBy" :sortDir="$sortDirection">From</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('file_name')"><x-SortState colName="file_name"  :sortBy="$sortBy" :sortDir="$sortDirection">File Name</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('created_at')"><x-SortState colName="created_at"  :sortBy="$sortBy" :sortDir="$sortDirection">Received On</x-SortState></th>
                    <th>Action</th>
                </tr>
            </x-slot>
            <x-slot:tbody>
                @foreach($received as $key => $row)
                <tr class="@if($row->is_read) table-secondary @endif">
                    <td>{{ $received->firstItem() + $key}}</td>
                    <td>{{ $row->from_name }}</td>
                    <td>{{ $row->file_name}}</td>
                    <td>{{ $row->created_at }}</td>
                    <td>
                        <button wire:click.prevent="reading({{ $row->id }})" class="btn btn-primary btn-sm text-light me-1 mb-2 mb-md-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Read"><i class="bi bi-search"></i></button>
                    </td>
                </tr>
                @endforeach
            </x-slot>
        </x-TableSlot>
        <!-- .table -->
        <!-- pagination -->
        <x-paginating :table="$received" />
        <!-- .pagination -->
    </x-CardLayout>
</div>
