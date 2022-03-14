<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('Sending Files') }}
    </h2>
</x-slot>
@push('scripts')
<script>
    window.addEventListener('show-form-sending', event => {
        $('#form-sending').modal('show');
    })
</script>
<script>
    window.addEventListener('hide-form-sending', event => {
        $('#form-sending').modal('hide');
    })
</script>
@endpush
<div>
    <x-LoadingState />
    @include('livewire.back.form.formsend-modal')
    <x-CardLayout>
        <!-- table menu -->
        <x-TableMenu mdperhal="perhal" :table="$sending" :checked="[]" mdsearch="inpsearch">
            <x-slot:dropdownmenu></x-slot>
        </x-TableMenu>
        <!-- .table menu -->
        <!-- table -->
        <x-TableSlot :table="$sending" ncol="5" ncolAdmin="5">
            <x-slot:thead>
                <tr>
                    <th>No</th>
                    <th style="cursor:pointer;" wire:click="sortBy('recipient_name')"><x-SortState colName="recipient_name"  :sortBy="$sortBy" :sortDir="$sortDirection">Recipient</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('file_name')"><x-SortState colName="file_name"  :sortBy="$sortBy" :sortDir="$sortDirection">File Name</x-SortState></th>
                    <th style="cursor:pointer;" wire:click="sortBy('updated_at')"><x-SortState colName="created_at"  :sortBy="$sortBy" :sortDir="$sortDirection">Sent On</x-SortState></th>
                    <th>Action</th>
                </tr>
            </x-slot>
            <x-slot:tbody>
                @foreach($sending as $key => $row)
                <tr>
                    <td>{{ $sending->firstItem() + $key}}</td>
                    <td>{{ $row->receiveuser->name }}</td>
                    <td>{{ $row->myfile->name}}</td>
                    <td>{{ $row->updated_at }}</td>
                    <td>
                    <button wire:click.prevent="reading({{ $row->id }})" class="btn btn-primary btn-sm text-light me-1 mb-2 mb-md-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Read"><i class="bi bi-search"></i></button>
                    <a href="https://wa.me/?text={{url('download?c='.$row->sendkey)}}" target="_blank" class="btn btn-success btn-sm text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Share" ><i class="fa-brands fa-whatsapp"></i></a>
                    </td>
                </tr>
                @endforeach
            </x-slot>
        </x-TableSlot>
        <!-- .table -->
        <!-- pagination -->
        <x-paginating :table="$sending" />
        <!-- .pagination -->
    </x-CardLayout>
</div>
