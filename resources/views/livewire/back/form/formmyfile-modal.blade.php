<!-- Create / Edit Category Modal -->
<x-ModalForm modalname="form" linksubmit="store" btntype="success" btnlabel="Save">
  <x-slot:modaltitle>
    @if($modeEdit) Edit File @else Add File @endif
  </x-slot>
  <x-slot:modalbody>
    <div class="form-group mb-3">
        <label>File Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror " wire:model.defer="name" placeholder="Enter Name" >
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group mb-3">
        <label>Category</label>
        <div class="input-group">
        <select class="form-select @error('filecategory_id') is-invalid @enderror" wire:model.defer="filecategory_id">
              <option selected class="text-muted">Select Category</option>    
            @foreach($cat as $row)
              <option value='{{$row->id}}'>{{$row->name}}</option>
            @endforeach
        </select>
        <button wire:click.prevent="searchcat" class="btn btn-secondary rounded-end" type="button">Cari</button>
        @error('filecategory_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="form-group mb-3">
        <label>Is Public  </label>
        <select class="form-select @error('is_public') is-invalid @enderror" wire:model.defer="is_public">
            <option selected>Please Select</option>  
            <option value='0'>No</option>
            <option value='1'>Yes</option>
        </select>
        @error('is_public')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    @hasanyrole('admin|manager')
    <div class="form-group mb-3">
        <label>Is Pinned</label>
        <select class="form-select @error('is_pinned') is-invalid @enderror" wire:model.defer="is_pinned">
            <option selected>Please Select</option>     
            <option value='0'>No</option>
            <option value='1'>Yes</option>
        </select>
        @error('is_pinned')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    @endhasanyrole
    <div class="form-group mb-3">
        <label>Upload File</label>
        <input id="{{ $upload_id }}" type="file" accept="application/pdf" class="form-control @error('file') is-invalid @enderror " wire:model.defer="file" >
        <span class="text-info"><small>Maximum file size: 10Mb</small></span>
        @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
  </x-slot>
</x-ModalForm>

<!-- Edit Multi User Modal -->
<x-ModalForm modalname="form-multiedit" linksubmit="storeupdatesel" btntype="primary" btnlabel="Save">
  <x-slot:modaltitle>
    @if($modeEdit) Edit Files Selection @endif
  </x-slot>
  <x-slot:modalbody>
    <div class="form-group mb-3">
        <label>Category</label>
        <div class="input-group">
        <select class="form-select @error('filecategory_id') is-invalid @enderror" wire:model.defer="filecategory_id">
              <option selected class="text-muted">Select Category</option>    
            @foreach($cat as $row)
              <option value='{{$row->id}}'>{{$row->name}}</option>
            @endforeach
        </select>
        <button wire:click.prevent="searchcat" class="btn btn-secondary rounded-end" type="button">Cari</button>
        @error('filecategory_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="form-group mb-3">
        <label>Is Public  </label>
        <select class="form-select @error('is_public') is-invalid @enderror" wire:model.defer="is_public">
            <option selected>Please Select</option>  
            <option value='0'>No</option>
            <option value='1'>Yes</option>
        </select>
        @error('is_public')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    @hasrole('admin')
    <div class="form-group mb-3">
        <label>Is Pinned</label>
        <select class="form-select @error('is_pinned') is-invalid @enderror" wire:model.defer="is_pinned">
            <option selected>Please Select</option>     
            <option value='0'>No</option>
            <option value='1'>Yes</option>
        </select>
        @error('is_pinned')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    @endhasrole
    <div class="text-center mb-1">Applied for this @if($myfile_id) {{ count($myfile_id) }} @endif files below</div>
    <ol class="list-group list-group-numbered mb-3">
      @foreach($delsel as $row)
        <li class="list-group-item list-group-item-action">{{$row->name}}</li>
      @endforeach
    </ol>
  </x-slot>
</x-ModalForm>

<!-- Delete Other file Modal -->
<x-ModalForm modalname="form-del" linksubmit="delete" btntype="danger" btnlabel="Delete">
  <x-slot:modaltitle>
    Delete File Confirmation
  </x-slot>
  <x-slot:modalbody>
    <div class="text-center mb-1">Do you want delete this @if($myfile_id) {{ count($myfile_id) }} @endif items ?</div>
    <ol class="list-group list-group-numbered">
    @foreach($delsel as $row)
      <li class="list-group-item list-group-item-action">{{$row->name}} by {{$row->user->name}}</li>
    @endforeach
    </ol>
    <div class="text-center mt-1">
      <small class="text-danger">*All selected files will be permanently deleted</small>
    </div>
  </x-slot>
</x-ModalForm>

<!-- Search Category Modal -->
<div class="modal fade" wire:ignore.self id="form-searchcat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Search Category</h5>
        <button wire:click.prevent="close_formsearchcat" class="btn-close"></button>
      </div>
      <div class="modal-body">
        <input class="form-control mb-2" type="text" wire:model="category" placeholder="Search Category...">
       @foreach($resultcat as $row)
        <button wire:click.prevent="selectcat({{$row->id}})" class="btn w-100 mb-1 btn-outline-secondary btn-sm text-start">{{$row->name}}</button>
       @endforeach
      </div>
    </div>
  </div>
</div>