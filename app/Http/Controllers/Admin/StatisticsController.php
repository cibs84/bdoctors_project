<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    //************
    // VARIABLES
    //************
    private $user = null;
    
    private $years = ['2019', '2020', '2021', '2022'];

    private $monthsIta = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];


    //************
    // FUNCTIONS
    //************
    // Genera i dati da inviare alla view 'admin.statistics' per generare le statistiche tramite Chart.js
    public function index(Request $request) {
        $this->user = $request->user();
        
        $reviews = DB::table('reviews')
                    ->select('reviews.*', DB::raw('count(reviews.user_id) as reviews_count'), DB::raw('avg(reviews.vote) as reviews_avg_vote'))
                    ->where('reviews.user_id', '=', $this->user->id)
                    // ->whereYear('reviews.created_at', '=', '2019')
                    ->get();
        $messages = DB::table('messages')
                    ->select('messages.*', DB::raw('count(messages.user_id) as messages_count'))
                    ->where('messages.user_id', '=', $this->user->id)
                    // ->whereYear('messages.created_at', '=', '2019')
                    ->get();

        foreach ($this->years as $year) {
            $statisticsDataByPeriod[] = $this->getStatisticsDataByPeriod($year);
        };
        
        $statisticsDataByPeriod = array_combine($this->years, $statisticsDataByPeriod);

        $statisticsData = [
            'messages_count' => $messages[0]->messages_count,
            'reviews_count' => $reviews[0]->reviews_count,
            'reviews_avg_vote' => $reviews[0]->reviews_avg_vote,
            'years' => $statisticsDataByPeriod
        ];

        $data = [
            'user' => $this->user,
            'statisticsData' => $statisticsData
        ];
        
        return view('admin.statistics', $data);
    }

    // Invocata da index() per prendere i dati relativi agli Anni e ai Mesi
    // in cui l'utente ha ricevuto le recensioni e i messaggi
    public function getStatisticsDataByPeriod($year) {
        $reviews = DB::table('reviews')
                    ->select('reviews.*', DB::raw('count(reviews.user_id) as reviews_count'), DB::raw('avg(reviews.vote) as reviews_avg_vote'))
                    ->where('reviews.user_id', '=', $this->user->id)
                    ->whereYear('reviews.created_at', '=', $year)
                    ->get();
        $messages = DB::table('messages')
                    ->select('messages.*', DB::raw('count(messages.user_id) as messages_count'))
                    ->where('messages.user_id', '=', $this->user->id)
                    ->whereYear('messages.created_at', '=', $year)
                    ->get();

        for ($i=1; $i <= 12 ; $i++) {
            $month = $i;
            $statisticsDataByMonth[] = $this->getStatisticsDataByMonth($year, $month);
        }
        
        $statisticsDataByMonth = array_combine($this->monthsIta, $statisticsDataByMonth);

        $statisticsDataByPeriod = [
                    'messages_count' => $messages[0]->messages_count,
                    'reviews_count' => $reviews[0]->reviews_count,
                    'reviews_avg_vote' => $reviews[0]->reviews_avg_vote,
                    'months' => $statisticsDataByMonth
        ];

        return $statisticsDataByPeriod;
    }
    
    // Invocata da getStatisticsDataByPeriod() per prendere i dati relativi ai Mesi
    // in cui l'utente ha ricevuto le recensioni e i messaggi
    public function getStatisticsDataByMonth($year, $month) {
        $reviews = DB::table('reviews')
                    ->select('reviews.*', DB::raw('count(reviews.user_id) as reviews_count'), DB::raw('avg(reviews.vote) as reviews_avg_vote'))
                    ->where('reviews.user_id', '=', $this->user->id)
                    ->whereYear('reviews.created_at', '=', $year)
                    ->whereMonth('reviews.created_at', '=', $month)
                    ->get();
        $messages = DB::table('messages')
                    ->select('messages.*', DB::raw('count(messages.user_id) as messages_count'))
                    ->where('messages.user_id', '=', $this->user->id)
                    ->whereYear('messages.created_at', '=', $year)
                    ->whereMonth('messages.created_at', '=', $month)
                    ->get();

        $statisticsDataByMonth = [
                    'messages_count' => $messages[0]->messages_count,
                    'reviews_count' => $reviews[0]->reviews_count,
                    'reviews_avg_vote' => $reviews[0]->reviews_avg_vote
        ];

        return $statisticsDataByMonth;
    }
}