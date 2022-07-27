<?php

namespace App\Http\Controllers;

use App\Models\Validator;

class LeaderboardController extends Controller
{
    public function index()
    {
        $data = array();
        $data['candidates'] = Validator::all();
        return view('main', $data);
    }
}
