<div>
    @if($selectPage)
    <div class="d-flex flex-column flex-md-row justify-content-center mb-3">
        @if($selectAll)
        <div class="text-center">
        You have selected All <strong>{{$table->total()}}</strong> items. <a href="#" wire:click="{{$linkDeselect}}">Deselect All</a>
        </div>
        @else
        <div class="me-md-2 text-center">
        You have selected <strong>{{ count($checked) }}</strong> items. 
        </div>
        <div class="text-center">
        Do you want to Select All <strong>{{$table->total()}}</strong> items ? <a href="#" wire:click="{{$linkSelect}}">Select All</a>
        </div>
        @endif
    </div>
    @endif
</div>