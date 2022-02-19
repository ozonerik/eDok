@props([
    'modaltitle',
    'modalbody',
])
<div id="{{ $modalname }}" class="modal fade" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $modaltitle }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form autocomplete="off" wire:submit.prevent="{{ $linksubmit }}">
      <div class="modal-body">
        {{ $modalbody }}
      </div>
      <div class="modal-footer">
        <button type="button" class="me-auto btn btn-secondary btn-sm text-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-{{ $btntype }} btn-sm text-light">{{ $btnlabel }}</button>
      </div>
      </form>
    </div>
  </div>
</div>