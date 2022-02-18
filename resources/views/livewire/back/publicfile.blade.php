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
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                    <div class="mx-3 my-3">
                        <!-- table menu -->
                        <div class="d-flex flex-column flex-md-row mb-3">
                            <div class="mb-2 mb-md-0 me-md-2">
                                <div class="input-group">
                                    <span class="input-group-text">Per Page :</span>
                                    <select wire:model="perhal" class="form-select">
                                    <option value="2" selected>2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="{{$myfile->total()}}">All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex-fill">
                                <input type="text" wire:model.debounce.500ms="inpsearch" class="form-control" placeholder="Search...">
                            </div>
                        </div>
                        <!-- .table menu -->
                        <!-- table -->
                        <div class="table-responsive">
                            <table id="mytable" class="table table-borderless table-hover table-rounded">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th style="cursor:pointer;" wire:click="sortBy('category_name')"><x-SortState colName="category_name"  :sortBy="$sortBy" :sortDir="$sortDirection">Category</x-SortState></th>
                                        <th style="cursor:pointer;" wire:click="sortBy('name')"><x-SortState colName="name"  :sortBy="$sortBy" :sortDir="$sortDirection">File Name</x-SortState></th>
                                        <th style="cursor:pointer;" wire:click="sortBy('user_name')"><x-SortState colName="user_name"  :sortBy="$sortBy" :sortDir="$sortDirection">Owner</x-SortState></th>
                                        <th style="cursor:pointer;" wire:click="sortBy('file_size')"><x-SortState colName="file_size"  :sortBy="$sortBy" :sortDir="$sortDirection">File Size</x-SortState></th>
                                        <th style="cursor:pointer;" wire:click="sortBy('updated_at')"><x-SortState colName="updated_at"  :sortBy="$sortBy" :sortDir="$sortDirection">Updated At</x-SortState></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                    @if(count($myfilequery) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center">No Result</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- .table -->
                        <!-- pagination -->
                        <div class="d-flex flex-column flex-md-row mt-3 mt-md-0 ">
                            <div class="me-md-auto text-muted d-flex justify-content-center">
                                <div>
                                    Showing {{$myfile->firstItem()}} to {{$myfile->lastItem()}} of {{$myfile->total()}} entries
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-md-0 mt-2">
                                <div>
                                    {{$myfile->links()}}
                                </div>
                            </div>
                        </div>
                        <!-- .pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
