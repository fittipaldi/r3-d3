<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Spacecraft extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spacecraft';

    /**
     * Get all the articles that belong to the tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function armaments()
    {
        return $this->hasMany(SpacecraftArmament::class);
    }

    /**
     *
     *  Validate request data before saving
     *
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public static function ValidateRequestData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'class' => 'required|max:255',
            'crew' => 'required|integer|between:0,9999999',
            'image' => 'required|max:255',
            'status' => 'required|max:255',
            'value' => 'required|numeric|between:0,99999999.99',
        ]);
        if ($validator->fails()) {
            $errorMsg = [];
            foreach ($validator->errors()->getMessages() as $msgs) {
                foreach ($msgs as $msg) {
                    $errorMsg[] = $msg;
                }
            }
            $httpStatusException = 402;
            throw new \Exception(implode(', ', $errorMsg));
            return false;
        }

        $armament = $request->input('armament', []);
        foreach ($armament as $arm) {
            $validatorArm = Validator::make($arm, [
                'title' => 'required|max:255',
                'qtd' => 'required|integer|between:0,9999999',
            ]);
            if ($validatorArm->fails()) {
                $errorMsg = [];
                foreach ($validatorArm->errors()->getMessages() as $msgs) {
                    foreach ($msgs as $msg) {
                        $errorMsg[] = $msg;
                    }
                }
                $httpStatusException = 402;
                throw new \Exception(implode(', ', $errorMsg));
                return false;
            }
        }
        return true;
    }

}
