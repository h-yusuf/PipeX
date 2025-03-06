<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WorkOrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = DB::table('products')->pluck('id')->toArray();
        $users = DB::table('users')->pluck('id')->toArray();

        for ($i = 1; $i <= 10; $i++) {

            $quantity = rand(10, 100); 
            $qtyProgress = rand(0, $quantity); 

            $startProduction = Carbon::now()->subDays(rand(1, 10))->addHours(rand(1, 8));
            $endProduction = (clone $startProduction)->addHours(rand(1, 12));

            DB::table('work_orders')->insert([
                'work_order_number' => 'WO-' . Carbon::now()->format('Ymd') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'product_id' => $products[array_rand($products)],
                'qty_progress' => $qtyProgress,
                'quantity' => $quantity,
                'start_production' => $startProduction,
                'finish_production' => $endProduction,
                'due_date' => Carbon::now()->addDays(rand(1, 30)),
                'status' => ['Pending', 'In Progress', 'Completed', 'Canceled'][array_rand([0, 1, 2, 3])],
                'operator_id' => $users[array_rand($users)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
