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
        </tbody>
    </table>
</div>