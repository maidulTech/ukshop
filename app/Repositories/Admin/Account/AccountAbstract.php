<?php
namespace App\Repositories\Admin\Account;

use App\Models\AccountSource;
use App\Traits\RepoResponse;
use DB;

class AccountAbstract implements AccountInterface
{
    use RepoResponse;

    protected $account;

    public function __construct(AccountSource $account)
    {
        $this->account = $account;
    }

    public function getPaginatedList($request, int $per_page = 5)
    {
        $data = $this->account->select('PK_NO','NAME','IS_ACTIVE')->where('IS_ACTIVE',1)->orderBy('NAME', 'ASC')->get();
        //dd($data);
        return $this->formatResponse(true, '', 'admin.account.list', $data);
    }

    public function postStore($request)
    {
        //dd($request);
        $check_dup = AccountSource::where('NAME',$request->name)->first();
        if ($check_dup !== null) {
            return $this->formatResponse(false, 'Duplicate entry for Payment Source !', 'admin.account.list');
        }

        DB::beginTransaction();

        try {
            $account                  = new AccountSource();
            $account->NAME            = $request->name;
            $account->IS_ACTIVE       = 1;
            $account->save();

        } catch (\Exception $e) {

            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.account.list');
        }
        DB::commit();

        return $this->formatResponse(true, 'Payment Source has been created successfully !', 'admin.account.list');
    }

    public function postUpdate($request, $PK_NO)
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
}
