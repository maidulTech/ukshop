<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Hscode;
use App\Models\Product;
use App\Models\Category;
use App\Models\VatClass;
use App\Models\ProductSize;
use App\Models\SubCategory;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\Admin\ProductVariantRequest;
use App\Repositories\Admin\Product\ProductInterface;


class ProductController extends BaseController
{


    protected $product;
    protected $productModel;
    protected $productInt;
    protected $vatClass;
    protected $category;
    protected $subCategory;
    protected $brand;
    protected $size;
    protected $color;
    protected $hscode;

    public function __construct(
        Product             $product,
        ProductModel        $productModel,
        ProductInterface    $productInt,
        VatClass            $vatClass,
        Category            $category,
        SubCategory         $subCategory,
        Brand               $brand,
        ProductSize         $size,
        Color               $color,
        Hscode              $hscode
    )
    {
        $this->product          = $product;
        $this->productModel     = $productModel;
        $this->productInt       = $productInt;
        $this->vatClass         = $vatClass;
        $this->category         = $category;
        $this->subCategory      = $subCategory;
        $this->brand            = $brand;
        $this->color            = $color;
        $this->size             = $size;
        $this->hscode           = $hscode;
    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->productInt->getPaginatedList($request);
        return view('admin.product.index')->withRows($this->resp->data);
    }


    public function getProductSearch()
    {
        Session::put('list_type', 'searchlist');
        return view('admin.product.search_list');
    }


    public function getCreate()
    {
        $data[]                         = '';
        $data['vat_class_combo']        =  $this->vatClass->getVatClassCombo();
        $data['category_combo']         =  $this->category->getCategorCombo();
        $data['brand_combo']            =  $this->brand->getBrandCombo();
        return view('admin.product.create')->withData($data);
    }

    public function getProdModel($brand_id)
    {
        $prod_model = $this->productModel->getProdModel($brand_id);
        return response()->json($prod_model);

    }

    public function getSubcat($cat_id)
    {
        $sub_cat = $this->subCategory->getSubcateByCategor($cat_id);
        return response()->json($sub_cat);
    }


    public function postStore(ProductRequest $request)
    {
        $this->resp = $this->productInt->postStore($request);
        if ($this->resp->status == true) {
            $pk_no = $this->resp->data;
            return redirect()->route('admin.product.edit',['id' => $pk_no,'type' => 'variant', 'tab' => 2])->with($this->resp->redirect_class, $this->resp->msg);
        }else{
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }

    }

    public function postStoreProductVariant(ProductVariantRequest $request)
    {
        $this->resp = $this->productInt->postStoreProductVariant($request);
        $pk_no = $request->pk_no;
        return redirect()->route('admin.product.edit',['id' => $pk_no,'type' => 'variant', 'tab' => 2])->with($this->resp->redirect_class, $this->resp->msg);
    }




    public function getEdit(Request $request, $id)
    {
        $data[] = '';
        $this->resp = $this->productInt->getShow($id);
        $cat_id     = $this->resp->data->subcategory->category->PK_NO ?? 0;
        $brand_id   = $this->resp->data->F_BRAND ?? 0;
        $subcat_id  = $this->resp->data->subcategory->PK_NO;

        $data['vat_class_combo']    =  $this->vatClass->getVatClassCombo();
        $data['category_combo']     =  $this->category->getCategorCombo();
        $data['subcategory_combo']  =  $this->subCategory->getSubcateByCategor($cat_id, 'list');
        $data['brand_combo']        =  $this->brand->getBrandCombo();
        $data['prod_color_combo']   =  $this->color->getColorCombo($brand_id);

        $data['prod_size_combo']    =  $this->size->getProductSize($brand_id);
        $data['prod_model_combo']   =  $this->productModel->getProdModel($brand_id, 'list');
        $data['hscode_combo']       =  $this->hscode->getHscodeCombo($subcat_id,'list');

        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }

        return view('admin.product.edit')->withProduct($this->resp->data)->withData($data);

    }

    public function getView($id)
    {
        $data[] = '';
        $this->resp = $this->productInt->getShow($id);
        $cat_id     = $this->resp->data->subcategory->category->PK_NO ?? 0;
        $brand_id   = $this->resp->data->F_BRAND ?? 0;

        $data['vat_class_combo']    =  $this->vatClass->getVatClassCombo();
        $data['category_combo']     =  $this->category->getCategorCombo();
        $data['subcategory_combo']  =  $this->subCategory->getSubcateByCategor($cat_id, 'list');
        $data['brand_combo']        =  $this->brand->getBrandCombo();
        $data['prod_color_combo']   =  $this->color->getColorCombo($brand_id);
        $data['prod_size_combo']   =  $this->size->getProductSize($brand_id);
        $data['prod_model_combo']   =  $this->productModel->getProdModel($brand_id, 'list');


        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }

        return view('admin.product.view')->withProduct($this->resp->data)->withData($data);
    }

    public function getDeleteImage($id)
    {
        $this->resp = $this->productInt->deleteImage($id);
        return response()->json($this->resp);
    }

    public function getHscode($subcat_id = null)
    {
        $this->resp = $this->hscode->getHscodeCombo($subcat_id);
        return response()->json($this->resp);
    }

    public function putUpdate(ProductRequest $request, $id)
    {
        $this->resp = $this->productInt->postUpdate($request, $id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function putUpdateProductVariant(ProductVariantRequest $request, $id)
    {
        $this->resp = $this->productInt->postUpdateProductVariant($request, $id);
        return redirect()->route('admin.product.edit',['id' => $request->pk_no,'type' => 'variant', 'tab' => 2])->with($this->resp->redirect_class, $this->resp->msg);
    }


    public function getDelete($id)
    {
        $this->resp = $this->productInt->delete($id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getDeleteProductVariant($id)
    {
        $this->resp = $this->productInt->getDeleteProductVariant($id);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getProductSearchList(Request $request)
    {
        if($request->ajax()){
            $this->resp = $this->productInt->getProductSearchList($request);
            $multiple_select = trim($request->multiple_select);
            $html = view('admin.components._result_rows')->withRows($this->resp->data)->withMultiselect($multiple_select)->render();
            $data['html'] = $html;
            return response()->json($data);

        }else {
             $this->resp = $this->productInt->getProductSearchList($request);
             $data[]                         = '';
             $data['vat_class_combo']        =  $this->vatClass->getVatClassCombo();
             $data['category_combo']         =  $this->category->getCategorCombo();
             $data['brand_combo']            =  $this->brand->getBrandCombo();
             $data['rows']                   =  $this->resp->data;

             return view('admin.product.search_result', compact('data'));
        }




    }


    public function getProductSearchGoBack(Request $request)
    {

        $url = $request->parent_url;
        $queryString = $product_no_arra  =  request()->get('product_no');

       if (empty($url )) {
           return redirect()->back();
       }

       if(empty($queryString)){
            return redirect()->to($url);
       }

        $queryString = http_build_query($queryString,'product_no_');
        $queryString = $url.'?'.$queryString;

        if(!empty($url) && (!empty($product_no_arra))){
            return redirect()->to($queryString);
        }else{
            return redirect()->back();
        }


    }

    public function test(Request $request)
    {

        $data = '';
        return view('admin.product.test')->withData($data);
    }


}
