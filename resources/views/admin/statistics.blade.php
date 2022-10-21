@extends('layouts.dashboard')

@section('content')
    <div class="d-flex justify-content-between mb-5">
        <div>
            Numero totale messaggi: <span id="tot_messages"></span>
        </div>
    
        <div>
            Numero totale recensioni: <span id="tot_reviews"></span>
        </div>
    
        <ul id="filterList" class="d-flex">
            <li style="cursor: pointer" id="2019" onclick="changeSelectedYear('2019')">
                2019 
            </li>
            <li style="cursor: pointer" id="2020" onclick="changeSelectedYear('2020')">
                2020 
            </li>
            <li style="cursor: pointer" id="2021" onclick="changeSelectedYear('2021')">
                2021 
            </li>
            <li style="cursor: pointer" id="2022" onclick="changeSelectedYear('2022')">
                2022 
            </li>
            <li style="cursor: pointer" id="last_12_months" onclick="changeSelectedYear('last_12_months')">
                ULTIMI 12 MESI 
            </li>
            <li style="cursor: pointer" id="all" class="font-weight-bold my_font_color" onclick="changeSelectedYear('')">
                TUTTI GLI ANNI
            </li>
    
        </ul>
    </div>

    <div>Media Voti</div>

    <div style="width: 1000px; height: 500px">
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let previousClick;
        document.getElementById('filterList').addEventListener('click', (e) => {
            if (previousClick) {
                previousClick.className = ''
            }
            document.getElementById('all').className = '';
            previousClick = e.target;
            e.target.className = 'font-weight-bold my_font_color'
        })
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
            datasets: [{
                data: [],
                bars: [],
                backgroundColor: [  
                    'rgba(153, 102, 255, 0.2)',  
                ],
                borderColor: [
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 1
            }
        ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                },
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            animation: {
                onComplete: function() {
                    var _ctx = ctx;
                    _ctx.font = "normal 13px sans-serif"
                    _ctx.textAlign = 'center';
                    _ctx.textBaseline = 'bottom';
                    this.config.data.datasets.forEach(function (dataset) {
                        if(dataset.data._chartjs.listeners[0]._cachedMeta) {
                            dataset.data._chartjs.listeners[0]._cachedMeta.data.forEach(function (bar, index) {
                                _ctx.fillText('N. voti: ' + myChart.data.datasets[0].bars[index], bar.x, myChart.data.datasets[0].bars[index] === 0 ? bar.y - 10 : bar.y + 30);
                            });
                        }
                    })
                }
            }
        }
    });
        const messages_span = document.getElementById('tot_messages');
        const reviews_span = document.getElementById('tot_reviews');

        let messages = <?php echo json_encode($messages) ?>;
        let reviews = <?php echo json_encode($reviews) ?>;

        let selectedYear = '';
        
        let tot_messages = 0;
        let tot_reviews = 0;
        onYearChanged();
        
        // Funzione cambio anno dei list items
        function changeSelectedYear(year) {
            selectedYear = year;
            onYearChanged();
        }

        function updateTotalMessagesAndReviews() {
            messages_span.innerHTML = tot_messages;
            reviews_span.innerHTML = tot_reviews;
        }

        function resetTotalMessagesAndReview() {
            tot_messages = 0;
            tot_reviews = 0;
        }
        
        // Funzione condizioni sul cambio anno
        function onYearChanged() {
            if (selectedYear == 'last_12_months') {
                resetTotalMessagesAndReview();
                let monthsArray = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
                let currentMonth = new Date().getMonth();
                let date = new Date();
                date.setDate(1);
                let chartLabels = [];
                for (let i = 0; i <= 11; i++) {
                    chartLabels.push(monthsArray[date.getMonth()] + ' - ' + date.getFullYear());
                    date.setMonth(date.getMonth() - 1);
                }
                chartLabels.reverse();
                myChart.data.labels = chartLabels;
                let reviews_dataset = []; // media voti / barra grafico
                let bar_labels = []; // numero voti / numero all'interno della barra
                for(let i = 0; i < 12; i++) {
                        reviews_dataset[i] = 0;
                        bar_labels[i] = 0;
                }
                chartLabels.forEach((item, index) => {
                    let item_split = item.split(' - ');
                    let month_index = monthsArray.indexOf(item_split[0]);
                    if(messages[item_split[1]]) {
                        messages[item_split[1]].forEach(month => {
                            if(month.month == month_index + 1) {
                                tot_messages += month.count_messages;
                            }
                        })
                    }

                    if(reviews[item_split[1]]) {
                        reviews[item_split[1]].forEach(month => {
                            if(month.month == month_index + 1) {
                                tot_reviews += month.count_reviews;
                                reviews_dataset[index] = month.reviews_avg_vote;
                                bar_labels[index] = month.count_reviews;
                            }
                        })
                    }
                });

                myChart.data.datasets[0].bars = bar_labels;
                myChart.data.datasets[0].data = reviews_dataset;
            } else if(selectedYear == '') {
                let reviews_object = {};
                resetTotalMessagesAndReview();
                Object.entries(messages).map(_item => {
                    _item[1].map(item => {
                        tot_messages += item.count_messages;
                    });
                });
                let bar_labels_object = {};
                Object.entries(reviews).map(_item => {
                    reviews_object[_item[0]] = 0;
                    bar_labels_object[_item[0]] = 0;
                    _item[1].map(item => {
                        reviews_object[_item[0]] += +item.reviews_avg_vote
                        //count reviews = numero voti
                        bar_labels_object[_item[0]] += +item.count_reviews;
                        tot_reviews += item.count_reviews;
                    });
                    reviews_object[_item[0]] = reviews_object[_item[0]] / _item[1].length;
                });
                myChart.data.labels = [];
                myChart.data.datasets[0].data = [];
                myChart.data.datasets[0].bars = [];

                Object.entries(reviews_object).map((item, index) => {
                    myChart.data.datasets[0].bars.push(bar_labels_object[item[0]])
                    myChart.data.datasets[0].data.push(item[1]);
                    myChart.data.labels.push(item[0]);
                })
            } else {
                resetTotalMessagesAndReview();
                myChart.data.labels = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
                let reviews_dataset = []; // media voti / barra grafico
                let bar_labels = []; // numero voti / numero all'interno della barra
                if(messages[selectedYear]) {
                    messages[selectedYear].map(item => {
                        tot_messages += item.count_messages;
                    })
                } else {
                    tot_messages = 0;
                }
                
                if(reviews[selectedYear]) {
                    for(let i = 0; i < 12; i++) {
                        reviews_dataset[i] = 0;
                        bar_labels[i] = 0;
                    }
                    reviews[selectedYear].map(item => {
                        reviews_dataset[item.month-1] = item.reviews_avg_vote;
                        tot_reviews += item.count_reviews;
                        bar_labels[item.month-1] = item.count_reviews;
                    })
                } else {
                    
                    tot_reviews = 0;
                    for (let i = 0; i < 12; i++) {
                            reviews_dataset[i] = 0;
                            bar_labels[i] = 0;
                        }
                }

                myChart.data.datasets[0].bars = bar_labels;
                myChart.data.datasets[0].data = reviews_dataset;
            }
            myChart.update();
            updateTotalMessagesAndReviews();
        }        
    </script>
@endsection