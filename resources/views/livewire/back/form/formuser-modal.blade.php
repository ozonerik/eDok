<!-- Create / Edit User Modal -->
<x-ModalForm modalname="form" linksubmit="store" btntype="primary" btnlabel="Save">
  <x-slot:modaltitle>
    @if($modeEdit) Edit User @else Add User @endif
  </x-slot>
  <x-slot:modalbody>
    <div class="form-group mb-3">
        <label>User Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror " wire:model.defer="states.name" placeholder="Enter Name" >
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group mb-3">
        <label>Email address</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model.defer="states.email" placeholder="Enter Email">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group mb-3">
        <label>Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model.defer="states.password" placeholder="Enter Password">
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group mb-3">
        <label>Confirm Password</label>
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" wire:model.defer="states.password_confirmation" placeholder="Confirm Password">
        @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group mb-3">
        <label>Role</label>
        <select class="form-select @error('role') is-invalid @enderror" wire:model.defer="states.role">
            <option selected class="text-muted">Select Roles</option>
            @foreach($roles as $row)
            <option value='{{$row->name}}'>{{$row->name}}</option>
            @endforeach
        </select>
        @error('roles')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
  </x-slot>
</x-ModalForm>

<!-- Edit Multi User Modal -->
<x-ModalForm modalname="form-multiedit" linksubmit="storeupdatesel" btntype="primary" btnlabel="Save">
  <x-slot:modaltitle>
    @if($modeEdit) Edit User Selection @endif
  </x-slot>
  <x-slot:modalbody>
  <div class="form-group mb-3">
        <label>Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model.defer="states.password" placeholder="Enter Password">
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group mb-3">
        <label>Confirm Password</label>
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" wire:model.defer="states.password_confirmation" placeholder="Confirm Password">
        @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group mb-3">
        <label>Role</label>
        <select class="form-select @error('role') is-invalid @enderror" wire:model.defer="states.role">
            <option selected class="text-muted">Select Roles</option>
            @foreach($roles as $row)
            <option value='{{$row->name}}'>{{$row->name}}</option>
            @endforeach
        </select>
        @error('roles')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="text-center mb-1">Applied for this @if($user_id) {{ count($user_id) }} @endif users below</div>
    <ol class="list-group list-group-numbered mb-3">
      @foreach($delsel as $row)
        <li class="list-group-item list-group-item-action">{{$row->name}}</li>
      @endforeach
    </ol>
  </x-slot>
</x-ModalForm>

<!-- Delete User Modal -->
<x-ModalForm modalname="form-del" linksubmit="delete" btntype="danger" btnlabel="Delete">
  <x-slot:modaltitle>
    Delete User Confirmation
  </x-slot>
  <x-slot:modalbody>
    <div class="text-center mb-1">Do you want delete this @if($user_id) {{ count($user_id) }} @endif users ?</div>
      <ol class="list-group list-group-numbered">
      @foreach($delsel as $row)
        <li class="list-group-item list-group-item-action">{{$row->name}}</li>
      @endforeach
      </ol>
      <div class="text-center mt-1">
        <small class="text-danger">*All files from the selected users will be permanently deleted</small>
    </div>
  </x-slot>
</x-ModalForm>