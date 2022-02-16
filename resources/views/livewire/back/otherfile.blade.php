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
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                    <div class="mx-3 my-3">
                        <div class="row mb-3">
                            <div class="col-12 col-md-2 mb-2 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text">Per Page :</span>
                                    <select wire:model="perhal" class="form-select">
                                    <option value="2" selected>2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 mb-2 mb-md-0 d-flex justify-content-center @if(empty($checked)) d-none @endif ">
                                <div class="btn-group w-100">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="fw-bold">Selection ( {{count($checked)}} )</span>
                                    </button>
                                    <ul class="dropdown-menu w-100">
                                        <li><button wire:click="removeselection" class="dropdown-item">Delete</button></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 @if(empty($checked)) col-md-10 @else col-md-8 @endif d-flex justify-content-end">
                                <input type="text" wire:model.debounce.500ms="inpsearch" class="form-control" placeholder="Search...">
                            </div>
                        </div>
                        @if($selectPage)
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                @if($selectAll)
                                You have selected All <strong>{{$myfile->total()}}</strong> items. <a href="#" wire:click="deselectAll">Deselect All</a>
                                @else
                                You have selected <strong>{{ count($checked) }}</strong> items. Do you want to Select All <strong>{{$myfile->total()}}</strong> items ? <a href="#" wire:click="selectAll">Select All</a>
                                @endif

                            </div>
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table id="mytable" class="table table-borderless table-hover table-rounded">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center"><input type="checkbox" wire:model="selectPage"></th>
                                        <th>No</th>
                                        <th style="cursor:pointer;" wire:click="sortBy('category_name')"><x-SortState colName="category_name"  :sortBy="$sortBy" :sortDir="$sortDirection">Category</x-SortState></th>
                                        <th style="cursor:pointer;" wire:click="sortBy('name')"><x-SortState colName="name"  :sortBy="$sortBy" :sortDir="$sortDirection">File Name</x-SortState></th>
                                        <th style="cursor:pointer;" wire:click="sortBy('user_name')"><x-SortState colName="user_name"  :sortBy="$sortBy" :sortDir="$sortDirection">Owner</x-SortState></th>
                                        <th style="cursor:pointer;" wire:click="sortBy('updated_at')"><x-SortState colName="updated_at"  :sortBy="$sortBy" :sortDir="$sortDirection">Updated At</x-SortState></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myfile as $key => $row)
                                    <tr class="@if($this->is_checked($row->id)) table-primary @endif">
                                        <td class="text-center"><input type="checkbox" value="{{ $row->id }}" wire:model="checked"></td>
                                        <td>{{ $myfile->firstItem() + $key}}</td>
                                        <td>{{ $row->category_name }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->user_name }}</td>
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
                                    @if(count($myfilequery) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center">No Result</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {{ $myfile->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
