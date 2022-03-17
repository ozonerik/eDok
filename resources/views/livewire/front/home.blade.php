@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<x-grafik namechart="blngraph" target="blngraph" type="bar" labelcolor="white" :labelchart="$labelbln" :datachart="$databln" :fontcolor="['white']" :chartcolor="['DarkBlue']"/>
<script>
window.addEventListener('update-tahun', event => {
    blngraph.data.datasets[0].data=@this.databln;
    blngraph.data.labels=@this.labelbln;
    blngraph.update();
})
</script>
@endpush
<div>
    <x-LoadingState />
    @include('livewire.front.sections.section1')
    <!-- @include('livewire.front.sections.section2')
    @include('livewire.front.sections.section3')
    @include('livewire.front.sections.section4')
    @include('livewire.front.sections.section5') -->
</div>
