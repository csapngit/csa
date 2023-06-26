<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $users = [
      [
        'name'     => 'Kevin Septyan',
        'username' => 'kevin',
        'email'    => 'kevin.septian@csahome.com',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('12345'),
        'avatar' => 'default.jpg',
        'role' => '4',
        'area' => '1',
        'branch' => '1',
        'status' => 1,
        'inputby' => '1',
        'lastlogin' => \Carbon\Carbon::now(),
      ],
      [
        'name'     => 'Sadjidin',
        'username' => 'sadjidin',
        'email'    => 'sadjidin@csahome.com',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('12345'),
        'avatar' => 'default.jpg',
        'role' => '4',
        'area' => '1',
        'branch' => '1',
        'status' => 1,
        'inputby' => '1',
        'lastlogin' => \Carbon\Carbon::now(),
      ],
      [
        'name'     => 'User',
        'username' => 'user',
        'email'    => 'user.test@csahome.com',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('12345'),
        'avatar' => 'default.jpg',
        'role' => '4',
        'area' => '1',
        'branch' => '1',
        'status' => 1,
        'inputby' => '1',
        'lastlogin' => \Carbon\Carbon::now(),
      ],
      [
        'name'     => 'Iman',
        'username' => 'iman',
        'email'    => 'iman.adehermawan@csahome.com',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('123'),
        'avatar' => 'default.jpg',
        'role' => '4',
        'area' => '1',
        'branch' => '1',
        'status' => 1,
        'inputby' => '1',
        'lastlogin' => \Carbon\Carbon::now(),
      ],
			[
				'name'     => 'IT',
        'username' => 'itcsa',
        'email'    => 'itcsa@csahome.com',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('12345'),
        'avatar' => 'default.jpg',
        'role' => '4',
        'area' => '1',
        'branch' => '1',
        'status' => 1,
        'inputby' => '1',
        'lastlogin' => \Carbon\Carbon::now(),
			],
			[
				'name'     => 'HRD',
        'username' => 'hrd',
        'email'    => 'hrdcsa@csahome.com',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('12345'),
        'avatar' => 'default.jpg',
        'role' => '4',
        'area' => '1',
        'branch' => '1',
        'status' => 1,
        'inputby' => '1',
        'lastlogin' => \Carbon\Carbon::now(),
			],
			[
				'name'     => 'Finance',
        'username' => 'finance',
        'email'    => 'financecsa@csahome.com',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('12345'),
        'avatar' => 'default.jpg',
        'role' => '7',
        'area' => '1',
        'branch' => '1',
        'status' => 1,
        'inputby' => '1',
        'lastlogin' => \Carbon\Carbon::now(),
			],
			[
				'name'     => 'Yeyep Julias',
        'username' => 'yeyep',
        'email'    => 'yeyep.julias@csahome.com',
        'email_verified_at' => Carbon::now(),
        'password' => Hash::make('12345'),
        'avatar' => 'default.jpg',
        'role' => '7',
        'area' => '2',
        'branch' => '12',
        'status' => 1,
        'inputby' => '1',
        'lastlogin' => \Carbon\Carbon::now(),
			],
    ];

    User::insert($users);
  }
}
