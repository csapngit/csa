<?php

return [

	'others' => [
		'claim' => 'Claim',
		'home'  => 'Home',
		'app'   => 'Apps',
	],

	'area' =>
	[
		'area' => 'Area',
		'jakarta' => 'Jakarta',
		'sumatra' => 'Sumatra',
	],

	'sidebar' =>
	[
		'master'    => 'Master',
		'dashboard' => 'Dashboard',
		'program'   => 'Program',
		'setting'   => 'Setting',
		'generate'  => 'Generate',
		'user'      => 'User',
	],

	'types' => [
		'display' => 'Display',
		'volume'  => 'Volume',
	],

	'programs' => [
		'area'            => 'Area',
		'name'            => 'Program Name',
		'program_type_id' => 'Program Type',
		'customer_list'   => 'Customers',
		'brand'           => 'Brand',
		'select_type'     => 'Select Type',
		'valid'           => 'Valid',
		'valid_from'      => 'Valid From',
		'valid_until'     => 'Valid Until',
		'promo'           => 'Promo',
		'depth'           => 'Depth',
		'normal_price'    => 'Nomal Price',
		'promo_price'     => 'Promo Price',
		'cut_price'       => 'Cut Price',
		'sku_group'       => 'SKU Group',
		'inventory'       => 'SKU',
		'display_id'      => 'Display Type',
		'pages'           => [
			'index'  => 'Programs',
			'create' => 'Create Program',
			'edit'   => 'Edit Program',
			'show'   => 'Detail Program',
		],
		'placeholder' => [
			'program_type_id' => 'Select Type ..',
			'area'            => 'Select Area ..',
			// 'display_id' => 'Select Display Type ..',
		],
		'images' => [
			'image'      => 'Image',
			'program_id' => 'Program Name',
			'pages'      => [
				'index'  => 'Post Images',
				'create' => 'Create Image',
				// 'edit'   => 'Edit Program',
				'show'   => 'Detail Program',
			],
		]
	],

	'print_vouchers' => [
		'name' => 'Branch',
		'pages' => [
			'index' => 'Voucher Print'
		],
		'placeholder' => [
			'name' => 'Select Branch ..'
		]
	],

	'tiers' => [
		'name'             => 'Tier name',
		'minimum_purchase' => 'Minimum Purchase',
		'maximum_purchase' => 'Maximum Purchase',
		'minimum_pcs'      => 'Minimum Pcs',
		'maximum_pcs'      => 'Maximum Pcs',
		'display'          => 'Display',
		'monthly_display'  => 'Display Incentive',
		'monthly_volume'   => 'Volume Incentive',
		'program_id'       => 'Program Name',
		'product_id'       => 'Product Name',
		'cashback'         => 'Cashback',
		'pages'            => [
			'index'  => 'Tiers',
			'create' => 'Create Tier',
			'edit'   => 'Edit Tier',
		],
		'placeholder' => [
			'product_id' => 'Select Product ..',
			'display'    => '7 +1 Hanger',
		]
	],

	'products' => [
		'name'       => 'Product Name',
		'sku'        => 'SKU',
		'solomon_id' => 'Solomon ID',
		'pages'      => [
			'index'  => 'Products',
			'create' => 'Create Product',
			'edit'   => 'Edit Product',
			'show'   => 'Show Product',
		],
	],

	'customers' => [
		'customer_id'   => 'Customer ID',
		'customer_code' => 'Customer Code',
		'target'        => 'Target',
		'offtakes'      => 'Offtakes',
		'tier'          => 'Tier',
		'add_customer'  => 'Add Customer',
		'pages'         => [
			'index'  => 'Customers',
			'create' => 'Create Customer',
			'edit'   => 'Edit Customer',
			'show'   => 'Show Customer',
		],
		'texts' => [
			'customer_does_not_exist' => "Data where doesn't exist",
		]
	],

	'generates' => [
		'key'        => 'Key',
		'key_id'     => 'Select Key',
		'program_id' => 'Program Name',
		'pages'      => [
			'index' => 'Generate'
		],
		'placeholder' => [
			'date'       => 'Select Date :',
			'program_id' => 'Select Program..',
			'key_id'     => 'Select Key..'
		],
		'texts' => [
			'import' => 'Import Toko Display',
			'export' => 'Export Data'
		]
	],

	'users' =>
	[
		'username'    => 'Username',
		'name'        => 'Full Name',
		'email'       => 'Email',
		'password'    => 'Password',
		'area'        => 'Area',
		'branch'      => 'Branch',
		'status'      => 'Status',
		'role'        => 'Role',
		'permissions' => 'Permissions',
		'pages'       => [
			'index'  => 'Users',
			'create' => 'Create User',
			'edit'   => 'Edit User',
			'show'   => 'Detail User',
		],
	],

	'publishes' => [
		'start_date' => 'Start Date',
		'end_date'   => 'End Date',
		'pages'      => [
			'index'  => 'Voucher Publish',
			'create' => 'Create Publish',
			'edit'   => 'Edit Publish',
			'show'   => 'Detail Publish',
		],
	],

	'invoices' => [
		'customer_id'       => 'Kode Customer',
		'client'            => 'Nama Customer',
		'invoice'           => 'Nomor Invoice',
		'sales_person'      => 'Kode SR',
		'expired'           => 'Expired Voucher',
		'total'             => 'Total Invoice',
		'program_name'      => 'Program',
		'incentive_total'   => 'Total Incentive',
		'incentive_display' => 'Incentive Display',
		'incentive_volume'  => 'Incentive Volume',
		'amount'            => 'Incentive',
		'paid'              => 'Pembayaran',
	],

	'approves' => [
		'key_id' => 'Select Key',
		'pages'  => [
			'index'  => 'Approves',
		],
	],

	'assets' => [
		'barcode' => 'Barcode',
		'category_id' => 'Category',
		'brand' => 'Brand',
		'serial_number' => 'IMEI / Serial Number',
		'purchase_date' => 'Purchase Date',
		'name' => 'User',
		'division_id' => 'Division',
		'branch_id' => 'Site',
		'lend_date' => 'Lend Date',
		'return_date' => 'Return Date',
		'description' => 'Description',
		'pages' => [
			'index' => 'Assets',
			'create' => 'Create Asset',
			'edit' => 'Edit Asset'
		],
		'placeholder' => [
			'category_id' => 'Select Category ..',
			'branch_id' => 'Select Site ..',
			'division_id' => 'Select Division ..',
		]
	],

	'categories' => [
		'name' => 'Name',
		'pages' => [
			'index' => 'Categories',
			'create' => 'Create Category',
			'edit' => 'Edit Category'
		],
	],

	'services' => [
		'asset_id' => 'Asset',
		'service_date' => 'Service Date',
		'description' => 'Description',
		'return_date' => 'Return',
		'status' => 'Status',
		'pages' => [
			'index' => 'Services',
			'create' => 'Create Service',
			'edit' => 'Edit Service'
		],
		'placeholder' => [
			'asset_id' => 'Select Asset ..'
		]
	],

	'reports' => [
		'so-monitorings' => [
			'detail' => 'SO Monitoring Detail',
			'area' => 'Area',
			'cabang' => 'Cabang',
			'sales_id' => 'Sales ID',
			'shipper_id' => 'Shipper ID',
			'customer_id' => 'Customer ID',
			'billname' => 'Name',
			'inventory_id' => 'Inventory ID',
			'order_number' => 'Order Number',
			'average' => 'Average',
			'total_average' => 'Total Average',
			'last_sync' => 'Last Sync',
			'qty_draft' => 'Qty Draft',
			'qty_so' => 'Qty SO',
			'qty_total' => 'Total Qty',
			'amount_draft' => 'Amount Draft',
			'amount_so' => 'Amount SO',
			'qty_do' => 'Qty DO',
			'total_so' => 'Total SO',
			'totmerch' => 'Total DO',
		],
		'dsr' => [
			'dsr' => 'Daily Sales Report',
			'branch' => 'Cabang',
			'channel_bisnis' => 'Channel Bisnis',
			'so_open' => 'SO Open',
			'delivery_order' => 'DO',
			'ar_invoice' => 'AR',
			'sales_total' => 'Sales Total',
			'monthly_target' => 'Monthly Target',
			'index_archive' => 'Idx Arch',
			'gap' => 'Gap',
			'target' => 'Target',
			'date' => 'Date',
			'best_estimate' => 'Best Estimate',
			'acvh_vs_target' => 'Achv vs Target',
			'acvh_vs_timegone' => 'Achv vs Timegone',
			'timegone_index' => 'Timegone %',
			'timegone' => 'Timegone',
			'working_days' => 'Hari Kerja',
			'the_rest_of_working_days' => 'Sisa Hari Kerja',
		]
	],

	'button' => [
		'add'       => 'Add',
		'back'      => 'Back',
		'browse'    => 'Browse',
		'calculate' => 'Calculate',
		'close'     => 'Close',
		'delete'    => 'Delete',
		'detail'    => 'Detail',
		'edit'      => 'Edit',
		'export'    => 'Export',
		'generate'  => 'Generate',
		'logout'    => 'Logout',
		'next'      => 'Next',
		'previous'  => 'Previous',
		'print'     => 'Print',
		'refresh'   => 'Refresh',
		'reset'     => 'Reset',
		'show'      => 'Show',
		'submit'    => 'Submit',
	],

	'tables' => [
		'number' => 'No',
		'name'   => 'Name',
		'type'   => 'Type',
		'text'   => 'Text',
		'date'   => 'Date',
		'action' => 'Action',
		'status' => 'Status',
	],

	'generals' => [
		'confirm' => 'Are You Sure ?',
		'select_placeholder' => '...',
		'files' => 'Choose File',
	],

	'operators' => [
		'percentage' => '%',
		'rupiah'     => 'Rp ',
	]

];
