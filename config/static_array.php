<?php
return [
	'booking_validity' => [
		24 => '24 Hours',
		48 => '48 Hours',
		74 => '74 Hours',
		96 => '96 Hours'
    ],
    'shipping_status' => [
        00 => 'Not Shipped',
        10 => 'In Progress at Source',
        20 => 'Collected by Shipping Agent at Source',
        30 => 'Cancelled',
        40 => 'With Shipping Line (Departure Country)',
        50 => 'With Shipping Line (In Transit)',
        60 => 'With Shipping Line (Arrival Country)',
        70 => 'Shipping Arrived At Destination Receiving Agent',
        // 80 => 'Shipping Arrived At Destination Warehouse',
        // 90 => 'Unboxing Finished',
        // 100 => 'Shipment Complete'
    ],

    'shipping_status2' => [
        00 => 'Not Shipped',
        10 => 'In Progress at Source',
        20 => 'Collected by Shipping Agent at Source',
        30 => 'Cancelled',
        40 => 'With Shipping Line (Departure Country)',
        50 => 'With Shipping Line (In Transit)',
        60 => 'With Shipping Line (Arrival Country)',
        70 => 'Shipping Arrived At Destination Receiving Agent',
        80 => 'Shipping Arrived At Destination Warehouse',
        90 => 'Unboxing Finished',
        100 => 'Shipment Complete'
    ],

    'shipping_status_short' => [
       //00 => 'Not Shipped',
        //10 => 'In Progress at Source',
        20 => 'In Transit (UK)',
        //30 => 'Cancelled',
        40 => 'In Transit (UK)',
        50 => 'In Transit (VESSEEL)',
        60 => 'In Transit (MY)',
        70 => 'Ready to Receive (MY)',
        80 => 'Shipping Arrived (MY)',
        90 => 'Unboxing Finished (MY)',
        100 => 'Shipment Complete (MY)'
    ],

    'box_status' => [
        00 => 'Not Boxed',
        10 => 'In Progress at Source (UK)',
        20 => 'Packaging Complete (UK)',
        30 => 'Assigned to Shipment (UK)',
        40 => 'Arrived At Destination',
        50 => 'Received At Destination (MY)',
        60 => 'Unboxed Completely (MY)',
        70 => 'Unpacked (MY)',
        80 => 'Box Empty',
        90 => 'Disposed',
        100 => 'Life Cycle Complete'
    ],

    'shipping_box_size' =>[
        'Midi'  => ['WIDTH_CM' => 46 , 'LENGTH_CM' => 46, 'HEIGHT_CM' => 51],
        'Maxi'  => ['WIDTH_CM' => 46 , 'LENGTH_CM' => 46, 'HEIGHT_CM' => 78],
        'Other' => ['WIDTH_CM' => 46 , 'LENGTH_CM' => 46, 'HEIGHT_CM' => 80]
    ],

    'shippment_address_type' => [
            'From'              => 'From Address',
            'Ship_to'           => 'Delivery Address',
            'Bill_to'           => 'Billing Address',
            'Receiving_agent'   => 'Receiving Agent',
            'Shipping_agent'    => 'Shipping Agent',
           // 'Dispatch'      => 'Dispatch From',
            ],

    'logistics_carrier' => [
            ''                      => 'select option',
            'dhl'                   => 'DHL',
            'fedex'                 => 'FedEx',
            'oman_air'              => 'Oman Air',
            'continental_shipping_line' => 'Continental Shipping Line',
    ],

    'order_from' => [
        'FROM_NAME'             => 'AZURAMART',
        'FROM_MOBILE'           => '174258105',
        'FROM_ADDRESS_LINE_1'   => 'NO. 8 PINTAS TUNA 3',
        'FROM_ADDRESS_LINE_2'   => 'SEBERANG JAYA',
        'FROM_ADDRESS_LINE_3'   => '',
        'FROM_ADDRESS_LINE_4'   => '',
        'FROM_CITY'             => 'PERAI',
        'FROM_STATE'            => 'PULAU PINANG',
        'FROM_POSTCODE'         => '13700',
        'FROM_COUNTRY'          => 'MALAYSIA',
        'ATTENTION'             => 'Attn: Ezar Bin Azmi',
        'FROM_F_COUNTRY_NO'     => '2',
    ],

    'COS_RTC_zone' => [
        57 => ['F_INV_ZONE_NO' => 262, 'INV_ZONE_BARCODE' => '0290100101'], //HUDA
        17 => ['F_INV_ZONE_NO' => 263, 'INV_ZONE_BARCODE' => '0290200202'], //FARAH
        74 => ['F_INV_ZONE_NO' => 264, 'INV_ZONE_BARCODE' => '0290300303'], //MAMA
    ],

    'order_content_types' => [
        'fitness'               => 'Lifestyle & Home - Health and Fitness',
        'outdoors'              => 'Lifestyle & Home - Outdoors',
        'general'               => 'Fashion & Apparel - General',
        'sports'                => 'Fashion & Apparel - Sports',
        'accessories'           => 'Fashion & Apparel - Accessories',
        'muslimah'              => 'Fashion & Apparel- Muslimah',
        'health'                => 'Health & Beauty',
        'babies'                => 'Babies & Toys',
        'gadget_general'        => 'Electronic & Gadgets - General',
        'music'                 => 'Electronic & Gadgets - Music',
        'furniture'             => 'Lifestyle & Home - Furniture',
        'papers'                => 'Letters & Papers',
        'others'                => 'Others',
    ],
    'get_parcel_sizes' => [
        'flyers_s'              => 'Flyers S',
        'flyers_m'              => 'Flyers M',
        'flyers_l'              => 'Flyers L',
        'flyers_xl'             => 'Flyers XL',
        'envelope_third'        => 'Envelope 1\/3 A4',
        'envelope_a4'           => 'Envelope A4',
        'envelope_a5'           => 'Envelope A5',
        'box'                   => 'Box Self Wrapped',

    ],

    'refund_reason' => [
        'Out of Stock' => 'Out of Stock',
        'Defect/Faulty' => 'Defect/Faulty',
        'Waiting too long' => 'Waiting too long',
    ],

    'return_condition' => [
        1 => 'Good Condition (Wrong Product)',
        4 => 'Good Condition (Right Product)',
        2 => 'Bad Condition  (Item Returned - broken / out of order)',
        3 => 'Bad Condition (Item Not Returned - faulty / broken / out of order)',
        5 => 'Bad Condition ( Item Returned - defect )',
    ],


]
?>
