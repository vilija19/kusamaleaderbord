<?php

namespace App\Http\Controllers;

use App\Models\Validator;
use Illuminate\Support\Facades\Http;

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
        $validatorsOldInfo = Validator::all();
        $validatorsNewInfo = Http::get('https://kusama.w3f.community/candidates')->collect()->toArray();
        
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
            $validator->invalidityReasons = $validatorInfo['invalidityReasons'];
            $validator->unclaimedEras = ''; // $validatorInfo['unclaimedEras'];
            $validator->inclusion = $validatorInfo['inclusion'];
            $validator->name = $validatorInfo['name'];
            $validator->commission = $validatorInfo['commission'];
            $validator->identity = ''; // $validatorInfo['identity'];
            $validator->active = $validatorInfo['active'];
            $validator->validity = ''; // $validatorInfo['validity'];
            $validator->score = round($validatorInfo['total']);
            $validator->councilStake = $validatorInfo['councilStake'];
            $validator->councilVotes = ''; // $validatorInfo['councilVotes'];
            $validator->democracyVoteCount = $validatorInfo['democracyVoteCount'];
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
