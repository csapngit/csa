<?php

namespace Database\Seeders;

use App\Enums\GroupMenuEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppMenuSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run()
	{
		DB::table('app_menus')->insert([

			// Admin & User
			['title' => 'Admin',            'page' => null,                             'icon' => 1,	'bullet' => 1,	'root' => 1,	'newtab' => 0,	'header' => 0, 		'order' => 1,		'group_code' => NULL, 													'created_at' => \Carbon\Carbon::now()],
			['title' => 'User',             'page' => null,                             'icon' => 1,	'bullet' => 1,	'root' => 1,	'newtab' => 0,	'header' => 1, 		'order' => 2,		'group_code' => NULL, 													'created_at' => \Carbon\Carbon::now()],
			['title' => 'List User',        'page' => 'users',                    			'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 2, 		'order' => 1,		'group_code' => GroupMenuEnum::ADMIN, 					'created_at' => \Carbon\Carbon::now()],
			['title' => 'Authorization',    'page' => 'authorizations',	                'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 2, 		'order' => 2,		'group_code' => GroupMenuEnum::ADMIN, 					'created_at' => \Carbon\Carbon::now()],

			// Rebate Voucher
			['title' => 'Rebate',           'page' => null,                             'icon' => 1,	'bullet' => 1,	'root' => 1,	'newtab' => 0,	'header' => 0, 		'order' => 5,		'group_code' => NULL, 													'created_at' => \Carbon\Carbon::now()],
			['title' => 'Programs',         'page' => null,                             'icon' => 1,	'bullet' => 1,	'root' => 1,	'newtab' => 0,	'header' => 5, 		'order' => 6,		'group_code' => NULL, 													'created_at' => \Carbon\Carbon::now()],
			['title' => 'Master Program',   'page' => 'programs',                       'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 6, 		'order' => 1,		'group_code' => GroupMenuEnum::REBATE, 					'created_at' => \Carbon\Carbon::now()],
			['title' => 'Generate Voucher', 'page' => 'generates',                      'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 6, 		'order' => 2,		'group_code' => GroupMenuEnum::REBATE, 					'created_at' => \Carbon\Carbon::now()],
			['title' => 'Approve Voucher',  'page' => 'approves',                       'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 6, 		'order' => 3,		'group_code' => GroupMenuEnum::REBATE, 					'created_at' => \Carbon\Carbon::now()],
			['title' => 'Publish Voucher',  'page' => 'publishes',                      'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 6, 		'order' => 4,		'group_code' => GroupMenuEnum::REBATE, 					'created_at' => \Carbon\Carbon::now()],
			['title' => 'Print Voucher',    'page' => 'reports',                        'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 6, 		'order' => 5,		'group_code' => GroupMenuEnum::REBATE, 					'created_at' => \Carbon\Carbon::now()],
			// Rebate ICG
			['title' => 'ICG',              'page' => null,                             'icon' => 1,	'bullet' => 1,	'root' => 1,	'newtab' => 0,	'header' => 5, 		'order' => 12,	'group_code' => NULL, 													'created_at' => \Carbon\Carbon::now()],
			['title' => 'List ICG',         'page' => '/rebate/icg',                    'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 12,		'order' => 1, 	'group_code' => GroupMenuEnum::REBATE_ICG, 			'created_at' => \Carbon\Carbon::now()],
			['title' => 'Upload ICG',       'page' => '/rebate/icg/upload',             'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 12,		'order' => 2, 	'group_code' => GroupMenuEnum::REBATE_ICG, 			'created_at' => \Carbon\Carbon::now()],
			// Rebate Potongan Manual
			['title' => 'Potongan Manual',  'page' => null,                             'icon' => 1,	'bullet' => 1,	'root' => 1,	'newtab' => 0,	'header' => 5, 		'order' => 15,	'group_code' => NULL, 													'created_at' => \Carbon\Carbon::now()],
			['title' => 'List Potongan',    'page' => '/rebate/manual',                 'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 15,		'order' => 1, 	'group_code' => GroupMenuEnum::REBATE_MANUAL, 	'created_at' => \Carbon\Carbon::now()],
			['title' => 'Entry Potongan',   'page' => '/rebate/manual/create',          'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 15,		'order' => 2, 	'group_code' => GroupMenuEnum::REBATE_MANUAL, 	'created_at' => \Carbon\Carbon::now()],
			// Rebate mapping
			['title' => 'Mapping AR',       'page' => null,                             'icon' => 1,	'bullet' => 1,	'root' => 1,	'newtab' => 0,	'header' => 5, 		'order' => 18,	'group_code' => NULL, 													'created_at' => \Carbon\Carbon::now()],
			['title' => 'List Mapping',     'page' => '/rebate/mapping-ar',             'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 18,		'order' => 1, 	'group_code' => GroupMenuEnum::REBATE_MAPPING, 	'created_at' => \Carbon\Carbon::now()],
			['title' => 'Entry Mapping',    'page' => '/rebate/mapping-ar/create',      'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 18,		'order' => 2, 	'group_code' => GroupMenuEnum::REBATE_MAPPING, 	'created_at' => \Carbon\Carbon::now()],
			// Rebate budget
			['title' => 'Mapping Budget',   'page' => null,                             'icon' => 1,	'bullet' => 1,	'root' => 1,	'newtab' => 0,	'header' => 5, 		'order' => 21,	'group_code' => NULL,  													'created_at' => \Carbon\Carbon::now()],
			['title' => 'List Mapping',     'page' => '/rebate/mapping-budget',         'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 21,		'order' => 1, 	'group_code' => GroupMenuEnum::REBATE_BUDGET,  	'created_at' => \Carbon\Carbon::now()],
			['title' => 'Entry Mapping',    'page' => '/rebate/mapping-budget/create',  'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 21,		'order' => 2, 	'group_code' => GroupMenuEnum::REBATE_BUDGET,  	'created_at' => \Carbon\Carbon::now()],

			// ITCSA
			['title' => 'Assets',		    		'page' => null,                        			'icon' => 1,	'bullet' => 1,	'root' => 1,	'newtab' => 0,	'header' => 0, 		'order' => 24,	'group_code' => NULL,														'created_at' => \Carbon\Carbon::now()],
			['title' => 'Assets Category',	'page' => 'itcsa/asset-categories',    			'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 24,		'order' => 1, 	'group_code' => GroupMenuEnum::ITCSA,  					'created_at' => \Carbon\Carbon::now()],
			['title' => 'Assets',						'page' => 'itcsa/assets',			        			'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 24,		'order' => 2, 	'group_code' => GroupMenuEnum::ITCSA,  					'created_at' => \Carbon\Carbon::now()],
			['title' => 'Assets Service',		'page' => 'itcsa/asset-services',     			'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 24,		'order' => 3, 	'group_code' => GroupMenuEnum::ITCSA,  					'created_at' => \Carbon\Carbon::now()],

			// Reports
			['title' => 'Reports',					'page' => null,     												'icon' => 1,	'bullet' => 1,	'root' => 1,	'newtab' => 0,	'header' => 0, 		'order' => 28,	'group_code' => NULL, 													'created_at' => \Carbon\Carbon::now()],
			['title' => 'So Monitoring',		'page' => 'report/so-monitoring',						'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 28,		'order' => 1, 	'group_code' => GroupMenuEnum::REPORTS,					'created_at' => \Carbon\Carbon::now()],
			['title' => 'DSR',							'page' => 'report/daily-sales-reports',			'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 28,		'order' => 2, 	'group_code' => GroupMenuEnum::REPORTS,					'created_at' => \Carbon\Carbon::now()],

			// ++ Rebate Voucher
			['title' => 'Post Image',	 	    'page' => 'program-images',            			'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 6, 		'order' => 6,		'group_code' => GroupMenuEnum::REBATE, 					'created_at' => \Carbon\Carbon::now()],
			['title' => 'Customers Import', 'page' => 'claim-customers-import',					'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 6, 		'order' => 7,		'group_code' => GroupMenuEnum::REBATE, 					'created_at' => \Carbon\Carbon::now()],

			// ++ Reports
			['title' => 'Tracking Payment',	'page' => 'report/tracking-payment',				'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 28,		'order' => 3, 	'group_code' => GroupMenuEnum::REPORTS,					'created_at' => \Carbon\Carbon::now()],

			// Target Report
			['title' => 'Target Report',		'page' => null,															'icon' => 1,	'bullet' => 1,	'root' => 1,	'newtab' => 0,	'header' => 0,		'order' => 34, 	'group_code' => NULL,														'created_at' => \Carbon\Carbon::now()],
			['title' => 'DSR',							'page' => 'report/target-dsrs',							'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 34,		'order' => 1, 	'group_code' => GroupMenuEnum::TARGET,					'created_at' => \Carbon\Carbon::now()],
			['title' => 'Tracking Payment',	'page' => '#',															'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 34,		'order' => 2, 	'group_code' => GroupMenuEnum::TARGET,					'created_at' => \Carbon\Carbon::now()],

			// Tds
			['title' => 'TDS',							'page' => null,															'icon' => 1,	'bullet' => 1,	'root' => 1,	'newtab' => 0,	'header' => 0,		'order' => 37, 	'group_code' => NULL,														'created_at' => \Carbon\Carbon::now()],
			['title' => 'API',							'page' => 'tds/index',											'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 37,		'order' => 1, 	'group_code' => GroupMenuEnum::TDS,							'created_at' => \Carbon\Carbon::now()],
			['title' => 'Incentive',				'page' => 'tds/index-incentive',						'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 37,		'order' => 2, 	'group_code' => GroupMenuEnum::TDS,							'created_at' => \Carbon\Carbon::now()],
			['title' => 'Promo Price',			'page' => 'tds/index-promoPrice',						'icon' => 1,	'bullet' => 1,	'root' => 0,	'newtab' => 0,	'header' => 37,		'order' => 3, 	'group_code' => GroupMenuEnum::TDS,							'created_at' => \Carbon\Carbon::now()],
		]);
	}
}
