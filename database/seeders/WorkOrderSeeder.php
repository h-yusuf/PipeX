<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class WorkOrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = DB::table('products')->pluck('id')->toArray();
        $users = DB::table('users')->pluck('id')->toArray();

        for ($i = 1; $i <= 10; $i++) {
            DB::table('work_orders')->insert([
                'work_order_number' => 'WO-' . Carbon::now()->format('Ymd') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'product_id' => $products[array_rand($products)],
                'quantity' => rand(10, 100),
                'due_date' => Carbon::now()->addDays(rand(1, 30)),
                'status' => ['Pending', 'In Progress', 'Completed', 'Canceled'][array_rand(['Pending', 'In Progress', 'Completed', 'Canceled'])],
                'operator_id' => $users[array_rand($users)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
