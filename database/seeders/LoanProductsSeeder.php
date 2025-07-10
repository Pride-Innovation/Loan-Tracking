<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('loan_products')->insert([
            [
                'name' => 'Corporate Banking',
                'code' => 'CB',
                'description' => 'Corporate banking loans'
            ],
            [
                'name' => 'Micro Finance',
                'code' => 'Micro',
                'description' => 'Micro finance loans'
            ],
            [
                'name' => 'Small Group Lending',
                'code' => 'SGL',
                'description' => 'Small group lending'
            ],
            [
                'name' => 'Small & Medium Enterprise',
                'code' => 'SME',
                'description' => 'SME loans'
            ],
        ]);
    }
}
