<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\VendorRequest;
use App\Repositories\Admin\Faulty\FaultyInterface;

class FaultyController extends BaseController
{
    protected $faultyInt;

    public function __construct(FaultyInterface $faultyInt)
    {
        $this->faultyInt       = $faultyInt;
    }

    public function getIndex($type,$id)
    {
        $this->resp = $this->faultyInt->findOrThrowException($type,$id);
        $data       = $this->resp->data;
        if ($type == 'product') {
            return view('admin.faulty.faulty_product')->withData($data);
        }
        return view('admin.faulty.faulty_box')->withData($data);
    }

    public function ajaxFaultyChecker($type,$id,$faulty_type) {

        $data = $this->faultyInt->ajaxFaultyChecker($type,$id,$faulty_type);
        return $data;
    }
}
