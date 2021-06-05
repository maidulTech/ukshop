<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Agent;
use App\Models\PoCode;
use App\Models\Country;
use App\Models\Reseller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ResellerRequest;
use App\Repositories\Admin\Reseller\ResellerInterface;


class ResellerController extends BaseController
{
    protected $reseller;

    public function __construct(ResellerInterface $reseller, Agent $agent, Reseller $resellermodel, Country $country)
    {
        $this->reseller         = $reseller;
        $this->agent            = $agent;
        $this->resellermodel    = $resellermodel;
        $this->country         = $country;
    }

    public function getIndex(Request $request)
    {
        // $this->resp = $this->reseller->getPaginatedList($request, 20);
        return view('admin.reseller.index');
    }

    public function getCreate() {
        $agentCombo    = $this->agent->getAgentCombo();
        $country       = $this->country->getCountryComboWithCode();
        return view('admin.reseller.create')->withAgentCombo($agentCombo)->withCountry($country);
    }

    public function postStore(ResellerRequest $request)
    {
        $this->resp = $this->reseller->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getView(Request $request, $id)
    {
        $this->resp             = $this->reseller->getShow($id);
        $data['agent_combo']    = $this->agent->getAgentCombo();
        $data['country']        = $this->country->getCountryComboWithCode();
        $data['city']           = PoCode::where('PO_CODE',$this->resp->data->POST_CODE)->groupBy('F_CITY_NO')->pluck('CITY_NAME','F_CITY_NO');
        $data['state']          = City::where('PK_NO',$this->resp->data->CITY)->groupBy('F_STATE_NO')->pluck('STATE_NAME','F_STATE_NO');

        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
        return view('admin.reseller.view')->withReseller($this->resp->data)->withData($data);
    }


    public function getEdit(Request $request, $id)
    {
        $this->resp             = $this->reseller->getShow($id);
        $data['agent_combo']    = $this->agent->getAgentCombo();
        $data['country']        = $this->country->getCountryComboWithCode();
        $data['city']           = PoCode::where('PO_CODE',$this->resp->data->POST_CODE)->groupBy('F_CITY_NO')->pluck('CITY_NAME','F_CITY_NO');
        $data['state']          = City::where('PK_NO',$this->resp->data->CITY)->groupBy('F_STATE_NO')->pluck('STATE_NAME','F_STATE_NO');

        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
        return view('admin.reseller.edit')->withReseller($this->resp->data)->withData($data);
    }

    public function postUpdate(ResellerRequest $request, $id)
    {
        $this->resp = $this->reseller->postUpdate($request, $id);

        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getDelete($id)
    {
        $this->resp = $this->reseller->delete($id);

        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

}
