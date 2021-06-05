<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Product extends Model
{
    protected $table        = 'PRD_MASTER_SETUP';
    protected $primaryKey   = 'PK_NO';
    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';


    protected $fillable = [
        'F_PRD_SUB_CATEGORY_ID', 'CODE', 'COMPOSITE_CODE', 'DEFAULT_NAME', 'DEFAULT_HS_CODE', 'F_BRAND', 'BRAND_NAME', 'F_MODEL', 'MODEL_NAME', 'DEFAULT_PRICE', 'INSTALLMENT_PRICE'
    ];

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


    public function subcategory() {
        return $this->belongsTo('App\Models\SubCategory', 'F_PRD_SUB_CATEGORY_ID')->where('IS_ACTIVE',1)->orderBy('NAME','ASC');
    }

    public function brand() {
        return $this->belongsTo('App\Models\Brand', 'F_BRAND')->where('IS_ACTIVE',1)->orderBy('NAME','ASC');
    }

    public function productModel() {
        return $this->belongsTo('App\Models\ProductModel', 'F_MODEL')->where('IS_ACTIVE',1)->orderBy('NAME','ASC');
    }

    public function allDefaultPhotos() {
        return $this->hasMany('App\Models\ProdImgLib', 'F_PRD_MASTER_NO');
    }


    public function allVariantsProduct() {
        return $this->hasMany('App\Models\ProductVariant', 'F_PRD_MASTER_SETUP_NO')->where('IS_ACTIVE',1)->orderBy('VARIANT_NAME','ASC');
    }

    public function vatclass() {
        return $this->belongsTo('App\Models\VatClass', 'F_DEFAULT_VAT_CLASS')->where('IS_ACTIVE',1)->orderBy('NAME','ASC');
    }










}
