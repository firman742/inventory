<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'IP Camera',
                'description' => 'Kamera CCTV berbasis Internet Protocol',
                'is_active' => true
            ],
            [
                'name' => 'DVR',
                'description' => 'Digital Video Recorder untuk CCTV Analog',
                'is_active' => true
            ],
            [
                'name' => 'NVR',
                'description' => 'Network Video Recorder untuk IP Camera',
                'is_active' => true
            ],
            [
                'name' => 'Power Supply',
                'description' => 'Power untuk perangkat CCTV',
                'is_active' => true
            ],
            [
                'name' => 'Accessories',
                'description' => 'Perlengkapan pendukung CCTV',
                'is_active' => true
            ],
        ];

        foreach ($types as $type) {
            ProductType::create($type);
        }
    }
}
