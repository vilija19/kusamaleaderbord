<?php

namespace App\Http\Controllers;

use App\Models\Validator;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $data = array();
        $data['wish_only'] = 0;
        $data['valid_only'] = 0;
        $url = '/?';

        $data['wish_list'] =  $this->getWishList();

        if ($request->get('filter')) {
            $url .= 'filter='.$request->get('filter').'&';
            $this->setFilterCookie($request);
        }

        $query = Validator::query();

        if ($request->get('search')) {
            $url .= 'search='.$request->get('search').'&';

            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }

        if ($request->get('valid_only') || (!$request->get('filter') && Cookie::get("valid_only"))) {
            $url .= 'valid_only='.$request->get('valid_only').'&';
            $data['valid_only'] = 1;

            $query->where('valid', 1);
        }

        if ($request->get('wish_only') || (!$request->get('filter') && Cookie::get("wish_only"))) {
            $data['wish_only'] = 1;
            $url .= 'wish_only='.$request->get('wish_only').'&';
            if ($data['wish_list']) {
                $query->whereIn('id', $data['wish_list']);
            }
        }

        $query->orderBy('nomination_order', 'asc');
        $validatorsInfo = $query->get();

        $data['version'] = '';
        $versionInfo = Version::first();
        if ($versionInfo && !$versionInfo->asknowledgement) {
            $data['version'] = 'Last version ' . $versionInfo->version;
        }

        /**
         * To show sql query use this code
         * dd(Str::replaceArray('?', $query->getBindings(), $query->toSql()) );
         */

        $data['candidates'] = $validatorsInfo;
        $data['url'] = $url;

        $data['last_update'] = 'never';
        $lastUpdatedUser = $validatorsInfo->sortBy('updated_at')->first();
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
        /**
         * Return array cookies with keys only
         */
        $cookies = array ();
        if (Cookie::get("validators_wish")) {
            $cookies = Cookie::get("validators_wish");
        }
        return array_keys($cookies);
    }

    public function add_to_wish(Request $request)
    {
        $json = array();
        $cookies = $this->getWishList();
        if (!in_array($request->id,$cookies)) {
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
