<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('system_settings')->insert([
            [
                'key' => 'sla_escalation_enabled',
                'value' => 'true',
                'description' => 'Enable automatic SLA escalation',
            ],
            [
                'key' => 'sla_escalation_threshold_hours',
                'value' => '96',
                'description' => 'Hours before auto-escalation',
            ],
            [
                'key' => 'sla_notification_intervals',
                'value' => '[24, 48, 72]',
                'description' => 'Hours for SLA warning notifications',
            ],
            [
                'key' => 'application_number_prefix',
                'value' => 'LN',
                'description' => 'Prefix for loan application numbers',
            ],
            [
                'key' => 'max_concurrent_users',
                'value' => '100',
                'description' => 'Maximum concurrent users',
            ],
            [
                'key' => 'system_timezone',
                'value' => 'Africa/Kampala',
                'description' => 'System timezone',
            ],
        ]);
    }
}
