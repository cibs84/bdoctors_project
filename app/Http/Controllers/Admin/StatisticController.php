<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;
use App\Review;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function getStatisticsUser(Request $request) {
        $user = $request->user();

        // Numero di messaggi diviso per anno
        $messages = Message::selectRaw('year(created_at) as year, month(created_at) as month, count(*) as count_messages')
                            ->where('user_id', $user->id)
                            ->groupBy('year', 'month')
                            ->orderBy('year', 'desc')
                            ->get();

        $messages_array = [];
        foreach($messages as $message) {
            if(!array_key_exists($message->year, $messages_array)) {
                $messages_array[$message->year] = [$message];
            } else {
                // dd($reviews_array);
                array_push($messages_array[$message->year], $message);
            }
        }

        

        // Numero di recensioni divisi per anno
        $reviews = Review::selectRaw('year(created_at) as year, month(created_at) as month, count(*) as count_reviews, avg(reviews.vote) as reviews_avg_vote')
                            ->where('user_id', $user->id)
                            ->groupBy('year', 'month')
                            ->orderBy('year', 'desc')
                            ->get();

        $reviews_array = [];
        foreach($reviews as $review) {
            if(!array_key_exists($review->year, $reviews_array)) {
                $reviews_array[$review->year] = [$review];
            } else {
                // dd($reviews_array);
                array_push($reviews_array[$review->year], $review);
            }
        }

        // dd($reviews_array);
        $data = [
            'user' => $user,
            'messages' => $messages_array,
            'reviews' => $reviews_array,
            
        ];
        return view('admin.statistics', $data);
    }
}

// data = 

// [

//     totale messaggio,
//     totale recensioni,
//     periodo
//         2019 => media voto,
//         2020 => media voto,
//         2021 => media voto,
//         2022 => media voto,
// ]
