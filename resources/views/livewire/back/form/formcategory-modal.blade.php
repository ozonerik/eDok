<!-- Create / Edit Category Modal -->
<x-ModalForm modalname="form" linksubmit="store" btntype="success" btnlabel="Save">
  <x-slot:modaltitle>
    @if($modeEdit) Edit Category @else Add Category @endif
  </x-slot>
  <x-slot:modalbody>
    <div class="form-group mb-3">
        <label>Category Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror " wire:model.defer="states.name" placeholder="Enter Name" >
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group mb-3">
        <label>Is Public  </label>
        <select class="form-select @error('is_public') is-invalid @enderror" wire:model.defer="states.is_public">
            <option Selected class="text-muted">Please Select</option>    
            <option value='0'>No</option>
            <option value='1'>Yes</option>
        </select>
        @error('is_public')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
  </x-slot>
</x-ModalForm>

<!-- Edit Multi User Modal -->
<x-ModalForm modalname="form-multiedit" linksubmit="storeupdatesel" btntype="primary" btnlabel="Save">
  <x-slot:modaltitle>
    @if($modeEdit) Edit Category Selection @endif
  </x-slot>
  <x-slot:modalbody>
    <div class="form-group mb-3">
        <label>Is Public  </label>
        <select class="form-select @error('is_public') is-invalid @enderror" wire:model.defer="states.is_public">
            <option Selected class="text-muted">Please Select</option>    
            <option value='0'>No</option>
            <option value='1'>Yes</option>
        </select>
        @error('is_public')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="text-center mb-1">Applied for this @if($category_id) {{ count($category_id) }} @endif cetegories below</div>
    <ol class="list-group list-group-numbered mb-3">
      @foreach($delsel as $row)
        <li class="list-group-item list-group-item-action">{{$row->name}}</li>
      @endforeach
    </ol>
  </x-slot>
</x-ModalForm>

<!-- Delete Category Modal -->
<x-ModalForm modalname="form-del" linksubmit="delete" btntype="danger" btnlabel="Delete">
  <x-slot:modaltitle>
    Delete Categories Confirmation
  </x-slot>
  <x-slot:modalbody>
    <div class="text-center mb-1">Do you want delete this @if($category_id) {{ count($category_id) }} @endif categories ?</div>
    <ol class="list-group list-group-numbered">
    @foreach($delsel as $row)
      <li class="list-group-item list-group-item-action">{{$row->name}} by {{$row->user->name}}</li>
    @endforeach
    </ol>
    <div class="text-center mt-1">
      <small class="text-danger">*All files from the selected categories will be permanently deleted</small>
    </div>
  </x-slot>
</x-ModalForm>