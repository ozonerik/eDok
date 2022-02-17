<div class="d-flex flex-row align-items-center">
    <div>{{ $slot }}</div>
@if($colName == $sortBy )
    @if($sortDir == "asc")
    <div class="d-flex justify-content-start ms-auto">
        <i class="bi bi-arrow-up"></i>
        <i class="bi bi-arrow-down text-muted"></i>
    </div>
    @else    
    <div class="d-flex justify-content-start ms-auto">
        <i class="bi bi-arrow-up text-muted"></i>
        <i class="bi bi-arrow-down "></i>
    </div>
    @endif
@else
    <div class="d-flex justify-content-start ms-auto">
        <i class="bi bi-arrow-up text-muted"></i>
        <i class="bi bi-arrow-down text-muted"></i>
    </div>
@endif
</div>