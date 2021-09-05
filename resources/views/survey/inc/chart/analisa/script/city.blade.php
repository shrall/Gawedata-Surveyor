<script>
    var city = [
        @foreach ($result['city'] as $city)
            {
            y: Object.values(@json($city))[0],
            name: Object.keys(@json($city))[0]
            },
        @endforeach
    ]

    $('#city-chart').highcharts({
        chart: {
            animation: false,
            type: 'pie',
            backgroundColor: null,
            height: 250
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            labelFormatter: function() {
                return this.name + ': ' + Math.round(this.percentage) + '%';
            }
        },
        title: {
            text: null
        },
        exporting: {
            enabled: false,
        },
        tooltip: {
            valueSuffix: ' Responden',
            enabled: true,
            backgroundColor: '#ffffff',
            borderColor: '#ffffff',
            borderRadius: 12,
            style: {
                fontFamily: 'Lato',
                fontWeight: 'bold',
            },
            formatter: function() {
                return '<h5 style="color:#a4a4a4;font-size: 1.1rem;">' + this.key + '</h5><br><br><h6>' +
                    this.y + ' Responden (' + Math.round(this.percentage) + '%)</h6>';
            }
        },
        plotOptions: {
            pie: {
                shadow: false,
                center: ['50%', '50%'],
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
            },
        },
        series: [{
            showInLegend: true,
            data: city,
            size: '90%',
            innerSize: '75%',
        }]
    });
</script>
