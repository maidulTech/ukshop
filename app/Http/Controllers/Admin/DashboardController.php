<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Box;
use App\Models\City;
use App\Models\Brand;
use App\Models\Order;
use App\Models\State;
use App\Models\Stock;
use App\Models\PoCode;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Reseller;
use App\Models\Shipment;
use App\Models\NotifySms;
use App\Models\Warehouse;
use App\Models\AccBankTxn;
use App\Models\ProductModel;
use App\Models\WarehouseZone;
use App\Models\BookingDetails;
use App\Models\PaymentBankAcc;
use App\Models\ProductVariant;
use App\Models\CustomerAddress;
use App\Models\DispatchDetails;
use App\Models\PaymentCustomer;
use App\Models\ShippingAddress;
use App\Models\SmsNotification;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;
use App\Models\Agent;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function __construct()
    {
    }

    public function getIndex() {
        $roles = userRolePermissionArray();
        $agent                                  = Auth::user()->F_AGENT_NO;
        $role_id                                = DB::table('SA_USER_GROUP_USERS')
                                                    ->select('SA_USER_GROUP_ROLE.F_ROLE_NO')
                                                    ->join('SA_USER_GROUP_ROLE','SA_USER_GROUP_ROLE.F_USER_GROUP_NO','SA_USER_GROUP_USERS.F_GROUP_NO')
                                                    ->where('SA_USER_GROUP_USERS.F_USER_NO', Auth::user()->PK_NO)
                                                    ->first();
        $product_master                         = Product::where('IS_ACTIVE',1)->count();
        $product_variant                        = ProductVariant::where('IS_ACTIVE',1)->count();
        $product_model                          = ProductModel::where('IS_ACTIVE',1)->count();
        $product_brand                          = Brand::where('IS_ACTIVE',1)->count();
        $today                                  = Carbon::today()->toDateString();
        $last7days                              = Carbon::now()->subDays(7)->toDateString();
        $last30days                             = Carbon::now()->subDays(30)->toDateString();
        $last30days                             = Carbon::now()->subDays(30)->toDateString();
        $this_month                             = Carbon::now()->month;
        $sticky_note                            = DB::table('SS_STICKY_NOTE')->select('NOTE')->first();

        if ($agent > 0) {
            $customer_count                     = Customer::join('SLS_BOOKING','SLS_BOOKING.F_CUSTOMER_NO','SLS_CUSTOMERS.PK_NO')
                                                            ->select('SLS_BOOKING.PK_NO')
                                                            ->where('SLS_BOOKING.F_BOOKING_SALES_AGENT_NO',$agent)
                                                            ->where('SLS_CUSTOMERS.IS_ACTIVE',1)
                                                            ->groupBy('SLS_BOOKING.F_CUSTOMER_NO')->get();
            $customer_count = $customer_count->count();

            $reseller_count                     = Reseller::join('SLS_BOOKING','SLS_BOOKING.F_RESELLER_NO','SLS_RESELLERS.PK_NO')
                                                            ->select('SLS_BOOKING.PK_NO')
                                                            ->where('SLS_BOOKING.F_BOOKING_SALES_AGENT_NO',$agent)
                                                            ->where('SLS_RESELLERS.IS_ACTIVE',1)
                                                            ->groupBy('SLS_BOOKING.F_RESELLER_NO')->get();
            $reseller_count = $reseller_count->count();
        }else{
            $customer_count                     = Customer::where('IS_ACTIVE',1)->count();
            $reseller_count                     = Reseller::where('IS_ACTIVE',1)->count();
        }
        if(hasAccessAbility('view_dashboard_cards_sales_agent', $roles) || hasAccessAbility('view_dashboard_cards_my_manager', $roles)){

            $order_today                        = 0;
            $order_last7days                    = 0;
            $order_last30days                   = 0;
            $order_RM_value_today               = 0;
            $order_RM_value_7day                = 0;
            $order_RM_value_30day               = 0;
            $order_dispatch_today               = 0;
            $order_dispatch_last7days           = 0;
            $order_dispatch_last30days          = 0;
            $order_dispatch_RM_value_today      = 0;
            $order_dispatch_RM_value_7day       = 0;
            $order_dispatch_RM_value_30day      = 0;
            $arrival_msg_sent_today             = 0;
            $arrival_msg_sent_last7days         = 0;
            $arrival_msg_sent_last30days        = 0;
            $dispatch_msg_sent_today            = 0;
            $dispatch_msg_sent_last7days        = 0;
            $dispatch_msg_sent_last30days       = 0;
            $cod_rtc_today                      = 0;
            $cod_rtc_last7days                  = 0;
            $cod_rtc_last30days                 = 0;
            $rts_today                          = 0;
            $rts_last7days                      = 0;
            $rts_last30days                     = 0;

            $ordered = Booking::select('SLS_BOOKING.RECONFIRM_TIME','SLS_BOOKING.TOTAL_PRICE','SLS_BOOKING.DISCOUNT')
                            ->join('SLS_ORDER','SLS_BOOKING.PK_NO','SLS_ORDER.F_BOOKING_NO')
                            ->where('SLS_BOOKING.RECONFIRM_TIME','>=',$last30days);
                            // ->where('SLS_ORDER.DISPATCH_STATUS','<',40);
                            if ($agent > 0) {
                                $ordered = $ordered->where('SLS_BOOKING.F_BOOKING_SALES_AGENT_NO',$agent);
                            }
                            $ordered = $ordered->groupBy('SLS_BOOKING.PK_NO')
                            ->get();

            foreach ($ordered as $key => $value) {
                if ($value->RECONFIRM_TIME >= $today) {
                    $order_today++;
                    $order_RM_value_today += ($value->TOTAL_PRICE-$value->DISCOUNT);
                }
                if ($value->RECONFIRM_TIME >=  $last7days) {
                    $order_last7days++;
                    $order_RM_value_7day += ($value->TOTAL_PRICE-$value->DISCOUNT);
                }
                if ($value->RECONFIRM_TIME >=  $last30days) {
                    $order_last30days++;
                    $order_RM_value_30day += ($value->TOTAL_PRICE-$value->DISCOUNT);
                }
            }

            $dispatched = Booking::select('SLS_BOOKING.TOTAL_PRICE','SLS_BOOKING.DISCOUNT','SC_ORDER_DISPATCH.DISPATCH_DATE')
                            ->leftjoin('SLS_ORDER','SLS_BOOKING.PK_NO','SLS_ORDER.F_BOOKING_NO')
                            ->leftjoin('SC_ORDER_DISPATCH','SC_ORDER_DISPATCH.F_ORDER_NO','SLS_ORDER.PK_NO')
                            ->where('SC_ORDER_DISPATCH.DISPATCH_DATE','>=',$last30days);
            if ($agent > 0) {
                $dispatched = $dispatched->where('SLS_BOOKING.F_BOOKING_SALES_AGENT_NO',$agent);
            }
            $dispatched = $dispatched->groupBy('SLS_BOOKING.PK_NO')
            ->get();

            foreach ($dispatched as $key => $value) {
                if ($value->DISPATCH_DATE >= $today) {
                    $order_dispatch_today++;
                    $order_dispatch_RM_value_today += ($value->TOTAL_PRICE-$value->DISCOUNT);
                }
                if ($value->DISPATCH_DATE >=  $last7days) {
                    $order_dispatch_last7days++;
                    $order_dispatch_RM_value_7day += ($value->TOTAL_PRICE-$value->DISCOUNT);
                }
                if ($value->DISPATCH_DATE >=  $last30days) {
                    $order_dispatch_last30days++;
                    $order_dispatch_RM_value_30day += ($value->TOTAL_PRICE-$value->DISCOUNT);
                }
            }

            $sent_msg                       = NotifySms::select('TYPE','SEND_AT')->where('IS_SEND',1)->get();
            foreach ($sent_msg as $key => $value) {
                if ($value->SEND_AT >= $today && $value->TYPE == 'Arrival') {
                    $arrival_msg_sent_today++;
                }
                if ($value->SEND_AT >= $last7days && $value->TYPE == 'Arrival') {
                    $arrival_msg_sent_last7days++;
                }
                if ($value->SEND_AT >= $last30days && $value->TYPE == 'Arrival') {
                    $arrival_msg_sent_last30days++;
                }
                if ($value->SEND_AT >= $today && $value->TYPE == 'Dispatch') {
                    $dispatch_msg_sent_today++;
                }
                if ($value->SEND_AT >= $last7days && $value->TYPE == 'Dispatch') {
                    $dispatch_msg_sent_last7days++;
                }
                if ($value->SEND_AT >= $last30days && $value->TYPE == 'Dispatch') {
                    $dispatch_msg_sent_last30days++;
                }
            }

            $cod_rtc_rts = Booking::select('SLS_BOOKING.SS_CREATED_ON','SLS_ORDER.DISPATCH_STATUS','SLS_ORDER.IS_ADMIN_HOLD','IS_READY','SLS_ORDER.IS_SELF_PICKUP','PICKUP_ID')
                            ->leftjoin('SLS_ORDER','SLS_BOOKING.PK_NO','SLS_ORDER.F_BOOKING_NO')
                            ->whereRaw('SLS_ORDER.DISPATCH_STATUS < 40')
                            // ->where('SLS_BOOKING.SS_CREATED_ON','>=',$last30days)
                            ;
            if ($agent > 0) {
                $cod_rtc_rts = $cod_rtc_rts->where('SLS_BOOKING.F_BOOKING_SALES_AGENT_NO',$agent);
            }
            $cod_rtc_rts = $cod_rtc_rts->groupBy('SLS_BOOKING.PK_NO')
            ->get();

            foreach ($cod_rtc_rts as $key => $value) {
                if ($value->DISPATCH_STATUS >= 20 && $value->DISPATCH_STATUS <= 30 && $value->IS_SELF_PICKUP == 0 && $value->IS_ADMIN_HOLD == 0 && $value->PICKUP_ID == 0) {
                    $rts_today++;
                }

                if ($value->IS_READY != 0 && $value->IS_SELF_PICKUP == 1 && $value->IS_ADMIN_HOLD == 0 ) {
                    $cod_rtc_today++;
                }
            }

            $data['order_today']                    = $order_today;
            $data['order_last7days']                = $order_last7days;
            $data['order_last30days']               = $order_last30days;
            $data['order_RM_value_today']           = $order_RM_value_today;
            $data['order_RM_value_7day']            = $order_RM_value_7day;
            $data['order_RM_value_30day']           = $order_RM_value_30day;
            $data['order_dispatch_today']           = $order_dispatch_today;
            $data['order_dispatch_last7days']       = $order_dispatch_last7days;
            $data['order_dispatch_last30days']      = $order_dispatch_last30days;
            $data['order_dispatch_RM_value_today']  = $order_dispatch_RM_value_today;
            $data['order_dispatch_RM_value_7day']   = $order_dispatch_RM_value_7day;
            $data['order_dispatch_RM_value_30day']  = $order_dispatch_RM_value_30day;
            $data['arrival_msg_sent_today']         = $arrival_msg_sent_today;
            $data['arrival_msg_sent_last7days']     = $arrival_msg_sent_last7days;
            $data['arrival_msg_sent_last30days']    = $arrival_msg_sent_last30days;
            $data['dispatch_msg_sent_today']        = $dispatch_msg_sent_today;
            $data['dispatch_msg_sent_last7days']    = $dispatch_msg_sent_last7days;
            $data['dispatch_msg_sent_last30days']   = $dispatch_msg_sent_last30days;
            $data['rts_today']                      = $rts_today;
            $data['rts_last7days']                  = $rts_last7days;
            $data['rts_last30days']                 = $rts_last30days;
            $data['cod_rtc_today']                  = $cod_rtc_today;
            $data['cod_rtc_last7days']              = $cod_rtc_last7days;
            $data['cod_rtc_last30days']             = $cod_rtc_last30days;
        }

        if(hasAccessAbility('view_dashboard_cards_uk_manager', $roles)){

            $purchase_qty_today                     = 0;
            $purchase_qty_last7days                 = 0;
            $purchase_qty_last30days                = 0;
            $purchase_val_today                     = 0;
            $purchase_val_last7days                 = 0;
            $purchase_val_last30days                = 0;
            $purchase_yet_to_claim_vat              = 0;
            $shipment_in_vessel                     = 0;
            $shipment_in_vessel_box_count           = 0;
            $shipment_in_vessel_product_count       = 0;
            $shipment_not_in_vessel                 = 0;
            $shipment_not_in_vessel_box_count       = 0;
            $shipment_not_in_vessel_product_count   = 0;
            $box_not_assigned                       = 0;
            $box_not_assigned_prd_qty               = 0;
            $yet_to_box                             = 0;
            $invoice                                = Invoice::select('INVOICE_DATE','TOTAL_QTY','INVOICE_TOTAL_EV_ACTUAL_GBP','INVOICE_TOTAL_VAT_ACTUAL_GBP','VAT_CLAIMED')
                                                    ->whereDate('INVOICE_DATE','>=',$last30days)
                                                    ->where('F_SS_CURRENCY_NO',1)
                                                    ->get();

            foreach ($invoice as $key => $value) {
                if ($value->INVOICE_DATE >= $today) {
                    $purchase_qty_today += $value->TOTAL_QTY;
                    $purchase_val_today += $value->INVOICE_TOTAL_EV_ACTUAL_GBP;
                }
                if ($value->INVOICE_DATE >= $last7days) {
                    $purchase_qty_last7days += $value->TOTAL_QTY;
                    $purchase_val_last7days += $value->INVOICE_TOTAL_EV_ACTUAL_GBP;
                }
                if ($value->INVOICE_DATE >= $last30days) {
                    $purchase_qty_last30days += $value->TOTAL_QTY;
                    $purchase_val_last30days += $value->INVOICE_TOTAL_EV_ACTUAL_GBP;
                }
                if ($value->VAT_CLAIMED == 0) {
                    $purchase_yet_to_claim_vat += $value->INVOICE_TOTAL_VAT_ACTUAL_GBP;
                }
            }

            $shipment = Shipment::select('PK_NO','SHIPMENT_STATUS','SENDER_BOX_COUNT')->where('SHIPMENT_STATUS','<',80)->get();
            foreach ($shipment as $key => $value) {
                if ($value->SHIPMENT_STATUS == 10) {
                    $shipment_not_in_vessel++;
                    $shipment_not_in_vessel_box_count += $value->SENDER_BOX_COUNT;
                    $shipment_not_in_vessel_product_count += Stock::where('F_SHIPPMENT_NO',$value->PK_NO)->count();
                }
                if ($value->SHIPMENT_STATUS > 10) {
                    $shipment_in_vessel++;
                    $shipment_in_vessel_box_count += $value->SENDER_BOX_COUNT;
                    $shipment_in_vessel_product_count += Stock::where('F_SHIPPMENT_NO',$value->PK_NO)->count();
                }
            }
            $yet_to_box = Stock::whereNull('F_BOX_NO')->where('F_INV_WAREHOUSE_NO',1)->whereRaw('(PRODUCT_STATUS IS NULL OR PRODUCT_STATUS < 420 OR ORDER_STATUS < 80)')->count();

            $unassigned_box = Stock::join('SC_BOX','INV_STOCK.F_BOX_NO','SC_BOX.PK_NO')
                                        ->selectRaw('(IFNULL(COUNT(INV_STOCK.PK_NO),0)) as qty')
                                        ->where('SC_BOX.BOX_STATUS',10)
                                        ->whereNull('F_SHIPPMENT_NO')
                                        ->groupBy('SC_BOX.PK_NO')
                                        ->get();

            foreach ($unassigned_box as $key => $value) {
                $box_not_assigned++;
                $box_not_assigned_prd_qty += $value->qty;
            }

            $data['purchase_qty_today']                 = $purchase_qty_today;
            $data['purchase_qty_last7days']             = $purchase_qty_last7days;
            $data['purchase_qty_last30days']            = $purchase_qty_last30days;
            $data['purchase_val_today']                 = $purchase_val_today;
            $data['purchase_val_last7days']             = $purchase_val_last7days;
            $data['purchase_val_last30days']            = $purchase_val_last30days;
            $data['purchase_yet_to_claim_vat']          = $purchase_yet_to_claim_vat;
            $data['shipment_in_vessel']                 = $shipment_in_vessel;
            $data['shipment_in_vessel_box_count']       = $shipment_in_vessel_box_count;
            $data['shipment_in_vessel_product_count']   = $shipment_in_vessel_product_count;
            $data['shipment_not_in_vessel']             = $shipment_not_in_vessel;
            $data['shipment_not_in_vessel_box_count']   = $shipment_not_in_vessel_box_count;
            $data['shipment_not_in_vessel_product_count'] = $shipment_not_in_vessel_product_count;
            $data['yet_to_box']                         = $yet_to_box;
            $data['box_not_assigned']                   = $box_not_assigned;
            $data['box_not_assigned_prd_qty']           = $box_not_assigned_prd_qty;
        }

        if($role_id->F_ROLE_NO == 1){

            $free_stock_qty                         = 0;
            $free_stock_purchase_price_rm           = 0;
            $free_stock_salses_price_rm             = 0;
            $booked_not_dispatched_price_rm         = 0;
            $top_agent_azura                        = 0;
            $top_agent_huda                         = 0;
            $top_agent_syarifah                     = 0;

            $inv_stock = Stock::select('F_BOOKING_NO','ORDER_STATUS','PRODUCT_PURCHASE_PRICE','REGULAR_PRICE')->whereRaw('(ORDER_STATUS IS NULL OR ORDER_STATUS < 80) AND (PRODUCT_STATUS IS NULL OR PRODUCT_STATUS < 420)')->get();
            foreach ($inv_stock as $key => $value) {
                if ($value->F_BOOKING_NO == null) {
                    $free_stock_qty++;
                    $free_stock_purchase_price_rm += $value->PRODUCT_PURCHASE_PRICE;
                    $free_stock_salses_price_rm += $value->REGULAR_PRICE;
                }
                if ($value->F_BOOKING_NO) {
                    $booked_not_dispatched_price_rm += $value->REGULAR_PRICE;
                }
            }
            $customer_free_credit = Customer::where('IS_ACTIVE',1)->sum('CUM_BALANCE');
            $payment_verfication_pending = AccBankTxn::whereIn('IS_CUS_RESELLER_BANK_RECONCILATION',[1,2])->where('IS_MATCHED',0)->sum('AMOUNT_BUFFER');
            $cod_balance = PaymentBankAcc::where('IS_COD',1)->where('IS_ACTIVE','1')->sum('BALANCE_ACTUAL');
            $sales_pipeline_varified_deposit = Order::where('DISPATCH_STATUS','<',40)->sum('ORDER_ACTUAL_TOPUP');

            $top_agent = Booking::select('BOOKING_SALES_AGENT_NAME','F_BOOKING_SALES_AGENT_NO as agent_no'
                                ,DB::raw('(select ifnull(count(SLS_BOOKING.PK_NO),0) from SLS_BOOKING inner join SLS_ORDER on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING.PK_NO where SLS_BOOKING.F_BOOKING_SALES_AGENT_NO = agent_no and SLS_BOOKING.RECONFIRM_TIME >= "'.$today.'") as today_qty')
                                ,DB::raw('(select ifnull(count(SLS_BOOKING.PK_NO),0) from SLS_BOOKING inner join SLS_ORDER on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING.PK_NO where SLS_BOOKING.F_BOOKING_SALES_AGENT_NO = agent_no and SLS_BOOKING.RECONFIRM_TIME >= "'.$last7days.'") as last7days_qty')
                                ,DB::raw('(select ifnull(count(SLS_BOOKING.PK_NO),0) from SLS_BOOKING inner join SLS_ORDER on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING.PK_NO where SLS_BOOKING.F_BOOKING_SALES_AGENT_NO = agent_no and SLS_BOOKING.RECONFIRM_TIME >= "'.$last30days.'") as last30days_qty')
                                )
                                ->where('RECONFIRM_TIME','>=',$last30days)
                                ->groupBy('F_BOOKING_SALES_AGENT_NO')
                                ->orderBy('last30days_qty','DESC')
                                ->get();
            foreach ($top_agent as $key => $value) {
                $value->this_month = Booking::whereMonth('RECONFIRM_TIME',$this_month)
                ->where('F_BOOKING_SALES_AGENT_NO',$value->agent_no)
                ->groupBy('F_BOOKING_SALES_AGENT_NO')
                ->count();
            }
            $top_reseller = Booking::select('F_RESELLER_NO as reseller_no','RESELLER_NAME'
                                ,DB::raw('(select ifnull(count(SLS_BOOKING.PK_NO),0) from SLS_BOOKING inner join SLS_ORDER on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING.PK_NO where SLS_BOOKING.F_RESELLER_NO = reseller_no and SLS_BOOKING.RECONFIRM_TIME >= "'.$today.'") as today_qty')
                                ,DB::raw('(select ifnull(count(SLS_BOOKING.PK_NO),0) from SLS_BOOKING inner join SLS_ORDER on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING.PK_NO where SLS_BOOKING.F_RESELLER_NO = reseller_no and SLS_BOOKING.RECONFIRM_TIME >= "'.$last7days.'") as last7days_qty')
                                ,DB::raw('(select ifnull(count(SLS_BOOKING.PK_NO),0) from SLS_BOOKING inner join SLS_ORDER on SLS_ORDER.F_BOOKING_NO = SLS_BOOKING.PK_NO where SLS_BOOKING.F_RESELLER_NO = reseller_no and SLS_BOOKING.RECONFIRM_TIME >= "'.$last30days.'") as last30days_qty')
                                )
                                ->where('IS_RESELLER',1)
                                ->where('RECONFIRM_TIME','>=',$last30days)
                                ->groupBy('F_RESELLER_NO')
                                ->orderBy('last30days_qty','DESC')
                                ->get();
            foreach ($top_reseller as $key => $value) {
                $value->this_month = Booking::whereMonth('RECONFIRM_TIME',$this_month)
                ->where('F_RESELLER_NO',$value->reseller_no)
                ->where('IS_RESELLER',1)
                ->groupBy('F_RESELLER_NO')
                ->count();
            }
            $data['free_stock_qty']                     = $free_stock_qty;
            $data['free_stock_purchase_price_rm']       = $free_stock_purchase_price_rm;
            $data['free_stock_salses_price_rm']         = $free_stock_salses_price_rm;
            $data['booked_not_dispatched_price_rm']     = $booked_not_dispatched_price_rm;
            $data['customer_free_credit']               = $customer_free_credit;
            $data['payment_verfication_pending']        = $payment_verfication_pending;
            $data['cod_balance']                        = $cod_balance;
            $data['sales_pipeline_varified_deposit']    = $sales_pipeline_varified_deposit;
            $data['top_agent']                          = $top_agent;
            $data['top_reseller']                       = $top_reseller;
        }

        $data['sticky_note']                            = $sticky_note;
        $data['auth_agent_no']                          = $agent;
        $data['role_id']                                = $role_id->F_ROLE_NO;
        $data['product_master']                         = $product_master;
        $data['product_variant']                        = $product_variant;
        $data['customer_count']                         = $customer_count;
        $data['reseller_count']                         = $reseller_count;
        $data['product_model']                          = $product_model;
        $data['product_brand']                          = $product_brand;

        return view('admin.dashboard.index',compact('data'));
    }

    public function homepage() {
        return view('admin.dashboard.home');
    }

    public function postDashboardNote(Request $request)
    {
        DB::beginTransaction();

        try {
            DB::table('SS_STICKY_NOTE')->update(['NOTE'=>$request->note]);
        } catch (\Exception $e) {
            DB::rollback();
            return 0;
        }
        DB::commit();
        return 1;
    }
}
