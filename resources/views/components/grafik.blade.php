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
                    color: "{{ $labelcolor }}"
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