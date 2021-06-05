<?php

namespace App\Models;

use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    protected $table 		= 'SLS_RESELLERS';
    protected $primaryKey   = 'PK_NO';

    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';

    protected $fillable = [
        'NAME'
    ];
    public function getResellerCombo(){
        return Reseller::where('IS_ACTIVE', 1)->pluck('NAME', 'PK_NO');
    }

    public function getResellerComboCustomer(Type $var = null)
    {
        $response = '';
        $data = Reseller::select('NAME','PK_NO')->where('IS_ACTIVE', 1)->get();
        if ($data) {
            foreach ($data as $value) {
                $response .= '<option value="'.$value->PK_NO.'">'.$value->NAME.'</option>';
            }
        }else{
            $response .= '<option value="">No data found</option>';
        }
        return $response;
    }
    public function customer() {
        return $this->hasMany('App\Models\Customer', 'F_RESELLER_NO', 'PK_NO');
    }

    public function agent() {
        return $this->hasOne('App\Models\Agent','PK_NO', 'F_PREFERRED_AGENT_NO');
    }

    public function state() {
        return $this->hasOne('App\Models\State', 'PK_NO', 'STATE');
    }

    public function city() {
        return $this->hasOne('App\Models\City', 'PK_NO', 'CITY');
    }

    public function country() {
        return $this->hasOne('App\Models\Country', 'PK_NO', 'F_COUNTRY_NO');
    }



    public static function boot()
    {
       parent::boot();
       static::creating(function($model)
       {
           $user = Auth::user();
           $model->F_SS_CREATED_BY = $user->PK_NO;
       });

       static::updating(function($model)
       {
           $user = Auth::user();
           $model->F_SS_MODIFIED_BY = $user->PK_NO;
       });
   }


}
