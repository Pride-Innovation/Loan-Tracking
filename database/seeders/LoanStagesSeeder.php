<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanStagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('loan_stages')->insert([
            [
                'name' => 'Not Appraised',
                'slug' => 'not_appraised',
                'display_name' => 'Not Appraised',
                'required_role' => 'branch_officer',
                'default_sla_hours' => 24,
            ],
            [
                'name' => 'Appraised',
                'slug' => 'appraised',
                'display_name' => 'Appraised',
                'required_role' => 'branch_officer',
                'default_sla_hours' => 24,
            ],
            [
                'name' => 'Branch Credit Committee',
                'slug' => 'branch_credit_committee',
                'display_name' => 'Branch Credit Committee',
                'required_role' => 'branch_credit_committee',
                'default_sla_hours' => 48,
            ],
            [
                'name' => 'HQ Credit Committee - Credit Analyst',
                'slug' => 'hq_credit_analyst',
                'display_name' => 'HQ Credit Committee - Credit Analyst',
                'required_role' => 'credit_analyst',
                'default_sla_hours' => 72,
            ],
            [
                'name' => 'HQ Credit Committee - Credit Evaluation',
                'slug' => 'hq_credit_evaluation',
                'display_name' => 'HQ Credit Committee - Credit Evaluation',
                'required_role' => 'manager_credit_committee',
                'default_sla_hours' => 72,
            ],
            [
                'name' => 'MCC',
                'slug' => 'mcc',
                'display_name' => 'Manager Credit Committee',
                'required_role' => 'manager_credit_committee',
                'default_sla_hours' => 72,
            ],
            [
                'name' => 'HOCC',
                'slug' => 'hocc',
                'display_name' => 'Head of Credit Committee',
                'required_role' => 'head_credit_committee',
                'default_sla_hours' => 72,
            ],
            [
                'name' => 'BCC',
                'slug' => 'bcc',
                'display_name' => 'Board Credit Committee',
                'required_role' => 'board_credit_committee',
                'default_sla_hours' => 96,
            ],
            [
                'name' => 'Full Board',
                'slug' => 'full_board',
                'display_name' => 'Full Board',
                'required_role' => 'full_board',
                'default_sla_hours' => 168,
            ],
        ]);
    }
}
