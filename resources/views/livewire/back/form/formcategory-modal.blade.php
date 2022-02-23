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