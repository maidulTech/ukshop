<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'SS_CITY';
    protected $primaryKey 	= 'PK_NO';
    public $timestamps 		= false;

    public function getCityCombo(){
        return City::pluck('CITY_NAME', 'PK_NO');
    }

    public function PoCode() {
        return $this->hasOne('App\Models\PoCode', 'F_CITY_NO', 'PK_NO');
    }

    public function getCityByPostcode($post_code)
    {
         $data = PoCode::select('F_CITY_NO','CITY_NAME')->where('PO_CODE',$post_code)->get();
         $response = '<option value="">Select City</option>';

            if ($data) {
                foreach ($data as $value) {
                    $response .= '<option value="'.$value->F_CITY_NO.'">'.$value->CITY_NAME.'</option>';
                }
            }else{
                $response .= '<option value="">No data found</option>';
            }
        return $response;
    }

    public function getCitybyState($state_id)
    {
         $data = City::select('PK_NO','CITY_NAME')->where('F_STATE_NO',$state_id)->get();
        //  $response = '<option value="">Select City</option>';
         $response = null;

            if ($data) {
                foreach ($data as $value) {
                    $response .= '<option value="'.$value->PK_NO.'">'.$value->CITY_NAME.'</option>';
                }
            }else{
                $response .= '<option value="">No data found</option>';
            }
        return $response;
    }
}
