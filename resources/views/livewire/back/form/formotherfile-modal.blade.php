<!-- Delete Otherfile Modal -->
<div class="modal fade" wire:ignore.self id="form-del" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete File Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form autocomplete="off" wire:submit.prevent="delete">
      <div class="modal-body">
        <h5 class="text-center">Do you want delete this @if($myfile_id) {{ count($myfile_id) }} @endif items ?</h5>
        <ol class="list-group list-group-numbered">
        @foreach($delsel as $row)
          <li class="list-group-item list-group-item-action">{{$row->name}} by {{$row->user->name}}</li>
        @endforeach
        </ol>
      </div>
      <div class="modal-footer">
        <div class="col" wire:loading>
          Please Wait...
        </div>
        <button type="button" class="btn btn-secondary btn-sm text-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger btn-sm text-light">Delete</button>
      </div>
      </form>
    </div>
  </div>
</div>