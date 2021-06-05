<?php
namespace App\Repositories\Admin\PaymentBank;

use App\Models\PaymentBankAcc;
use App\Traits\RepoResponse;
use DB;

class PaymentBankAbstract implements PaymentBankInterface
{
    use RepoResponse;

    protected $account;

    public function __construct(PaymentBankAcc $account)
    {
        $this->account = $account;
    }

    public function getPaginatedList($request, int $per_page = 5)
    {
        $data = $this->account->where('IS_ACTIVE',1)->orderBy('BANK_NAME', 'ASC')->get();
        //dd($data);
        return $this->formatResponse(true, '', 'admin.payment_bank.list', $data);
    }

    public function postStore($request)
    {


        DB::beginTransaction();

        try {
            $account                  = new PaymentBankAcc();
            $account->BANK_NAME       = $request->bank_name;
            $account->BANK_ACC_NAME   = $request->bank_acc_name;
            $account->BANK_ACC_NO     = $request->bank_acc_no;
            $account->IS_ACTIVE       = 1;
            $account->save();

        } catch (\Exception $e) {

            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.payment_bank.list');
        }
        DB::commit();

        return $this->formatResponse(true, 'Payment account has been created successfully !', 'admin.payment_bank.list');
    }

   /* public function postUpdate($request, $PK_NO)
    {
        $check_dup = AccountSource::where('NAME',$request->name)->first();
        if ($check_dup !== null) {
            return $this->formatResponse(false, 'Duplicate entry for Payment Source !', 'admin.account.list');
        }

        $accSource = AccountSource::where('PK_NO', $PK_NO)->first();
        $accSource->NAME = $request->name;

        // $accSource->F_PRD_BRAND_NO = $request->brand;

        if ($accSource->update()) {
            return $this->formatResponse(true, 'Payment Source has been Updated successfully', 'admin.account.list');
        }

        return $this->formatResponse(false, 'Unable to update Payment Source !', 'admin.account.list');
    }

    public function delete($PK_NO)
    {
        $accSource = AccountSource::where('PK_NO',$PK_NO)->first();
        $accSource->IS_ACTIVE = 0;
        if ($accSource->update()) {
            return $this->formatResponse(true, 'Successfully deleted Payment Source', 'admin.account.list');
        }
        return $this->formatResponse(false,'Unable to delete Payment Source','admin.account.list');
    }
    */
}
