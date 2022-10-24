/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/statistics.js":
/*!************************************!*\
  !*** ./resources/js/statistics.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

// Prende i dati dalla view admin.statistics attraverso l'input hidden #user-data
var myData = JSON.parse(document.getElementById('user-data').value); // Variabile che verrà utilizzata in generateChart()
// per contenere l'oggetto di Chart.js che creerà il grafico 

var myChart; // Array a cui verrà assegnata la lista con la media voti delle recensioni ricevute

var reviews_avg_vote_array = []; // Assegnazione a 'reviews_avg_vote_array' 

Object.keys(myData.years).forEach(function (period) {
  reviews_avg_vote_array.push(myData.years[period].reviews_avg_vote);
}); // Array a cui verrà assegnata la lista con i mesi in italiano

var months = []; // Array a cui verrà assegnata la lista anni/mesi
// che verrà visualizzata sull'asse orizzontale del grafico

var labels_chart_object = []; // Lista degli elementi Html che consentono all'utente di cambiare
// la visualizzazione del grafico (...|2020|2021|...|Tutti gli anni)

var periodList = document.getElementsByClassName('period-list-item'); // Contenitore Html del grafico

var statisticsChart = document.getElementById('statistics-chart').getContext('2d'); // Genero il grafico per visualizzare le statistiche relative al numero 
// e alla media voti delle recensioni ricevute durante 'TUTTI GLI ANNI'

generateChart(myData.years); //*********************
// ADD EVENT LISTENER
//*********************
// Al click degli elementi in periodList (...|2020|2021|...|Tutti gli anni)
// viene generato un nuovo grafico 

Object.entries(periodList).forEach(function (item) {
  item = item[1];
  item.addEventListener('click', function () {
    // Svuoto i due array che erano già stati utilizzati in precedenza
    // per la creazione del grafico
    reviews_avg_vote_array = [];
    months = []; // Imposto la variabile 'period' con l'innerHTML 
    // degli elementi Html cliccati dall'utente

    var period = item.innerHTML; // SE si è cliccato su 'TUTTI GLI ANNI'

    if (period === 'TUTTI GLI ANNI') {
      Object.keys(myData.years).forEach(function (period) {
        reviews_avg_vote_array.push(myData.years[period].reviews_avg_vote);
      }); // ALTRIMENTI
    } else {
      Object.keys(myData.years[period].months).forEach(function (month) {
        reviews_avg_vote_array.push(myData.years[period].months[month].reviews_avg_vote); // Creo la lista dei mesi in italiano

        months.push(month);
      }); // Unisco la 'lista dei mesi' con la 'lista della media voti per mese'

      reviews_avg_vote_array = array_combine(months, reviews_avg_vote_array);
    } // In base al valore 'period' passato in generateChart(),
    // assegno 'labels_chart_object' usata da 'statistics-chart',
    // SE period E' 'TUTTI GLI ANNI' ALLORA visualizzeremo il grafico per TUTTI GLI ANNI


    if (period === 'TUTTI GLI ANNI') {
      labels_chart_object = myData.years; // ALTRIMENTI visualizzeremo il grafico per l'ANNO SELEZIONATO dall'utente
    } else {
      labels_chart_object = myData.years[period].months;
    } // Distruggo il grafico esistente


    myChart.destroy(); // Creo un nuovo grafico con il periodo selezionato dall'utente

    generateChart(labels_chart_object);
  });
}); //***********
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
      labels: Object.keys(labels_chart_object),
      // lista anni/mesi (asse orizz.)
      datasets: [{
        label: 'Media Voti',
        // etichetta visualizzata al passaggio del mouse sulle singole candele
        data: reviews_avg_vote_array,
        // lista media voti recensioni ricevute (asse vert.)
        backgroundColor: ['#3490dc'],
        borderColor: ['rgba(54, 162, 235, 1)'],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          suggestedMax: 5,
          // valore massimo impostato sull'asse verticale
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
} // ARRAY_COMBINE FOR JAVASCRIPT
// eslint-disable-line camelcase
//  discuss at: https://locutus.io/php/array_combine/
// original by: Kevin van Zonneveld (https://kvz.io)
// improved by: Brett Zamir (https://brett-zamir.me)
//   example 1: array_combine([0,1,2], ['kevin','van','zonneveld'])
//   returns 1: {0: 'kevin', 1: 'van', 2: 'zonneveld'}


function array_combine(keys, values) {
  var newArray = {};
  var i = 0; // input sanitation
  // Only accept arrays or array-like objects
  // Require arrays to have a count

  if (_typeof(keys) !== 'object') {
    return false;
  }

  if (_typeof(values) !== 'object') {
    return false;
  }

  if (typeof keys.length !== 'number') {
    return false;
  }

  if (typeof values.length !== 'number') {
    return false;
  }

  if (!keys.length) {
    return false;
  } // number of elements does not match


  if (keys.length !== values.length) {
    return false;
  }

  for (i = 0; i < keys.length; i++) {
    newArray[keys[i]] = values[i];
  }

  return newArray;
}

/***/ }),

/***/ 6:
/*!******************************************!*\
  !*** multi ./resources/js/statistics.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\Dogana\Boolean Project\laravel-projects\bdoctors_project\resources\js\statistics.js */"./resources/js/statistics.js");


/***/ })

/******/ });