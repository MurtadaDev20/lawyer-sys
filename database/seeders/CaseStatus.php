<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CaseStatus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
                'قيد الانتظار',
                'قيد المراجعة',
                'تمت المتابعة',
                'مغلقة',
                'مرفوضة',
                'محالة لمحكمة أخرى',
                'مؤجلة',
                'قيد التنفيذ',
                    ];

        foreach ($statuses as $status) {
            DB::table('case_statuses')->insert([
                'name' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
