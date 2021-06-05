<?php
namespace App\Repositories\Admin\Product;

use App\Models\Product as Product;
use App\Traits\RepoResponse;
use App\Repositories\Admin\Auth\AuthAbstract;
use App\Models\Auth;
use App\Models\AdminUser as User;
use App\Models\ProductVariant;
use App\Models\ProdImgLib;
use App\Models\UserGroup;
use DB;
use Str;
use Image;

class ProductAbstract implements ProductInterface
{
    use RepoResponse;

    protected $user;
    protected $auth;
    protected $product;

    public function __construct(User $user, AuthAbstract $auth, Product $product)
    {
        $this->user = $user;
        $this->auth = $auth;
        $this->product = $product;
    }

    public function getPaginatedList($request, int $per_page = 2000)
    {
        $data = $this->product->where('IS_ACTIVE',1)->orderBy('DEFAULT_NAME','ASC')->get();
        return $this->formatResponse(true, '', 'admin', $data);
    }


    public function postStore($request)
    {

        $brand_name         = null;
        $model_name         = null;
        $default_vat_amount = null;
        $brand = DB::table('PRD_BRAND')->where('PK_NO',$request->brand)->first();
        $model = DB::table('PRD_MODEL')->where('PK_NO',$request->prod_model)->first();
        $vat_class = DB::table('ACC_VAT_CLASS')->where('PK_NO',$request->vat_class)->first();

        if ($brand){ $brand_name = $brand->NAME; }
        if ($model){ $model_name = $model->NAME; }
        if ($vat_class){ $default_vat_amount = $vat_class->RATE; }

        DB::beginTransaction();
        try {
            $prod                                       = new Product();
            $prod->F_PRD_CATEGORY_ID                    = $request->category;
            $prod->F_PRD_SUB_CATEGORY_ID                = $request->sub_category;
            $prod->DEFAULT_NAME                         = $request->name;
            $prod->DEFAULT_CUSTOMS_NAME                 = $request->customs_name;
            $prod->DEFAULT_HS_CODE                      = $request->hs_code;
            $prod->F_BRAND                              = $request->brand;
            $prod->BRAND_NAME                           = $brand_name;
            $prod->F_MODEL                              = $request->prod_model;
            $prod->MODEL_NAME                           = $model_name;
            $prod->DEFAULT_PRICE                        = $request->def_price;
            $prod->DEFAULT_INSTALLMENT_PRICE            = $request->def_price_ins;
            $prod->IS_BARCODE_BY_MFG                    = $request->is_barcode_by_mfg ? 1 : 0;
            $prod->DEFAULT_NARRATION                    = $request->def_narration;
            $prod->F_DEFAULT_VAT_CLASS                  = $request->vat_class;
            $prod->DEFAULT_VAT_AMOUNT_PERCENT           = $default_vat_amount;
            $prod->DEFAULT_AIR_FREIGHT_CHARGE           = $request->def_air_freight;
            $prod->DEFAULT_SEA_FREIGHT_CHARGE           = $request->def_sea_freight;
            $prod->DEFAULT_PREFERRED_SHIPPING_METHOD    = $request->def_shipping_method;
            $prod->DEFAULT_LOCAL_POSTAGE                = $request->def_local_postage;
            $prod->DEFAULT_INTERDISTRICT_POSTAGE        = $request->def_int_postage;
            $prod->PRIMARY_IMG_RELATIVE_PATH            = null;
            $str = strtolower($request->name);
            $prod->URL_SLUG                             = Str::slug($str);
            $prod->NEW_ARRIVAL                          = $request->new_arrival;
            $prod->IS_FEATURE                           = $request->is_feature;
            $prod->MAX_ORDER                            = $request->max_order;
            $prod->META_TITLE                           = $request->meta_title;
            $prod->META_KEYWARDS                        = $request->meta_keywards;
            $prod->META_DESCRIPTION                     = $request->meta_description;


            $prod->save();

            if ($request->file('images')) {
                $i = 0;
                foreach($request->file('images') as $key => $image)
                    {
                        $file_name = 'prod_'. date('dmY'). '_' .uniqid(). '.' . $image->getClientOriginalExtension();

                        $img_lib                    = new ProdImgLib();
                        $img_lib->F_PRD_MASTER_NO   = $prod->PK_NO;
                        $img_lib->IS_MASTER         = 0;
                        $img_lib->F_FILE_TYPE       = 1;
                        $img_lib->FILE_EXT          = $image->getClientOriginalExtension();
                        $img_lib->RELATIVE_PATH     = '/media/images/products/'.$prod->PK_NO.'/'.$file_name;
                        $img_lib->SERIAL_NO         = $i;

                        if($i == 0){
                            $def_relative_path      = '/media/images/products/'.$prod->PK_NO.'/'.$file_name;
                            $img_lib->IS_MASTER     = 1;
                        }
                        $img_lib->save();

                        $image->move(public_path().'/media/images/products/'.$prod->PK_NO.'/', $file_name);
                        $i++;

                    }

                    $update_prod = Product::find($prod->PK_NO);
                    $update_prod->PRIMARY_IMG_RELATIVE_PATH = $def_relative_path ?? null;
                    $update_prod->update();

            }



        } catch (\Exception $e) {

            DB::rollback();
            return $this->formatResponse(false, 'Unable to create product !', 'admin.product.list');
        }

        DB::commit();

        return $this->formatResponse(true, 'Product has been created successfully !', 'admin.product.create',$prod->PK_NO);
    }




    public function postUpdate($request, int $id)
    {
        $brand_name         = null;
        $model_name         = null;
        $default_vat_amount = null;
        $mkt_prefix         = null;
        $brand = DB::table('PRD_BRAND')->where('PK_NO',$request->brand)->first();
        $model = DB::table('PRD_MODEL')->where('PK_NO',$request->prod_model)->first();
        $vat_class = DB::table('ACC_VAT_CLASS')->where('PK_NO',$request->vat_class)->first();

        if ($brand){ $brand_name = $brand->NAME; }
        if ($model){ $model_name = $model->NAME; }
        if ($vat_class){ $default_vat_amount = $vat_class->RATE; }
        // $mkt_composit_code = $mkt_prefix.$request->mkt_code;
        // $result = Product::where(['F_PRD_SUB_CATEGORY_ID' => $request->sub_category,'F_BRAND' => $request->brand, 'F_MODEL' => $request->prod_model])->where('PK_NO', '!=', $id)->first();
        // if($result){
        //     return $this->formatResponse(false, 'Unable to create product because multiple product not allow by same subcategory and same brand and same model and same IG code !', 'admin.product.list');
        // }

        DB::beginTransaction();

        try {

            $prod                                       = Product::find($id);
            $prod->F_PRD_CATEGORY_ID                    = $request->category;
            $prod->F_PRD_SUB_CATEGORY_ID                = $request->sub_category;
            // $prod->MKT_CODE                             = $request->mkt_code;
            // $prod->MKT_ID_COMPOSITE_CODE_PREFIX         = $mkt_prefix.$request->mkt_code;
            $prod->DEFAULT_NAME                         = $request->name;
            $prod->DEFAULT_CUSTOMS_NAME                 = $request->customs_name;
            $prod->DEFAULT_HS_CODE                      = $request->hs_code;
            $prod->F_BRAND                              = $request->brand;
            $prod->BRAND_NAME                           = $brand_name;
            $prod->F_MODEL                              = $request->prod_model;
            $prod->MODEL_NAME                           = $model_name;
            $prod->DEFAULT_PRICE                        = $request->def_price;
            $prod->DEFAULT_INSTALLMENT_PRICE            = $request->def_price_ins;
            $prod->IS_BARCODE_BY_MFG                    = $request->is_barcode_by_mfg ? 1 : 0;
            $prod->DEFAULT_NARRATION                    = $request->def_narration;
            $prod->F_DEFAULT_VAT_CLASS                  = $request->vat_class;
            $prod->DEFAULT_VAT_AMOUNT_PERCENT           = $default_vat_amount;
            $prod->DEFAULT_AIR_FREIGHT_CHARGE           = $request->def_air_freight;
            $prod->DEFAULT_SEA_FREIGHT_CHARGE           = $request->def_sea_freight;
            $prod->DEFAULT_PREFERRED_SHIPPING_METHOD    = $request->def_shipping_method;
            $prod->DEFAULT_LOCAL_POSTAGE                = $request->def_local_postage;
            $prod->DEFAULT_INTERDISTRICT_POSTAGE        = $request->def_int_postage;
            $str                                        = strtolower($request->name);
            $prod->URL_SLUG                             = Str::slug($str);
            $prod->NEW_ARRIVAL                          = $request->new_arrival;
            $prod->IS_FEATURE                           = $request->is_feature;
            $prod->MAX_ORDER                            = $request->max_order;
            $prod->META_TITLE                           = $request->meta_title;
            $prod->META_KEYWARDS                        = $request->meta_keywards;
            $prod->META_DESCRIPTION                     = $request->meta_description;
            $prod->update();

            if ($request->file('images')) {
                $i = 0;
                foreach($request->file('images') as $key => $image)
                    {
                        $file_name = 'prod_'. date('dmY'). '_' .uniqid(). '.' . $image->getClientOriginalExtension();

                        $img_lib                    = new ProdImgLib();
                        $img_lib->F_PRD_MASTER_NO   = $prod->PK_NO;
                        $img_lib->IS_MASTER         = 0;
                        $img_lib->F_FILE_TYPE       = 1;
                        $img_lib->FILE_EXT          = $image->getClientOriginalExtension();
                        $img_lib->RELATIVE_PATH     = '/media/images/products/'.$prod->PK_NO.'/'.$file_name;
                        $img_lib->SERIAL_NO         = $i;

                        if($i == 0){
                            $def_relative_path      = '/media/images/products/'.$prod->PK_NO.'/'.$file_name;
                            $img_lib->IS_MASTER     = 1;
                        }
                        $img_lib->save();



                        $image->move(public_path().'/media/images/products/'.$prod->PK_NO.'/', $file_name);

                        $i++;

                    }

                    $update_prod = Product::find($prod->PK_NO);

                    if ($update_prod->PRIMARY_IMG_RELATIVE_PATH == null) {
                        $update_prod->PRIMARY_IMG_RELATIVE_PATH = $def_relative_path ?? null;
                        $update_prod->update();
                    }


            }


        } catch (\Exception $e) {

            DB::rollback();

            return $this->formatResponse(false, 'Unable to update product !', 'admin.product.list');
        }

        DB::commit();

        return $this->formatResponse(true, 'Product has been updated successfully !', 'admin.product.list');

    }

    public function getShow(int $id)
    {
        $data =  Product::find($id);

        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'admin.product.edit', $data);
        }

        return $this->formatResponse(false, 'Did not found data !', 'admin.product.list', null);
    }

    public function delete(int $id)
    {
        DB::begintransaction();

        try {
            $product = Product::find($id)->delete();

        } catch (\Exception $e) {
            DB::rollback();

            return $this->formatResponse(false, 'Unable to delete product !', 'admin.product.list');
        }

        DB::commit();

        return $this->formatResponse(true, 'Successfully delete product with variant product !', 'admin.product.list');
    }


    public function getProductSearchList($request)
    {

        // $categories = DB::table('PRD_MASTER_SETUP')->whereIn('F_PRD_SUB_CATEGORY_ID', $sub_categories)->get();
        // dd($categories);

        $category       = trim($request->category);
        $sub_category   = trim($request->sub_category);
        $brand          = trim($request->brand);
        $prod_model     = trim($request->prod_model);
        $name           = trim($request->name);
        $vat_class      = trim($request->vat_class);
        $hs_code        = trim($request->hs_code);
        $ig_code        = trim($request->ig_code);
        $sku_id        = trim($request->sku_id);
        $barcode        = trim($request->barcode);
        $shipping_method        = trim($request->preferred_shipping_method);


        $data = ProductVariant::where('PRD_VARIANT_SETUP.IS_ACTIVE', '=', 1)
        ->select('PRD_VARIANT_SETUP.*')
        ->join('PRD_MASTER_SETUP','PRD_MASTER_SETUP.PK_NO','PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO');

        if (!empty($name))
        {
            // $data->orWhere('PRD_VARIANT_SETUP.VARIANT_NAME', 'LIKE', '%' . $name . '%');
            // $data->where('PRD_VARIANT_SETUP.KEYWORD_SEARCH', 'LIKE', '%' . $name . '%');
            // $data->orWhere('PRD_VARIANT_SETUP.BARCODE', 'LIKE', '%' . $name . '%');
            // $data->orWhere('PRD_VARIANT_SETUP.MRK_ID_COMPOSITE_CODE', 'LIKE', '%' . $name . '%');

            $pieces = explode(" ", $name);
            if($pieces){
                foreach ($pieces as $key => $piece) {
                    $data->where('PRD_VARIANT_SETUP.VARIANT_NAME', 'LIKE', '%' . $piece . '%');
                    $data->Where('PRD_VARIANT_SETUP.KEYWORD_SEARCH', 'LIKE', '%' . $piece . '%');
                }
            }
        }


        if (!empty($vat_class))
        {
            $data->where('PRD_VARIANT_SETUP.F_VAT_CLASS', '=', $vat_class );
        }

        if (!empty($vat_class))
        {
            $data->where('PRD_VARIANT_SETUP.F_VAT_CLASS', '=', $vat_class );
        }
        if (!empty($shipping_method))
        {
            $data->where('PRD_VARIANT_SETUP.PREFERRED_SHIPPING_METHOD', '=', $shipping_method );
        }

        if (!empty($hs_code))
        {
            $data->where('PRD_VARIANT_SETUP.HS_CODE', 'LIKE', '%' . $hs_code . '%');
        }

        if (!empty($sub_category))
        {
            $data->where('PRD_MASTER_SETUP.F_PRD_SUB_CATEGORY_ID', '=',$sub_category);

        }elseif (!empty($category))
        {
            $sub_categories = DB::table('PRD_SUB_CATEGORY')->where('F_PRD_CATEGORY_NO',$category)->Pluck('PK_NO');
            if (!empty($sub_categories)) {
                $data->whereIn('PRD_MASTER_SETUP.F_PRD_SUB_CATEGORY_ID',$sub_categories);
            }

        }
        if (!empty($brand)){
            $data->where('PRD_MASTER_SETUP.F_BRAND', '=',$brand);
        }
        if (!empty($prod_model)){
            $data->where('PRD_MASTER_SETUP.F_MODEL', '=',$prod_model);
        }
        if (!empty($ig_code)){
            $data->where('PRD_VARIANT_SETUP.MRK_ID_COMPOSITE_CODE', '=',$ig_code);
        }
        if (!empty($sku_id)){
            $data->where('PRD_VARIANT_SETUP.COMPOSITE_CODE', '=',$sku_id);
        }
        if (!empty($barcode)){
            $data->where('PRD_VARIANT_SETUP.BARCODE', '=',$barcode);
        }





        $data = $data->orderBy('PRD_MASTER_SETUP.DEFAULT_NAME','ASC')->groupBy('PRD_VARIANT_SETUP.PK_NO')->get();

        return $this->formatResponse(true, '', 'admin.product.list', $data);
    }


    // public function getSearchList($request)
    // {
    //     $string = trim($request->search_string);
    //     $data = Auth::where('user_type','!=',1 )
    //             ->where('auths.email', 'LIKE', '%' . $string . '%')->orWhere('auths.username', 'LIKE', '%' . $string . '%')
    //         ->join('admin_users', 'admin_users.auth_id', '=', 'auths.id')
    //         ->join('auth_role', 'auth_role.auth_id', '=', 'auths.id')
    //         ->leftJoin ('roles', 'roles.id', '=', 'auth_role.role_id')
    //         ->leftJoin ('user_groups', 'user_groups.id', '=', 'auth_role.USER_GROUP_ID')
    //         ->select('auths.username','auths.email','auths.mobile_no','auths.can_login','admin_users.first_name','admin_users.last_name','admin_users.designation','admin_users.auth_id','admin_users.profile_pic_url','admin_users.status', 'user_groups.group_name','roles.role_name')->get();
    //     return $this->formatResponse(true, '', 'admin', $data);
    // }


    public function deleteImage(int $id)
    {
        DB::begintransaction();

        try {

            $prod_img = ProdImgLib::find($id);

            if ($prod_img->IS_MASTER == 1) {
                ProdImgLib::where('PK_NO', $id)->delete();
                $product = Product::find($prod_img->F_PRD_MASTER_NO);

                $prod_img = ProdImgLib::where('F_PRD_MASTER_NO', $product->PK_NO)->orderBy('SERIAL_NO','ASC')->first();

                if ($prod_img) {

                    $product->PRIMARY_IMG_RELATIVE_PATH = $prod_img->RELATIVE_PATH;
                    $product->update();

                    $prod_img->IS_MASTER = 1;
                    $prod_img->update();

                }else{
                    $product->PRIMARY_IMG_RELATIVE_PATH = null;
                    $product->update();
                }
            }else{
                ProdImgLib::where('PK_NO', $id)->delete();
            }



        } catch (\Exception $e) {

            DB::rollback();

            return $this->formatResponse(false, 'Unable to delete product photo !', 'admin.product.list');
        }

        DB::commit();

        return $this->formatResponse(true, 'Successfully delete product photo !', 'admin.product.list');
    }



    public function postStoreProductVariant($request)
    {

        $brand_name         = null;
        $model_name         = null;
        $vat_amount         = null;
        $prd_no             = $request->pk_no;
        $color  = DB::table('PRD_COLOR')->where('PK_NO',$request->color)->first();
        $size   = DB::table('PRD_SIZE')->where('PK_NO',$request->size)->first();
        $vat_class = DB::table('ACC_VAT_CLASS')->where('PK_NO',$request->vat_class)->first();
        if ($color){ $color_name = $color->NAME; }

        if ($size){ $size_name = $size->NAME; }
        if ($vat_class){ $vat_amount = $vat_class->RATE; }

        $result = ProductVariant::where(['F_PRD_MASTER_SETUP_NO' => $prd_no,'F_SIZE_NO' => $request->size, 'F_COLOR_NO' => $request->color])->first();

        if($result){
            return $this->formatResponse(false, 'Unable to create product variant because multiple product not allow by same color and same size !', 'admin.product.create');
        }
        DB::beginTransaction();
        try {
            $prod                                       = new ProductVariant();
            $prod->F_PRD_MASTER_SETUP_NO                = $prd_no;
            $prod->VARIANT_NAME                         = $request->name;
            $str                                        = strtolower($request->name);
            $prod->URL_SLUG                             = Str::slug($str);
            $prod->VARIANT_CUSTOMS_NAME                 = $request->customs_name;
            $prod->F_SIZE_NO                            = $request->size;
            $prod->SIZE_NAME                            = $size_name;
            $prod->F_COLOR_NO                           = $request->color;
            $prod->COLOR                                = $color_name;
            $prod->HS_CODE                              = $request->hs_code;
            $prod->BARCODE                              = $request->barcode;
            $prod->IS_BARCODE_BY_MFG                    = $request->is_barcode_by_mfg ? 1 : 0;
            $prod->NARRATION                            = $request->narration;
            $prod->SHORT_NARRATION                      = $request->short_narration;
            $prod->PROMOTIONAL_MESSAGE                  = $request->promotional_message;
            $prod->F_PRIMARY_IMG_VARIANT_ID             = null;
            $prod->PRIMARY_IMG_RELATIVE_PATH            = null;
            $prod->REGULAR_PRICE                        = $request->price;
            $prod->INSTALLMENT_PRICE                    = $request->price_ins;
            $prod->SEA_FREIGHT_CHARGE                   = $request->sea_freight;
            $prod->AIR_FREIGHT_CHARGE                   = $request->air_freight;
            $prod->PREFERRED_SHIPPING_METHOD            = $request->def_shipping_method;
            $prod->LOCAL_POSTAGE                        = $request->local_postage;
            $prod->INTER_DISTRICT_POSTAGE               = $request->int_postage;
            $prod->F_VAT_CLASS                          = $request->vat_class;
            $prod->VAT_AMOUNT_PERCENT                   = $vat_amount;
            $prod->save();

            if ($request->file('images')) {

                $i = 0;
                foreach($request->file('images') as $key => $image)
                    {
                        // $image = $request->file('pro_image');
                        $filename = $image->getClientOriginalExtension();
                        $destinationPath1 = 'media/images/product';
                        $destinationPath2 = 'media/images/product/thumb';
                        if (!file_exists($destinationPath1)) {
                            mkdir($destinationPath1, 0755, true);
                        }
                        if (!file_exists($destinationPath2)) {
                            mkdir($destinationPath2, 0755, true);
                        }
                        $img = Image::make($image->getRealPath());
                        $file_name1 = 'prod_'. date('dmY'). '_' .uniqid().'.'.$filename;
                        $file_name2 = 'prod_'. date('dmY'). '_' .uniqid(). '.webp' ;
                        Image::make($img)->save($destinationPath1.'/'.$file_name1);
                        Image::make($img)->encode('webp', 100)->resize(400, null, function ($constraint) {
                                  $constraint->aspectRatio();
                                 // $constraint->upsize();
                        })->save($destinationPath2.'/'.$file_name2);
                        $image_url = $destinationPath1 .'/'. $file_name1;
                        $thumb_url = $destinationPath2 .'/'. $file_name2;

                        $file_name = 'prod_'. date('dmY'). '_' .uniqid(). '.' . $image->getClientOriginalExtension();
                        $img_lib                    = new ProdImgLib();
                        $img_lib->F_PRD_VARIANT_NO  = $prod->PK_NO;
                        $img_lib->IS_MASTER         = 0;
                        $img_lib->F_FILE_TYPE       = 1;
                        // $img_lib->FILE_EXT          = $image->getClientOriginalExtension();
                        $img_lib->RELATIVE_PATH     = '/'.$image_url;
                        $img_lib->THUMB_PATH        = '/'.$thumb_url;
                        $img_lib->SERIAL_NO         = $i;
                        $img_lib->save();
                        if($i == 0){
                            $def_relative_path      = '/media/images/products/'.$prd_no.'/'.$file_name;
                            $def_relative_id        = $img_lib->PK_NO;
                        }
                        $image->move(public_path().'/media/images/products/'.$prd_no.'/', $file_name);
                        $i++;
                    }
                    $update_prod = ProductVariant::find($prod->PK_NO);
                    $update_prod->F_PRIMARY_IMG_VARIANT_ID = $def_relative_id ?? null;
                    $update_prod->PRIMARY_IMG_RELATIVE_PATH = $def_relative_path ?? null;
                    $update_prod->update();
            }
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return $this->formatResponse(false, 'Product variant not created successfully!', 'admin.product.create');
        }
        DB::commit();
        return $this->formatResponse(true, 'Product variant has been created successfully !', 'admin.product.list');
    }


    public function postUpdateProductVariant($request, int $id)
    {
        $brand_name         = null;
        $model_name         = null;
        $vat_amount         = null;
        $prd_no = $request->pk_no;
        $color = DB::table('PRD_COLOR')->where('PK_NO',$request->color)->first();
        $size = DB::table('PRD_SIZE')->where('PK_NO',$request->size)->first();
        $vat_class = DB::table('ACC_VAT_CLASS')->where('PK_NO',$request->vat_class)->first();
        if ($color){ $color_name = $color->NAME; }
        if ($size){ $size_name = $size->NAME; }
        if ($vat_class){ $vat_amount = $vat_class->RATE; }

        DB::beginTransaction();
        try {
            $prod                                       = ProductVariant::find($id);
            $prod->F_PRD_MASTER_SETUP_NO                = $prd_no;
            $prod->VARIANT_NAME                         = $request->name;
            $str                                        = strtolower($request->name);
            $prod->URL_SLUG                             = Str::slug($str);
            $prod->F_SIZE_NO                            = $request->size;
            $prod->SIZE_NAME                            = $size_name;
            $prod->F_COLOR_NO                           = $request->color;
            $prod->COLOR                                = $color_name;
            $prod->HS_CODE                              = $request->hs_code;
            $prod->BARCODE                              = $request->barcode;
            $prod->IS_BARCODE_BY_MFG                    = $request->is_barcode_by_mfg ? 1 : 0;
            $prod->NARRATION                            = $request->narration;
            $prod->SHORT_NARRATION                      = $request->short_narration;
            $prod->PROMOTIONAL_MESSAGE                  = $request->promotional_message;
            $prod->F_PRIMARY_IMG_VARIANT_ID             = null;
            $prod->PRIMARY_IMG_RELATIVE_PATH            = null;
            $prod->REGULAR_PRICE                        = $request->price;
            $prod->INSTALLMENT_PRICE                    = $request->price_ins;
            $prod->SEA_FREIGHT_CHARGE                   = $request->sea_freight;
            $prod->AIR_FREIGHT_CHARGE                   = $request->air_freight;
            $prod->PREFERRED_SHIPPING_METHOD            = $request->def_shipping_method;
            $prod->LOCAL_POSTAGE                        = $request->local_postage;
            $prod->INTER_DISTRICT_POSTAGE               = $request->int_postage;
            $prod->F_VAT_CLASS                          = $request->vat_class;
            $prod->VAT_AMOUNT_PERCENT                   = $vat_amount;
            $prod->update();

            if ($request->file('images')) {
                $i = 0;
                foreach($request->file('images') as $key => $image)
                    {
                        $file_nam = 'prod_'. date('dmY'). '_' .uniqid(). '.' . $image->getClientOriginalExtension();

                       $filename = $image->getClientOriginalExtension();
                       $destinationPath1 = 'media/images/products/'.$prd_no;
                       $destinationPath2 = 'media/images/products/'.$prd_no.'/thumb';
                       if (!file_exists($destinationPath1)) {
                           mkdir($destinationPath1, 0755, true);
                       }

                       if (!file_exists($destinationPath2)) {
                           mkdir($destinationPath2, 0755, true);
                       }

                    $img = Image::make($image->getRealPath());
                       $file_name1 = 'prod_'. date('dmY'). '_' .uniqid().'.'.$filename;
                       $file_name2 = 'prod_'. date('dmY'). '_' .uniqid(). '.webp' ;
                       Image::make($img)->save($destinationPath1.'/'.$file_name1);
                       Image::make($img)->encode('webp', 100)->resize(400, null, function ($constraint) {
                                 $constraint->aspectRatio();
                                // $constraint->upsize();
                        })->save($destinationPath2.'/'.$file_name2);
                       $image_url = $destinationPath1 .'/'. $file_name1;
                       $thumb_url = $destinationPath2 .'/'. $file_name2;

                        $img_lib                    = new ProdImgLib();
                        $img_lib->F_PRD_VARIANT_NO  = $prod->PK_NO;
                        $img_lib->IS_MASTER         = 0;
                        $img_lib->F_FILE_TYPE       = 1;
                        $img_lib->RELATIVE_PATH     = '/'.$image_url;
                        $img_lib->THUMB_PATH        = '/'.$thumb_url;
                        $img_lib->SERIAL_NO         = $i;
                        $img_lib->save();

                        //$image->move(public_path().'/media/images/products/'.$prd_no.'/', $file_name);

                        if($prod->PRIMARY_IMG_RELATIVE_PATH == null){
                            if($i == 0){
                                $def_relative_path      = $image_url;
                                $def_relative_id        = $img_lib->PK_NO;

                            }
                            $update_prod = ProductVariant::find($id);
                            $update_prod->F_PRIMARY_IMG_VARIANT_ID = $def_relative_id ?? null;
                            $update_prod->PRIMARY_IMG_RELATIVE_PATH = $def_relative_path ?? null;
                            $update_prod->update();
                        }
                        $i++;
                    }
                }else{
                    $img_lib = ProdImgLib::select('RELATIVE_PATH')->where('F_PRD_VARIANT_NO',$id)->where('SERIAL_NO',0)->first();

                    if ($img_lib) {
                        $prod->PRIMARY_IMG_RELATIVE_PATH = $img_lib->RELATIVE_PATH;
                        $prod->update();
                    }
                }
            } catch (\Exception $e) {
                DB::rollback();
                return $this->formatResponse(false, 'Product variant not updated successfully !', 'admin.product.list');
            }

        DB::commit();
        return $this->formatResponse(true, 'Product variant has been updated successfully !', 'admin.product.list');
    }

    public function getDeleteProductVariant(int $id)
    {
        DB::begintransaction();

        try {
            $product = ProductVariant::find($id)->delete();

        } catch (\Exception $e) {
            DB::rollback();

            return $this->formatResponse(false, 'Unable to delete product variant !', 'admin.product.list');
        }

        DB::commit();

        return $this->formatResponse(true, 'Successfully delete product !', 'admin.product.list');
    }






}
