<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    protected $table 		= 'ACC_CUST_RES_REFUND_REQUEST';
    protected $primaryKey   = 'PK_NO';
    //public $timestamps      = false;
    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';
    protected $fillable = ['MR_AMOUNT']; 
  

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
