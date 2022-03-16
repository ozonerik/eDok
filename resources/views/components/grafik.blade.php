<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    const {{$namechart}} = new Chart(document.getElementById( "{{ $target }}" ).getContext('2d'), {
    type: "{{ $type }}",
    data: 
        {
            labels: @js($labelchart),
            datasets: [
            {
                data: @js($datachart),
                backgroundColor : @js($isColor($chartcolor)),
            }
            ]
        },
    plugins: [ChartDataLabels],
    options: 
        {
            maintainAspectRatio : false,
            responsive : true,
            plugins:{
                legend:{
                    display:false
                },
                datalabels: {
                    color: 'White'
                }
            },
            scales: {
                y:{
                    beginAtZero: true,
                    ticks: {
                        precision:0
                    }
                }
            }
        }
    })
</script>