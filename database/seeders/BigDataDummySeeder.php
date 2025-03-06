<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BigDataDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sqlFiles = [
            'databases/work_orders.sql',
        ];
        foreach ($sqlFiles as $sqlfile) {
            try {
                DB::unprepared(file_get_contents(public_path($sqlfile)));
                \Log::info('SQL Import Done for: ' . $sqlfile);
            } catch (\Exception $e) {
                \Log::error('SQL Import Failed for: ' . $sqlfile . '. Error: ' . $e->getMessage());
            }
        }
    }
}
