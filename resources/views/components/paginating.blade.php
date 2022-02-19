<div>
    <div class="d-flex flex-column flex-md-row mt-3 mt-md-0 ">
        <div class="me-md-auto text-muted d-flex justify-content-center">
            <div>
                Showing {{$table->firstItem()}} to {{$table->lastItem()}} of {{$table->total()}} entries
            </div>
        </div>
        <div class="d-flex justify-content-center mt-md-0 mt-2">
            <div>
                {{$table->links()}}
            </div>
        </div>
    </div>
</div>