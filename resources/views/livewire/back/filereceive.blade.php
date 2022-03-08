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
        </x-TableMenu>
        <!-- .table menu -->
        <!-- table -->
        <x-TableSlot :table="$received" ncol="6" ncolAdmin="6">
            <x-slot:thead>
                <tr>
                    <th>No</th>
                    <th >Code</th>
                    <th style="cursor:pointer;" wire:click="sortBy('file_name')"><x-SortState colName="file_name"  :sortBy="$sortBy" :sortDir="$sortDirection">File Name</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('from_name')"><x-SortState colName="from_name"  :sortBy="$sortBy" :sortDir="$sortDirection">From</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('updated_at')"><x-SortState colName="updated_at"  :sortBy="$sortBy" :sortDir="$sortDirection">Received On</x-SortState></th>
                    <th>Action</th>
                </tr>
            </x-slot>
            <x-slot:tbody>
                @foreach($received as $key => $row)
                <tr class="@if($row->is_read) table-secondary @endif">
                    <td>{{ $received->firstItem() + $key}}</td>
                    <td> {!! QrCode::size(60)->generate($row->sendkey); !!}</td>
                    <td>{{ $row->file_name}}</td>
                    <td>{{ $row->from_name }}</td>
                    <td>{{ $row->updated_at }}</td>
                    <td>
                        <button wire:click.prevent="reading({{ $row->id }})" class="btn btn-primary btn-sm text-light me-1 mb-2 mb-md-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Read">Read</button>
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
