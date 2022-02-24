@props([
    'thead',
    'tbody',
])
<div class="table-responsive">
    <table class="table table-borderless table-hover table-rounded">
        <thead class="table-light">
            {{ $thead }}
        </thead>
        <tbody>
            {{ $tbody }}
            @if($table->count() == 0)
            <tr>
                <td colspan="@hasrole('admin') {{$ncolAdmin}} @else {{$ncol}} @endif" class="text-center text-muted">No Result</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>