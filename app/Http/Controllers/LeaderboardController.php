<?php

namespace App\Http\Controllers;

use App\Models\Validator;
use Illuminate\Support\Facades\Log;

class LeaderboardController extends Controller
{
    public function index()
    {
        $data = array();
        $data['candidates'] = Validator::all()->sortBy(['nomination_order', 'asc']);
        
        return view('main', $data);
    }
}
