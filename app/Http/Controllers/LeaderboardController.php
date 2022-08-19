<?php

namespace App\Http\Controllers;

use App\Models\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $data = array();
        $data['wish_only'] = 0;
        $data['valid_only'] = 0;
        $url = '/?';

        if ($request->get('search')) {
            $url .= 'search='.$request->get('search').'&';
            $validatorsInfo = Validator::query()->where('name', 'LIKE', "%{$request->get('search')}%")->get();
        } else {
            $validatorsInfo = Validator::all()->sortBy(['nomination_order', 'asc']);
        }
        $data['wish_list'] =  $this->getWishList();

        if ($request->get('filter')) {
            $url .= 'filter='.$request->get('filter').'&';
            $this->setFilterCookie($request);
        }



        if ($request->get('valid_only') || (!$request->get('filter') && Cookie::get("valid_only"))) {
            $url .= 'valid_only='.$request->get('valid_only').'&';
            $validatorsInfo = $validatorsInfo->where('valid', 1);
            $data['valid_only'] = 1;
        }

        if ($request->get('wish_only') || (!$request->get('filter') && Cookie::get("wish_only"))) {
            $data['wish_only'] = 1;
            $url .= 'wish_only='.$request->get('wish_only').'&';
            if ($data['wish_list']) {
                foreach ($validatorsInfo as $key => $validator) {
                    if (!array_key_exists($validator->id, $data['wish_list'])) {
                        $validatorsInfo->forget($key);
                    }
                }
            }
        }


        $data['candidates'] = $validatorsInfo;
        $data['url'] = $url;

        $data['last_update'] = 'never';
        $lastUpdatedUser = $data['candidates']->sortByDesc('updated_at')->first();
        if ($lastUpdatedUser) {
            $data['last_update'] = $lastUpdatedUser->updated_at->toDateTimeString();
        }
        
        return view('main', $data);
    }

    protected function setFilterCookie(Request $request)
    {
            if ($request->get('valid_only')){
                Cookie::queue("valid_only",'1',60*24*30);
            }else {
                Cookie::queue(Cookie::forget("valid_only")); 
            }
            if ($request->get('wish_only')){
                Cookie::queue("wish_only",'1',60*24*30);
            }else {
                Cookie::queue(Cookie::forget("wish_only")); 
            }            
    }

    protected function getWishList()
    {
        return Cookie::get("validators_wish");
    }

    public function add_to_wish(Request $request)
    {
        $json = array();
        $cookies = Cookie::get("validators_wish");
        if (!isset($cookies[$request->id])) {
            Cookie::queue("validators_wish[" . $request->id . "]",'1',60*24*30);
        }else {
            Cookie::queue(Cookie::forget("validators_wish[" . $request->id . "]")); 
        }
        $json['success'] = 1;
        return response()->json($json);
    }

    public function set_cookie(Request $request)
    {
        Cookie::queue(Cookie::forget("validators_wish[" . $request->id . "]")); 
        return;
    }
}
