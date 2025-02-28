<?php

namespace Database\Seeders;

use App\Models\EmployeeModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = [
            [
                'name' => 'John Doe',
                'npk' => '123456',
                'username' => 'johndoejghj',
                'password_hash' => bcrypt('secret'),
                'password' => 'secret',
                'status' => 'active'
            ],
            [
                'name' => 'Jane Smith',
                'npk' => '789101',
                'username' => 'janesmith',
                'password' => 'secret',
                'password_hash' => bcrypt('secret'),
                'status' => 'inactive'
            ],
            [
                'name' => 'Alice Johnson',
                'npk' => '234567',
                'username' => 'alicej',
                'password' => 'secret',
                'password_hash' => bcrypt('secret'),
                'status' => 'active'
            ],
            [
                'name' => 'Bob Brown',
                'npk' => '345678',
                'username' => 'bobb',
                'password' => 'secret',
                'password_hash' => bcrypt('secret'),
                'status' => 'active'
            ],
            [
                'name' => 'Charlie Davis',
                'npk' => '456789',
                'username' => 'charlied',
                'password' => 'secret',
                'password_hash' => bcrypt('secret'),
                'status' => 'inactive'
            ],
            [
                'name' => 'David Evans',
                'npk' => '567890',
                'username' => 'davide',
                'password' => 'secret',
                'password_hash' => bcrypt('secret'),
                'status' => 'active'
            ],
            [
                'name' => 'Eve Foster',
                'npk' => '678901',
                'username' => 'evef',
                'password' => 'secret',
                'password_hash' => bcrypt('secret'),
                'status' => 'active'
            ],
            [
                'name' => 'Frank Green',
                'npk' => '789012',
                'username' => 'frankg',
                'password' => 'secret',
                'password_hash' => bcrypt('secret'),
                'status' => 'inactive'
            ],
            [
                'name' => 'Grace Hill',
                'npk' => '890123',
                'username' => 'graceh',
                'password' => 'secret',
                'password_hash' => bcrypt('secret'),
                'status' => 'active'
            ],
            [
                'name' => 'Hank Irving',
                'npk' => '901234',
                'username' => 'hanki',
                'password' => 'secret',
                'password_hash' => bcrypt('secret'),
                'status' => 'inactive'
            ],
        ];

        foreach ($employees as $employee) {
            EmployeeModel::create([
                'name' => $employee['name'],
                'npk' => $employee['npk'],
                'username' => $employee['username'],
                'password' => $employee['password'],
                'password_hash' => Hash::make($employee['password_hash']),
                'status' => $employee['status'],
            ]);
        }
    }
}
