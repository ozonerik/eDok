@props([
    'dropdownmenu',
    'menu',
])
<div class="d-flex flex-column flex-md-row mb-3">
    {{ $slot }}
    <div class="mb-2 mb-md-0 me-md-2">
        <div class="input-group">
            <span class="input-group-text">Per Page :</span>
            <select wire:model="{{ $mdperhal }}" class="form-select">
            <option value="2" selected>2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="{{$table->total()}}">All</option>
            </select>
        </div>
    </div>
    <div class="@if(empty($checked)) d-none @endif mb-2 mb-md-0 me-md-2 ">
        <div class="btn-group w-100">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="fw-bold">Selection ( {{count($checked)}} )</span>
            </button>
            <ul class="dropdown-menu w-100">
                {{ $dropdownmenu }}
            </ul>
        </div>
    </div>
    <div class="flex-fill">
        <input type="text" wire:model.debounce.500ms="{{ $mdsearch }}" class="form-control" placeholder="Search...">
    </div>
</div>