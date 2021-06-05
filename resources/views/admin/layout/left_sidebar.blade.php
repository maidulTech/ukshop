<ul class="navigation navigation-main mt-1" id="main-menu-navigation" data-menu="menu-navigation">
    <li class=" nav-item @yield('dashboard')">
        <a href="{{ route('admin.dashboard')}}"><i class="la la-dashboard"></i><span class="menu-title" data-i18n="@lang('left_menu.dashboard')">@lang('left_menu.dashboard')</span></a>
    </li>
    <li class=" navigation-header"><span data-i18n="Modules">Modules</span><i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Modules" ></i>
    </li>

    @if(hasAccessAbility('view_product', $roles))
    <li class=" nav-item @yield('Product Management')">
        <a href="#"><i class="fas fa-box-open"></i></i><span class="menu-title" data-i18n="@lang('left_menu.product')">@lang('left_menu.products')</span></a>
        <ul class="menu-content">
            @if(hasAccessAbility('view_product_list', $roles))
            <li class="@yield('product_search_list')"><a class="menu-item" href="{{route('admin.product.searchlist')}}"><i></i><span data-i18n="@lang('left_menu.product_search_list')">@lang('left_menu.product_search_list')</span></a></li>
            @endif
            @if(hasAccessAbility('view_product', $roles))
            <li class="nav-item @yield('product_list')"><a class="menu-item" href="{{ route('admin.product.list') }}"><i></i><span data-i18n="@yield('product_list')">@lang('left_menu.product list')</span></a></li>
            @endif

            @if(hasAccessAbility('view_category', $roles))
            <li class="@yield('product category')"><a class="menu-item" href="{{route('product.category.list')}}"><i></i><span data-i18n="@yield('product category')">@lang('left_menu.category')</span></a></li>
            @endif

            @if(hasAccessAbility('view_brand', $roles))
            <li class="@yield('product brand')"><a class="menu-item" href="{{route('product.brand.list')}}"><i></i><span data-i18n="@lang('left_menu.brand')">@lang('left_menu.product_brand')</span></a></li>
            @endif
            @if(hasAccessAbility('view_product', $roles))
            <li class="@yield('product sub-category')"><a class="menu-item" href="{{route('admin.sub_category.list')}}"><span data-i18n="Basic">@lang('left_menu.sub_category')</span></a></li>
            @endif
        </ul>
    </li>
    @endif
    @if(hasAccessAbility('view_invoice', $roles))
    <li class=" nav-item @yield('Procurement')">
        <a href="#"><i class="far fa-clipboard"></i>
            <span class="menu-title" data-i18n="@yield('Procurement')">@lang('left_menu.procurement')</span>
        </a>
        <ul class="menu-content">
            <li class="@yield('vendor')">
                <a class="menu-item" href="{{route('admin.vendor')}}"><i></i>
                    <span data-i18n="@yield('vendor')">@lang('left_menu.vendor')</span>
                </a>
            </li>
            <li class="@yield('invoice')">
                <a class="menu-item" href="{{route('admin.invoice')}}"><i></i>
                <span data-i18n="@yield('invoice')">@lang('left_menu.invoice')</span>
                </a>
            </li>
            <li class="@yield('stock_processing')">
                <a class="menu-item" href="{{route('admin.invoice_processing')}}"><i></i>
                <span data-i18n="@yield('stock_processing')">@lang('left_menu.stock_processing')</span>
                </a>
            </li>
            <li class="@yield('vat_processing')">
                <a class="menu-item" href="{{route('admin.vat_processing')}}"><i></i>
                <span data-i18n="@yield('vat_processing')">@lang('left_menu.vat_processing')</span>
                </a>
            </li>
            <li class=" nav-item @yield('payment_processing')"><a class="menu-item" href="{{ route('admin.payment_processing.list') }}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_processing')</span></a></li>
        </ul>
    </li>
    @endif
    @if(hasAccessAbility('view_warehouse_section', $roles))
    <li class="nav-item  @yield('Warehouse Operation')"><a href="#"><i class="fas fa-tasks"></i><span class="menu-title" data-i18n="@lang('left_menu.customer')">Warehouse</span></a>

        <ul class="menu-content">
            @if(hasAccessAbility('view_warehouse_stock', $roles))
            <li class="@yield('product_list_')">
                <a class="menu-item" href="{{route('admin.all_product.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.product_list_')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_warehouse_unshelved', $roles))
            <li class="@yield('unshelved_list')">
                <a class="menu-item" href="{{route('admin.unshelved.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.unshelved_list')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_warehouse_shelved', $roles))
            <li class="@yield('shelve_list')">
                <a class="menu-item" href="{{route('admin.shelve.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.shelve_list')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_warehouse_boxed', $roles))
            <li class="@yield('box_list')">
                <a class="menu-item" href="{{route('admin.box.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.box_list')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_box_type', $roles))
            <li class="@yield('box_type_list')">
                <a class="menu-item" href="{{route('admin.box_type.list')}}"><i></i>
                    <span data-i18n="">Box Type</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_warehouse_notboxed', $roles))
            <li class="@yield('not_box_list')">
                <a class="menu-item" href="{{route('admin.not_box.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.not_box_list')</span>
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif
    @if(hasAccessAbility('view_shipment_section', $roles))
    <li class=" nav-item @yield('Shipping')">
        <a href="#"><i class="fas fa-shipping-fast"></i></i>
            <span class="menu-title" data-i18n="@yield('Shipping')">@lang('left_menu.shipping')</span>
        </a>
        <ul class="menu-content">

            {{-- <li class="@yield('add_shipping')">
                <a class="menu-item" href="{{route('admin.shipment.create')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.add_shipping')</span>
                </a>
            </li> --}}
            <li class="@yield('list_shipping')">
                <a class="menu-item" href="{{route('admin.shipment.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.list_shipping')</span>
                </a>
            </li>
            <li class="@yield('processing_shipping')">
                <a class="menu-item" href="{{route('admin.shipment.processing')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.processing_shipping')</span>
                </a>
            </li>
            <li class="@yield('shipping_address')">
                <a class="menu-item" href="{{route('admin.shipping-address.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.shipping_address')</span>
                </a>
            </li>
            <li class="@yield('shipment_sign')">
                <a class="menu-item" href="{{ route('admin.shipment-signature.list') }}"><i></i>
                    <span data-i18n="">@lang('left_menu.shipment_sign')</span>
                </a>
            </li>
        </ul>
    </li>
    @endif
    @if(hasAccessAbility('view_customer', $roles))
    <li class="nav-item  @yield('Customer Management')"><a href="#"><i class="fas fa-users-cog"></i><span class="menu-title" data-i18n="@lang('left_menu.customer')">Customers</span></a>
        <ul class="menu-content">
            {{-- <li class="@yield('add_customer')"><a class="menu-item" href="{{route('admin.customer.create')}}"><i></i><span data-i18n="@lang('left_menu.add_customer')r">Add Customer</span></a></li> --}}
            @if(hasAccessAbility('view_customer', $roles))
            <li class="@yield('customer_list')"><a class="menu-item" href="{{route('admin.customer.list')}}"><i></i><span data-i18n="@lang('left_menu.customer_list')">@lang('left_menu.customer_list')</span></a></li>
            @endif
            {{-- <li class="@yield('reseller_add')"><a class="menu-item" href="{{route('admin.reseller.create')}}"><i></i><span data-i18n="@lang('left_menu.reseller_list')">@lang('left_menu.add_reseller')</span></a></li> --}}
            @if(hasAccessAbility('view_reseller', $roles))
            <li class="@yield('reseller_list')"><a class="menu-item" href="{{route('admin.reseller.list')}}"><i></i><span data-i18n="@lang('left_menu.reseller_list')">@lang('left_menu.reseller_list')</span></a></li>
            @endif

        </ul>
    </li>
    @endif
    @if(hasAccessAbility('view_order', $roles))
    <li class=" nav-item @yield('Order Management')"><a href="#"><i class="fas fa-cart-plus"></i><span class="menu-title" data-i18n="@lang('left_menu.order_management')">Orders</span></a>
        <ul class="menu-content">
            @if(hasAccessAbility('new_search_booking', $roles))
            <li class="@yield('new_search_booking')"><a class="menu-item" href="{{route('admin.booking.search_create')}}"><i></i><span data-i18n="@yield('new_search_booking')">Search & Book</span></a></li>
            @endif
            @if(hasAccessAbility('view_booking', $roles))
            <li class="@yield('booking_list')"><a class="menu-item" href="{{ route('admin.booking.list') }}"><span data-i18n="@yield('booking_list')">@lang('left_menu.booking_list')</span></a></li>
            @endif
            @if(hasAccessAbility('view_order', $roles))
            <li class="@yield('list_order')"><a class="menu-item" href="{{route('admin.order.list')}}"><i></i><span data-i18n="@yield('list_order')">Order List</span></a></li>
            @endif
            @if(hasAccessAbility('view_order', $roles))
            <li class="@yield('list_altered_order')"><a class="menu-item" href="{{route('admin.order_alter.list')}}"><i></i><span data-i18n="@yield('list_order')">Awaiting Approval</span></a></li>
            @endif
            @if(hasAccessAbility('view_order', $roles))
            <li class="@yield('list_default_order')"><a class="menu-item" href="{{route('admin.order_default.list')}}"><i></i><span data-i18n="@yield('list_default_order')">Default & Cancel Order</span></a></li>
            @endif
        </ul>
    </li>
    @endif
    @if(hasAccessAbility('view_payment_section', $roles))
    <li class="nav-item @yield('Payment')">
        <a href="#"><i class="la la-paypal"></i><span class="menu-title" data-i18n="Calendars">@lang('left_menu.payment')</span></a>
        <ul class="menu-content">
            @if(hasAccessAbility('view_payment', $roles))
            <li class=" nav-item @yield('payment_list')"><a class="menu-item" href="{{ route('admin.payment.list') }}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_list')</span></a></li>
            @endif
            {{-- <li class=" nav-item @yield('payment_entry')"><a class="menu-item" href="{{ route('admin.payment.create') }}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_entry')</span></a></li> --}}
            @if(hasAccessAbility('view_bank_state', $roles))
            <li class=" nav-item @yield('bankstatement')"><a class="menu-item" href="{{ route('admin.bankstate.list') }}"><i></i><span data-i18n="Basic">@lang('left_menu.bankstatement')</span></a></li>
            @endif

            @if(hasAccessAbility('edit_bank_state', $roles))
            <li class=" nav-item @yield('payment_verification')"><a class="menu-item" href="{{ route('admin.bankstate.verification') }}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_verification')</span></a></li>
            @endif
            @if(hasAccessAbility('view_bank_to_other', $roles))
            <li class="@yield('bank_to_other_xfer')"><a class="menu-item" href="{{route('admin.account_to_other_list.view')}}"><i></i><span data-i18n="@yield('bank_to_other_xfer')">Third Party Payments</span></a></li>
            @endif
            @if(hasAccessAbility('view_bank_to_bank', $roles))
            <li class="@yield('bank_to_bank_xfer')"><a class="menu-item" href="{{route('admin.account_to_bank_list.view')}}"><i></i><span data-i18n="@yield('bank_to_bank_xfer')">Internal Transfer</span></a></li>
            @endif
            @if(hasAccessAbility('view_refund', $roles))
            <li class="nav-item @yield('view_refund')"><a class="menu-item" href="{{ route('admin.customer.refund') }}"><i></i><span data-i18n="Basic">Refund</span></a></li>
            @endif
        </ul>
    </li>
    @endif


    @if(hasAccessAbility('view_dispatch_management', $roles))
    <li class=" nav-item @yield('Dispatch Management')"><a href="#"><i class="la la-truck"></i><span class="menu-title" data-i18n="@lang('left_menu.dispatch_management')">Dispatch</span></a>
        <ul class="menu-content">
            @if(hasAccessAbility('view_dispatch', $roles))
            <li class="@yield('list_dispatch')"><a class="menu-item" href="{{route('admin.dispatch.list',['dispatch' => 'rts'])}}"><i></i><span data-i18n="@yield('list_dispatch')">Dispatch List</span></a></li>
            @endif
            @if(hasAccessAbility('view_notify_sms', $roles))
            <li class="@yield('notify_sms')"><a class="menu-item" href="{{route('admin.notify_sms.list')}}"><span data-i18n="@yield('notify_sms')">Notification SMS</span></a></li>
            @endif
            @if(hasAccessAbility('view_batch_collected', $roles))
            <li class="@yield('view_batch_list_collected')"><a class="menu-item" href="{{route('admin.batch_collected.list')}}"><span data-i18n="@yield('view_batch_list_collected')">RTS Batch List</span></a></li>
            @endif
            @if(hasAccessAbility('view_pending_app_dispach', $roles))
            <li class="@yield('view_pending_app_dispach')"><a class="menu-item" href="{{route('admin.pending_by_app.dispatch-list')}}"><span data-i18n="@yield('view_pending_app_dispach')">Pending App Dispatch</span></a></li>
            @endif
            @if(hasAccessAbility('view_dispatched', $roles))
            <li class="@yield('dispatched_list')"><a class="menu-item" href="{{route('admin.dispatched.list')}}"><span data-i18n="@yield('dispatched_list')">Dispatched List</span></a></li>
            @endif
            {{-- @if(hasAccessAbility('view_order_collect', $roles))
            <li class="@yield('order_collect_list')"><a class="menu-item" href="{{route('admin.order_collect.list')}}"><span data-i18n="@yield('order_collect_list')">Order Collect List</span></a></li>
            @endif --}}
            {{-- @if(hasAccessAbility('view_batch_collect', $roles))
            <li class="@yield('view_batch_list')"><a class="menu-item" href="{{route('admin.batch_collect.list')}}"><span data-i18n="@yield('view_batch_list')">RTS Batch List</span></a></li>
            @endif --}}
        </ul>
    </li>
    @endif
    {{-- <li class=" nav-item"><a href="{{route('product.inventory.list')}}"><i class="la la-calendar"></i><span class="menu-title" data-i18n="Calendars">@lang('left_menu.inventory')</span></a>
    </li> --}}
    @php
    $role_id = \DB::table('SA_USER_GROUP_USERS')
                ->join('SA_USER_GROUP_ROLE','SA_USER_GROUP_ROLE.F_USER_GROUP_NO','SA_USER_GROUP_USERS.F_GROUP_NO')
                ->where('SA_USER_GROUP_USERS.F_USER_NO', \Auth::user()->PK_NO)
                ->first();
    @endphp
    @if($role_id->F_ROLE_NO == 1)
    <li class=" nav-item @yield('offer_management')">
        <a href="#"><i class="fas fa-gifts"></i>
            <span class="menu-title" data-i18n="@yield('offer_management')">@lang('left_menu.offer_management')</span>
        </a>
        <ul class="menu-content">
            <li class="@yield('offer_list')">
                <a class="menu-item" href="{{route('admin.offer.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.offer_list')</span>
                </a>
            </li>
            <li class="@yield('offer_primary_list')">
                <a class="menu-item" href="{{route('admin.offer_primary.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.offer_primary_list')</span>
                </a>
            </li>
            <li class="@yield('offer_secondary_list')">
                <a class="menu-item" href="{{route('admin.offer_secondary.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.offer_secondary_list')</span>
                </a>
            </li>
            <li class="@yield('offer_type')">
                <a class="menu-item" href="{{route('admin.offer_type.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.offer_type')</span>
                </a>
            </li>
        </ul>
    </li>
    @endif
    @if(hasAccessAbility('view_sales_report_section', $roles))
    <li class="nav-item  @yield('Sales Report')"><a href="#"><i class="ft-bar-chart"></i><span class="menu-title" data-i18n="@lang('left_menu.customer')">Reports</span></a>
        <ul class="menu-content">
            @if(hasAccessAbility('view_sales_report', $roles))
            <li class="@yield('sales_report')">
                <a class="menu-item" href="{{route('admin.sales_report.list')}}"><i></i>
                    <span data-i18n="">Sales Comission</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_collection_list', $roles))
            <li class="@yield('view_bank_collection')"><a class="menu-item" href="{{route('admin.collection.list')}}"><span data-i18n="@yield('view_bank_collection')">COD payment Position</span></a></li>
            @endif
            @if(hasAccessAbility('yet_to_ship', $roles))
            <li class="@yield('yet_to_ship')"><a class="menu-item" href="{{route('admin.yet_to_ship.list')}}"><span data-i18n="@yield('yet_to_ship')">Yet to Ship</span></a></li>
            @endif
        </ul>
    </li>
    @endif
    <li class=" navigation-header"><span data-i18n="Settings">Settings</span><i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Settings" ></i>
    </li>
    @if(hasAccessAbility('view_admin_user', $roles))
        <li class=" nav-item @yield('Admin Mangement')">
            <a href="#">
                <i class="ft-users"></i>
                <span class="menu-title"
                      data-i18n="@lang('left_menu.admin_management')">@lang('left_menu.admin_management')</span>
            </a>
            <ul class="menu-content">
                @if(hasAccessAbility('view_admin_user', $roles))
                    <li class="@yield('admin-user')">
                        <a href="{{ route('admin.admin-user') }}">
                            <span class="menu-title"
                                  data-i18n="@lang('left_menu.admin_user')">@lang('left_menu.admin_user')</span>
                        </a>
                    </li>
                @endif
                @if(hasAccessAbility('view_user_group', $roles))
                    <li class=" nav-item @yield('user-group')">
                        <a href="{{ route('admin.user-group') }}">
                            <span class="menu-title" data-i18n="@lang('left_menu.user_category')">@lang('left_menu.user_category')</span>
                        </a>
                    </li>
                @endif
                @if(hasAccessAbility('view_agent', $roles))
                <li class="@yield('agent_list')"><a class="menu-item" href="{{route('admin.agent.list')}}"><i></i><span data-i18n="Basic">@lang('left_menu.agent_list')</span></a></li>
                @endif
            </ul>
        </li>
    @endif
    @if(hasAccessAbility('view_role', $roles))
        <li class=" nav-item @yield('Role Management')">
            <a href="#">
                <i class="la la-user-plus"></i>
                <span class="menu-title"
                      data-i18n="@lang('left_menu.role_management')">@lang('left_menu.role_management')</span>
            </a>
            <ul class="menu-content">
                @if(hasAccessAbility('view_role', $roles))
                    <li class="@yield('role')">
                        <a class="menu-item" href="{{ route('admin.role') }}">
                            <i></i>
                            <span data-i18n="@lang('left_menu.role')">@lang('left_menu.role')</span>
                        </a>
                    </li>
                @endif
                @if(hasAccessAbility('view_menu', $roles))
                    <li class="@yield('permission-group')">
                        <a class="menu-item" href="{{ route('admin.permission-group') }}">
                            <i></i>
                            <span data-i18n="@lang('left_menu.menus')">@lang('left_menu.menus')</span>
                        </a>
                    </li>
                @endif
                @if(hasAccessAbility('view_action', $roles))
                    <li class="@yield('permission')"><a class="menu-item" href="{{ route('admin.permission') }}"><i></i><span
                                data-i18n="@lang('left_menu.actions')">@lang('left_menu.actions')</span></a>
                    </li>
                @endif
                @if(hasAccessAbility('assign_user_access', $roles))
                    <li class=" nav-item @yield('assign-access')">
                        <a href="{{ route('admin.assign-access') }}">
                            <span class="menu-title" data-i18n="@lang('left_menu.assign_access')">@lang('left_menu.assign_access')</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    @if(hasAccessAbility('view_account_name', $roles))
    <li class=" nav-item @yield('Accounts')">
        <a href="#"><i class="fas fa-money-check"></i><span class="menu-title" data-i18n="Calendars">@lang('left_menu.account')</span></a>
        <ul class="menu-content">
            <li class=" nav-item @yield('Payment Management')"><a class="menu-item" href="{{route('admin.account.list')}}"><i></i><span data-i18n="Basic">@lang('left_menu.account list')</span></a></li>

            <li class=" nav-item @yield('payment_bank')"><a class="menu-item" href="{{route('admin.payment_bank.list')}}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_bank')</span></a></li>

            {{-- <li><a class="menu-item" href="#"><i></i><span data-i18n="Basic">@lang('left_menu.others')</span></a>
                <ul class="menu-content">
                    <li class="@yield('vat')"><a class="menu-item" href="#!"><i></i><span data-i18n="Basic">@lang('left_menu.Vat')</span></a></li>
                    <li class="@yield('Account Name')"><a class="menu-item" href="#!"><i></i><span data-i18n="Basic">@lang('left_menu.Name')</span></a></li>
                    <li class="@yield('product model')"><a class="menu-item" href="#!"><i></i><span data-i18n="Extra">@lang('left_menu.Method')</span></a></li>
                </ul>
            </li> --}}
        </ul>
    </li>
    @endif
    @if(hasAccessAbility('view_system_settings', $roles))
        <li class=" nav-item @yield('System Settings')">
            <a href="#">
                <i class="la la-cogs"></i>
                <span class="menu-title"
                      data-i18n="@lang('left_menu.system_settings')">@lang('left_menu.system_settings')</span>
            </a>
            <ul class="menu-content">
                <li class="@yield('city_list')"><a class="menu-item" href="{{route('admin.address_type.city_list_')}}"><i></i><span data-i18n="Basic">City List</span></a>
                </li>
                <li class="@yield('postage_list')"><a class="menu-item" href="{{route('admin.address_type.postage_list_')}}"><i></i><span data-i18n="Basic">Postage List</span></a>
                </li>
                <li class=" nav-item @yield('currency')"><a class="menu-item" href="{{ route('admin.currency.list') }}"><i></i><span data-i18n="Basic">@lang('left_menu.currency')</span></a></li>
                @if(hasAccessAbility('view_address_type', $roles))
                <li class="@yield('address_type')"><a class="menu-item" href="{{route('admin.address_type.list')}}"><i></i><span data-i18n="@lang('left_menu.address_type')">@lang('left_menu.address_type')</span></a></li>
                @endif
            </ul>
        </li>
    @endif
    @if(Auth::user()->PK_NO == 1)
    <li class=" nav-item @yield('web')">
        <a href="#"><i class="la la-cog"></i>
            <span class="menu-title" data-i18n="@yield('web')">Web</span>
        </a>
        <ul class="menu-content">
            <li class="@yield('slider')">
                <a class="menu-item" href="{{route('web.home.slider')}}"><i></i>
                    <span data-i18n="">Home Slider</span>
                </a>
            </li>
        </ul>
        <ul class="menu-content">
            <li class="@yield('blog-category')">
                <a class="menu-item" href="{{route('web.blog.category')}}"><i></i>
                    <span data-i18n="@yield('blog-category')">Blog Category</span>
                </a>
            </li>
            <li class="@yield('blog-article')">
                <a class="menu-item" href="{{route('web.blog.article')}}"><i></i>
                    <span data-i18n="@yield('blog-article')">Blog Article</span>
                </a>
            </li>
            <li class="@yield('pages')">
                <a class="menu-item" href="{{route('web.page')}}"><i></i>
                    <span data-i18n="@yield('pages')">Pages</span>
                </a>
            </li>
            <li class="@yield('faq')">
                <a class="menu-item" href="{{route('web.faq')}}"><i></i>
                    <span data-i18n="@yield('faq')">Faq</span>
                </a>
            </li>
            <li class="@yield('about')">
                <a class="menu-item" href="{{route('web.about')}}"><i></i>
                    <span data-i18n="@yield('about')">About</span>
                </a>
            </li>
            {{-- <li class="@yield('mail')">
                <a class="menu-item" href="{{route('web.mail.index')}}"><i></i>
                    <span data-i18n="@yield('mail')">Email Config</span>
                </a>
            </li> --}}
        </ul>


    </li>
    @endif
</ul>
