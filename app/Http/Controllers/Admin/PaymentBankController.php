<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\PaymentBank\PaymentBankInterface;

class PaymentBankController extends BaseController
{
    protected $paymentbank;
    public function __construct(PaymentBankInterface  $paymentbank )
    {
        $this->paymentbank         = $paymentbank;

    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->paymentbank->getPaginatedList($request, 50);
        return view('admin.paymentbank.index')->withRows($this->resp->data);
    }

    public function getCreate()
    {
        return view('admin.paymentbank.create');
    }

    public function postStore(Request $request)
    {
        $this->resp = $this->paymentbank->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    // public function putUpdate(AccountRequest $request, $PK_NO) {

    //     $this->resp = $this->account->postUpdate($request, $PK_NO);

    //     return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    // }

    // public function getDelete($PK_NO) {

    //     $this->resp = $this->account->delete($PK_NO);

    //     return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    // }

}
