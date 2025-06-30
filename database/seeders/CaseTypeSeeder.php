<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CaseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'جنائية',
            'مدنية',
            'أحوال شخصية',
            'تجارية',
            'عمل وعمال',
            'مرور',
            'إدارية',
            'تنفيذية',
            'مالية',
            'ملكية عقارية',
            'عقود ومقاولات',
            'جرائم إلكترونية',
        ];

        foreach ($types as $type) {
            DB::table('case_types')->insert([
                'name' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
