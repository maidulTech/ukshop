<?php
namespace App\Repositories\Admin\Reseller;

use DB;
use App\Models\Customer;
use App\Models\Reseller;
use App\Traits\RepoResponse;
use App\Models\CustomerAddress;

class ResellerAbstract implements ResellerInterface
{
    use RepoResponse;
    protected $reseller;
    public function __construct(Reseller $reseller)
    {
        $this->reseller = $reseller;
    }

    public function getPaginatedList($request, int $per_page = 5)
    {
        $data = $this->reseller->join('SS_COUNTRY','SS_COUNTRY.PK_NO','SLS_RESELLERS.F_COUNTRY_NO')
                                ->select('SLS_RESELLERS.*','SS_COUNTRY.DIAL_CODE')
                                ->where('IS_ACTIVE',1)->orderBy('NAME', 'ASC')->get();
        return $this->formatResponse(true, '', 'admin.reseller.index', $data);
    }

    public function getShow(int $id)
    {
        $data =  Reseller::find($id);

        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'admin.reseller.edit', $data);
        }

        return $this->formatResponse(false, 'Did not found data !', 'admin.reseller.list', null);
    }

    public function postStore($request)
    {
        DB::beginTransaction();

        try {
            $mobile = (int)$request->phone;
            // $check_customer = Customer::where('MOBILE_NO',$mobile)->first();
            $check_reseller = Reseller::where('MOBILE_NO',$mobile)->first();
            // if($check_customer){
            //     return $this->formatResponse(false, 'This mobile no existed in customer table', 'admin.reseller.create');
            // }
            if($check_reseller){
                return $this->formatResponse(false, 'This mobile no existed in reseller table', 'admin.reseller.create');
            }
            $reseller                       = new Reseller();
            $reseller->NAME                 = str_replace("’","'",$request->name);
            $reseller->MOBILE_NO            = $mobile;
            $reseller->ALTERNATE_NO         = $request->alt_phone;
            $reseller->EMAIL                = $request->email;
            $reseller->FB_ID                = $request->fb_id;
            $reseller->IG_ID                = $request->ig_id;
            $reseller->UKSHOP_ID            = $request->uk_id;
            $reseller->UKSHOP_PASS          = bcrypt($request->uk_pass);
            $reseller->DISCOUNT_PERCENTAGE  = $request->discount;
            $reseller->ADDRESS_LINE_1       = $request->address1;
            $reseller->ADDRESS_LINE_2       = $request->address2;
            $reseller->ADDRESS_LINE_3       = $request->address3;
            $reseller->ADDRESS_LINE_4       = $request->address4;
            $reseller->CITY                 = $request->city;
            $reseller->STATE                = $request->state;
            $reseller->POST_CODE            = $request->postcode;
            $reseller->F_COUNTRY_NO         = $request->country;
            $reseller->F_PREFERRED_AGENT_NO = $request->agent;
            $reseller->IS_ACTIVE            = 1;
            $reseller->save();

            $reseller_add                           = new CustomerAddress();
            $reseller_add->NAME                     = str_replace("’","'",$request->name);
            $reseller_add->TEL_NO                   = $mobile;
            $reseller_add->ADDRESS_LINE_1           = $request->address1;
            $reseller_add->ADDRESS_LINE_2           = $request->address2;
            $reseller_add->ADDRESS_LINE_3           = $request->address3;
            $reseller_add->ADDRESS_LINE_4           = $request->address4;
            $reseller_add->F_COUNTRY_NO             = $request->country;
            $reseller_add->STATE                    = $request->state;
            $reseller_add->CITY                     = $request->city;
            $reseller_add->POST_CODE                = $request->postcode;
            $reseller_add->F_ADDRESS_TYPE_NO        = 1;
            $reseller_add->F_RESELLER_NO            = $reseller->PK_NO;
            $reseller_add->IS_ACTIVE                = 1;
            $reseller_add->IS_DEFAULT               = 1;
            $reseller_add->save();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.reseller.list');
        }
        DB::commit();

        return $this->formatResponse(true, 'Reseller has been created successfully !', 'admin.reseller.list');
    }

    public function postUpdate($request, $PK_NO)
    {
        DB::beginTransaction();
            try {

                $reseller                       = Reseller::where('PK_NO', $PK_NO)->first();
                $reseller->NAME                 = str_replace("’","'",$request->name);
                $reseller->MOBILE_NO            = (int)$request->phone;
                $reseller->ALTERNATE_NO         = $request->alt_phone;
                $reseller->EMAIL                = $request->email;
                $reseller->FB_ID                = $request->fb_id;
                $reseller->IG_ID                = $request->ig_id;
                $reseller->UKSHOP_ID            = $request->uk_id;
                $reseller->UKSHOP_PASS          = bcrypt($request->uk_pass);
                $reseller->DISCOUNT_PERCENTAGE  = $request->discount;
                $reseller->ADDRESS_LINE_1       = $request->address1;
                $reseller->ADDRESS_LINE_2       = $request->address2;
                $reseller->ADDRESS_LINE_3       = $request->address3;
                $reseller->ADDRESS_LINE_4       = $request->address4;
                $reseller->CITY                 = $request->city;
                $reseller->STATE                = $request->state;
                $reseller->POST_CODE            = $request->postcode;
                $reseller->F_COUNTRY_NO         = $request->country;
                $reseller->F_PREFERRED_AGENT_NO = $request->agent;
                $reseller->save();

            } catch (\Exception $e) {

                DB::rollback();
                return $this->formatResponse(false, $e->getMessage(), 'admin.reseller.list');
            }

            DB::commit();
            return $this->formatResponse(true, 'Reseller Informstion has been Updated successfully', 'admin.reseller.list');
    }

    public function delete($PK_NO)
    {
        $reseller = Reseller::where('PK_NO',$PK_NO)->first();
        $reseller->IS_ACTIVE = 0;
        if ($reseller->update()) {
            return $this->formatResponse(true, 'Successfully deleted Reseller Account', 'admin.reseller.list');
        }
        return $this->formatResponse(false,'Unable to delete Reseller Account','admin.reseller.list');
    }
}
