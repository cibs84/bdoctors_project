// Prende i dati dalla view admin.statistics attraverso l'input hidden #user-data
let myData = JSON.parse(document.getElementById('user-data').value);

// Variabile che verrà utilizzata in generateChart()
// per contenere l'oggetto di Chart.js che creerà il grafico 
let myChart;

// Array a cui verrà assegnata la lista con la media voti delle recensioni ricevute
let reviews_avg_vote_array = [];

// Assegnazione a 'reviews_avg_vote_array' delle medie voti 
// delle recensioni ricevute durante 'TUTTI GLI ANNI'
Object.keys(myData.years).forEach(period => {
  reviews_avg_vote_array.push(myData.years[period].reviews_avg_vote);
});

// Array a cui verrà assegnata la lista con i mesi in italiano
let months = [];

// Array a cui verrà assegnata la lista anni/mesi
// che verrà visualizzata sull'asse orizzontale del grafico
let labels_chart_object = [];

// Lista degli elementi Html che consentono all'utente di cambiare
// la visualizzazione del grafico (...|2020|2021|...|Tutti gli anni)
let periodList = document.getElementsByClassName('period-list-item');

// Contenitore Html del grafico
let statisticsChart = document.getElementById('statistics-chart').getContext('2d');

// Genero il grafico per visualizzare le statistiche relative al numero 
// e alla media voti delle recensioni ricevute durante 'TUTTI GLI ANNI'
generateChart(myData.years);


//*********************
// ADD EVENT LISTENER
//*********************

// Al click degli elementi in periodList (...|2020|2021|...|Tutti gli anni)
// viene generato un nuovo grafico 
Object.entries(periodList).forEach(item => {
  item = item[1];
  item.addEventListener('click', function(){
    // Svuoto i due array che erano già stati utilizzati in precedenza
    // per la creazione del grafico
    reviews_avg_vote_array = [];
    months = [];
    
    // Imposto la variabile 'period' con l'innerHTML 
    // degli elementi Html cliccati dall'utente
    let period = item.innerHTML;

    // SE si è cliccato su 'TUTTI GLI ANNI'
    if (period === 'TUTTI GLI ANNI') {
      Object.keys(myData.years).forEach(period => {
          reviews_avg_vote_array.push(myData.years[period].reviews_avg_vote);
      });
    // ALTRIMENTI
    } else {
      Object.keys(myData.years[period].months).forEach(month => {
          reviews_avg_vote_array.push(myData.years[period].months[month].reviews_avg_vote);
          // Creo la lista dei mesi in italiano
          months.push(month);
      });
      // Unisco la 'lista dei mesi' con la 'lista della media voti per mese'
      reviews_avg_vote_array = array_combine(months, reviews_avg_vote_array);
    }
    
    // In base al valore 'period' passato in generateChart(),
    // assegno 'labels_chart_object' usata da 'statistics-chart',
    // SE period E' 'TUTTI GLI ANNI' ALLORA visualizzeremo il grafico per TUTTI GLI ANNI
    if (period === 'TUTTI GLI ANNI') {
        labels_chart_object = myData.years;
    // ALTRIMENTI visualizzeremo il grafico per l'ANNO SELEZIONATO dall'utente
    } else {
        labels_chart_object = myData.years[period].months
    }

    // Distruggo il grafico esistente
    myChart.destroy();

    // Creo un nuovo grafico con il periodo selezionato dall'utente
    generateChart(labels_chart_object);
  })
});


//***********
// FUNCTIONS
//***********

// Genera il grafico con le statistiche relative alle recensioni 
// e ai messaggi ricevuti in base al periodo che l'utente decide 
// di visualizzare tra 'TUTTI GLI ANNI' e un [SINGOLO ANNO] di riferimento
function generateChart(labels_chart_object) {
    // Nuova istanza della classe Chart utilizzata da Chart.js per la creazione del grafico
    myChart = new Chart(statisticsChart, {
        type: 'bar',
        data: {
            labels: Object.keys(labels_chart_object), // lista anni/mesi (asse orizz.)
            datasets: [{
                label: 'Media Voti', // etichetta visualizzata al passaggio del mouse sulle singole candele
                data: reviews_avg_vote_array, // lista media voti recensioni ricevute (asse vert.)
                backgroundColor: [
                    '#3490dc'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 5, // valore massimo impostato sull'asse verticale
                    title: {
                        display: true,
                        text: 'Media Voti Recensioni' // etichetta sull'asse verticale
                      }
                }
            },
            animation: {
                  y: {
                    duration: 1000,
                    from: 500
                  }
            }
        }
    });
}

// ARRAY_COMBINE FOR JAVASCRIPT
// eslint-disable-line camelcase
//  discuss at: https://locutus.io/php/array_combine/
// original by: Kevin van Zonneveld (https://kvz.io)
// improved by: Brett Zamir (https://brett-zamir.me)
//   example 1: array_combine([0,1,2], ['kevin','van','zonneveld'])
//   returns 1: {0: 'kevin', 1: 'van', 2: 'zonneveld'}
function array_combine (keys, values) { 
    const newArray = {}
    let i = 0
    // input sanitation
    // Only accept arrays or array-like objects
    // Require arrays to have a count
    if (typeof keys !== 'object') {
      return false
    }
    if (typeof values !== 'object') {
      return false
    }
    if (typeof keys.length !== 'number') {
      return false
    }
    if (typeof values.length !== 'number') {
      return false
    }
    if (!keys.length) {
      return false
    }
    // number of elements does not match
    if (keys.length !== values.length) {
      return false
    }
    for (i = 0; i < keys.length; i++) {
      newArray[keys[i]] = values[i]
    }
    return newArray
  }