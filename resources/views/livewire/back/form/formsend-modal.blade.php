<div id="form-sending" class="modal fade" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">File Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" autocomplete="off" wire:submit.prevent="export({{$fileid}})">
      <div class="modal-body">
        <table class="table table-borderless table-rounded">
          <thead class="table-light">
            <tr>
              <th colspan="2" class="text-center">Code</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="2" class="text-center">{!! QrCode::size(120)->generate(url('download?c='.$qrcode)); !!}</td>
            </tr>
            <tr>
              <td class="fw-bold">File Name</td>
              <td>@foreach($myfile as $row) {{$row->name}} @endforeach</td>
            </tr>
            <tr>
              <td class="fw-bold">Category Name</td>
              <td>@foreach($myfile as $row) {{$row->filecategory->name}} @endforeach</td>
            </tr>
            <tr>
              <td class="fw-bold">Owner</td>
              <td>@foreach($myfile as $row) {{$row->user->name}} @endforeach</td>
            </tr>
            <tr>
              <td class="fw-bold">Size</td>
              <td>@foreach($myfile as $row) {{convert_bytes($row->file_size)}} @endforeach</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="me-auto btn btn-secondary btn-sm text-light" data-bs-dismiss="modal">Close</button>
        @foreach($myfile as $row)
          @if(Storage::disk('public')->exists($row->path))
          <button type="submit" wire:loading.attr="disabled" wire:loading.class.remove="btn-success" wire:loading.class="btn-secondary" class="btn btn-success btn-sm text-light">Download</button>
          @else
          <button type="submit" class="btn btn-secondary btn-sm text-light" disabled>Download</button>
          @endif
        @endforeach
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Other file Modal -->
<x-ModalForm modalname="form-del" linksubmit="delete" btntype="danger" btnlabel="Delete">
  <x-slot:modaltitle>
    Delete File Confirmation
  </x-slot>
  <x-slot:modalbody>
    <div class="text-center mb-1">Do you want delete this @if($mysend_id) {{ count($mysend_id) }} @endif items ?</div>
    <ol class="list-group list-group-numbered">
    @foreach($delsel as $row)
      <li class="list-group-item list-group-item-action">{{$row->myfile->name}} ( Recipient: {{$row->receiveuser->name}} )</li>
    @endforeach
    </ol>
  </x-slot>
</x-ModalForm>

<!-- Sending File -->
<x-ModalForm modalname="form" linksubmit="store" btntype="success" btnlabel="Save">
  <x-slot:modaltitle>
    Send File
  </x-slot>
  <x-slot:modalbody>
    <div class="form-group mb-3">
        <label>Select Recipient </label>
        <input type="text" class="form-control mb-1 @error('searchrecipient') is-invalid @enderror " wire:model="searchrecipient" placeholder="Search Recipient" >
        
        @if(!empty($searchrecipient))
        Result:
        <ol class="list-group mb-3">
          @foreach($userlist as $row)
          <btn wire:click="is_recipient({{$row->id}})" class="btn btn-outline-secondary mb-1" >
            {{ $row->name }}
          </btn>
          @endforeach
        </ol>
        @endif

        @if(!empty($userselect->count()))
        Recipient List:
        <ol class="list-group mb-3">
          @foreach($userselect as $row)
          <a href="#" wire:click="del_recipient({{$row->id}})" class="list-group-item list-group-item-action">{{$row->name}}</a>
          @endforeach
        </ol>
        @endif
        
    </div>
    <div class="form-group mb-3">
        <label>Select File</label>
        <select multiple class="form-select @error('filesend') is-invalid @enderror" wire:model.defer="filesend">
            <option Selected class="text-muted">Please Select</option>    
            @foreach($filelist as $row)
            <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </select>
        @error('filesend')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
  </x-slot>
</x-ModalForm>