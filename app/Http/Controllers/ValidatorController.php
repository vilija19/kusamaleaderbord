<?php

namespace App\Http\Controllers;

use App\Models\Validator;
use App\Models\Version;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ValidatorController extends Controller
{    
    public function show($id)
    {
        echo '<h1>Validator: ' . $id . '</h1>';
        return;
    }

/**
     * Update Validators Info from kusama telemetry service.
     * https://kusama.w3f.community/candidates
     * 
     *
     * @return boolean
     */
    public function updateValidators()
    {
        $result = false;

        $storedVersion = 0;
        $version = Version::first();
        if ($version) {
            $storedVersion = $version->version;
        }
        $lastNodeVersion = 0;
        try {
            $versionInfo = Http::get('https://api.github.com/repos/paritytech/polkadot-sdk/releases')->collect();
            $lastNodeVersion = $versionInfo->first()['tag_name'];
        } catch (\Throwable $th) {
            Log::channel('update')->info('Version update error . ' . $th->getMessage());
        }

        if ($lastNodeVersion != $storedVersion) {
            $version->version = $lastNodeVersion;
            $version->asknowledgement = 0;
            $version->save();
        }

        $validatorsOldInfo = Validator::all();
        $validatorsNewInfo = [];
        try {
            $validatorsNewInfo = Http::get('https://kusama.w3f.community/candidates')->collect()->toArray();
        } catch (\Throwable $th) {
            //throw $th;
            Log::channel('update')->info('Validators info update error. ' . $th->getMessage());
        }
        
        foreach ($validatorsNewInfo as $nomination_order => $validatorInfo) {
            $validator = $validatorsOldInfo->find($validatorInfo['stash']);
            if (!$validator) {
                $validator = new Validator();
                $validator->id = $validatorInfo['stash'];
            }
            $validator->discoveredAt = $validatorInfo['discoveredAt'];
            $validator->nominatedAt = $validatorInfo['nominatedAt'];
            $validator->offlineSince = $validatorInfo['offlineSince'];
            $validator->offlineAccumulated = $validatorInfo['offlineAccumulated'];
            $validator->rank = $validatorInfo['rank'];
            $validator->faults = $validatorInfo['faults'];
            $validator->invalidityReasons = $validatorInfo['invalidityReasons'] ?? '';
            $validator->unclaimedEras = ''; // $validatorInfo['unclaimedEras'];
            $validator->inclusion = $validatorInfo['inclusion'];
            $validator->name = $validatorInfo['name'];
            $validator->commission = $validatorInfo['commission'] ?? 0;
            $validator->identity = ''; // $validatorInfo['identity'];
            $validator->active = $validatorInfo['active'] ?? '0';
            $validator->valid = $validatorInfo['valid'] ?? 2;
            $validator->validity = ''; // $validatorInfo['validity'];
            $validator->score = round($validatorInfo['total']);
            $validator->councilStake = $validatorInfo['councilStake'] ?? 0;
            $validator->councilVotes = ''; // $validatorInfo['councilVotes'];
            $validator->democracyVoteCount = $validatorInfo['democracyVoteCount'] ?? 0;
            $validator->democracyVotes = ''; // $validatorInfo['democracyVotes'];
            $validator->nomination_order = $nomination_order;
            $validator->save();
        }
        if ($validatorsNewInfo) {
            $result = true;
        }
        return $result;
    }

}
