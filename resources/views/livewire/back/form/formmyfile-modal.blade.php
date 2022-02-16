<!-- Create / Edit MyFile Modal -->
<div class="modal fade" wire:ignore.self id="form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">@if($modeEdit) Edit File @else Add File @endif</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form autocomplete="off" method="post" enctype="multipart/form-data" wire:submit.prevent="store">
      <div class="modal-body">
        <div class="form-group mb-3">
            <label>File Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror " wire:model.defer="name" placeholder="Enter Name" >
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group mb-3">
            <label>Category</label>
            <div class="input-group">
            <select class="form-select @error('filecategory_id') is-invalid @enderror" wire:model.defer="filecategory_id">
                  <option selected>Select Category</option>    
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
        <div class="form-group mb-3">
            <label>Upload File</label>
            <input id="{{ $upload_id }}" type="file" accept="application/pdf" class="form-control @error('file') is-invalid @enderror " wire:model.defer="file" >
            <span class="text-info"><small>Maximum file size: 10Mb</small></span>
            @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="modal-footer">
        <div class="col" wire:loading>
          Please Wait...
        </div>
        <button type="button" class="btn btn-secondary btn-sm text-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" wire:loading.attr="disabled" wire:loading.class="btn btn-secondary btn-sm text-light" class="btn btn-primary btn-sm text-light">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete MyFile Modal -->
<div class="modal fade" wire:ignore.self id="form-del" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete File Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form autocomplete="off" wire:submit.prevent="delete({{ $myfile_id }})">
      <div class="modal-body">
        <div class="text-center fs-5">Apakah anda yakin ingin menghapus :</div>
        <div class="fw-bold text-center fs-5">{{ $name }}</div>
        <div class="text-danger fs-5 text-center">file {{ $name }} akan terhapus permanen !!</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm text-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger btn-sm text-light">Delete</button>
      </div>
      </form>
    </div>
  </div>
</div>

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