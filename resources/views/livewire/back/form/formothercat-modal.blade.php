<!-- Delete Category Modal -->
<div class="modal fade" wire:ignore.self id="form-del" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Category Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form autocomplete="off" wire:submit.prevent="delete({{ $category_id }})">
      <div class="modal-body">
        <div class="text-center fs-5">Apakah anda yakin ingin menghapus :</div>
        <div class="fw-bold text-center fs-5">{{ $category_name }} Owner: {{ $by }} </div>
        <div class="text-danger fs-5 text-center">Semua file pada kategori {{ $category_name }} akan terhapus !!</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm text-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger btn-sm text-light">Delete</button>
      </div>
      </form>
    </div>
  </div>
</div>