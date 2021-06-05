<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table 		= 'ACC_PAYMENT_METHODS';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;
    // const CREATED_AT     = 'create_dttm';
    // const UPDATED_AT     = 'update_dttm';

    protected $fillable = [
        'NAME'
    ];

    public function AccountSource() {
        return $this->belongsTo('App\Models\AccountSource');
    }
}
