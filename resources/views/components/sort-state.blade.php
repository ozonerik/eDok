<div class="d-flex flex-row align-items-center">
    <div>{{ $slot }}</div>
@if($colName == $sortBy )
    @if($sortDir == "asc")
    <div class="d-flex justify-content-start ms-auto">
        <i class="bi bi-arrow-up-short"></i>
        <i class="bi bi-arrow-down-short text-muted"></i>
    </div>
    @else    
    <div class="d-flex justify-content-start ms-auto">
        <i class="bi bi-arrow-up-short text-muted"></i>
        <i class="bi bi-arrow-down-short "></i>
    </div>
    @endif
@else
    <div class="d-flex justify-content-start ms-auto">
        <i class="bi bi-arrow-up-short text-muted"></i>
        <i class="bi bi-arrow-down-short text-muted"></i>
    </div>
@endif
</div>