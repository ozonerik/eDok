<!-- Delete Other file Modal -->
<x-ModalForm modalname="form-receive" linksubmit="download" btntype="success" btnlabel="Download">
  <x-slot:modaltitle>
    File Details
  </x-slot>
  <x-slot:modalbody>
  @if(!empty($myfile))
    @foreach($myfile as $row)
    Nama : {{$row->name}} <br>
    Path : {{$row->path}} <br>
    Category Id : {{$row->filecategory_id}} <br>
    Owner Id : {{$row->user_id}} <br>
    Size : {{$row->file_size}} <br>
    @endforeach
  @endif
  </x-slot>
</x-ModalForm>