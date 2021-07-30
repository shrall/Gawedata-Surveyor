<script>
    var data{{ $loop->iteration }} = [
        @foreach ($question['answer_choices'] as $answer)
            {
            y: 75,
            name: "{{ $answer['text'] }}"
            },
        @endforeach
    ]
    $('#chart-{{ $loop->iteration }}').highcharts({
        chart: {
            animation: false,
            type: 'pie',
            backgroundColor: null,
            height: 250
        },
        exporting: {
            enabled: false
        },
        title: {
            text: null
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
                    this.y + ' Responden (' + this.percentage + '%)</h6>';
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
            data: data{{ $loop->iteration }},
            size: '90%',
            innerSize: '75%',
        }]
    });
</script>
