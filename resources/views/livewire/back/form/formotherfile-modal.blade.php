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