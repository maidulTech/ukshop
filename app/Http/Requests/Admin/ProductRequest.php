<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        $rules = [
            'category'          => 'required|integer|min:1',
            'sub_category'      => 'required|integer|min:1',
            'brand'             => 'required|integer|min:1',
            'prod_model'        => 'required|integer|min:1',
            'name'              => 'required',
           // 'mkt_code'          => 'required',
            // 'price'             => 'required|numeric|between:0,99999.99|regex:/^(?:d*.d{1,2}|d+)$/',
        ];

    // if(request()->pk_no)
    // {
    //     $id = request()->pk_no;
    //     $rules['code']         = 'nullable|unique:PRD_MASTER_SETUP,CODE,'. $id.',PK_NO'; 
    
    // }else{
    //     $rules['code']         = 'nullable|unique:PRD_MASTER_SETUP,CODE,NULL,PK_NO';
    // }


        return $rules;
    }

    public function messages()
    {
        return [
           'category.required'      => 'Please select product category',
           'category.integer'       => 'Please select product category must be nubmber',
           'sub_category.required'  => 'Please select product sub category',
           'sub_category.integer'   => 'Please select product sub category must be nubmber',
           'name.required'          => 'This field is required',
          // 'mkt_code.required'      => 'This field is required',
           // 'price.numeric'          => 'This field is required only numaric value',
         
        ];
    }


}
