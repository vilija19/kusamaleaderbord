<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Web3;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;

class Web3AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        Web3::verifySignature(
            $this->getSignatureMessage(session()->get('metamask-nonce')),
            $request->signature,
            $request->address,
        );
    
        $user = User::query()->where('eth_address', $request->address)->first();

        session()->forget('metamask-nonce');

        if (!$user && config('web3login.strict_mode') == false) {
            $user = new User();
            $user->name = 'metamask-user';
            $user->email = $request->address;
            $user->password = Str::random(16);
            $user->eth_address = $request->address;
            $user->save();
            auth()->login($user);
        }elseif ($user) {
            auth()->login($user);
        }else {
            $message = new MessageBag(['password' => [trans('auth.failed').' Please register first']]);
            session()->put('errors', $message);
            return back();
        }
        return true;
    }
     
    public function signature()
    {
        // Generate some random nonce
        $code = Str::random(8);
        
        // Save in session
        session()->put('metamask-nonce', $code);
        
        // Create message with nonce
        return $this->getSignatureMessage($code);     
    
    }
    private function getSignatureMessage($code)
    {
        return __("I have read and accept the terms and conditions.\nPlease sign me in.\n\nSecurity code (you can ignore this): :nonce", [
            'nonce' => $code
        ]);
    }
}
