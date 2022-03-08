<div id="form-receive" class="modal fade" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
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
              <td colspan="2" class="text-center">{!! QrCode::size(120)->generate($qrcode); !!}</td>
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