<?php

namespace App\Http\Controllers;

use App\Models\Validator;

class LeaderboardController extends Controller
{
    public function index()
    {
        $data = array();
        $data['candidates'] = Validator::all()->sortBy(['nomination_order', 'asc']);
        
        $data['last_update'] = 'never';
        $lastUpdatedUser = $data['candidates']->sortByDesc('updated_at')->first();
        if ($lastUpdatedUser) {
            $data['last_update'] = $lastUpdatedUser->updated_at->toDateTimeString();
        }
        
        return view('main', $data);
    }
}
