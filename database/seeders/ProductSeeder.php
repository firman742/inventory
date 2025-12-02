<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $productsByType = [
            'IP Camera' => [
                [
                    'sku' => 'IPCAM-001',
                    'name' => 'IP Camera 2MP Indoor',
                    'default_price' => 350000
                ],
                [
                    'sku' => 'IPCAM-002',
                    'name' => 'IP Camera 5MP Outdoor',
                    'default_price' => 550000
                ],
                [
                    'sku' => 'IPCAM-003',
                    'name' => 'IP Camera PTZ 4X Zoom',
                    'default_price' => 1200000
                ],
            ],

            'DVR' => [
                [
                    'sku' => 'DVR-001',
                    'name' => 'DVR 4 Channel',
                    'default_price' => 650000
                ],
                [
                    'sku' => 'DVR-002',
                    'name' => 'DVR 8 Channel',
                    'default_price' => 850000
                ],
                [
                    'sku' => 'DVR-003',
                    'name' => 'DVR 16 Channel',
                    'default_price' => 1300000
                ],
            ],

            'NVR' => [
                [
                    'sku' => 'NVR-001',
                    'name' => 'NVR 4 Channel',
                    'default_price' => 900000
                ],
                [
                    'sku' => 'NVR-002',
                    'name' => 'NVR 8 Channel',
                    'default_price' => 1400000
                ],
                [
                    'sku' => 'NVR-003',
                    'name' => 'NVR 16 Channel',
                    'default_price' => 2200000
                ],
            ],

            'Power Supply' => [
                [
                    'sku' => 'PSU-001',
                    'name' => 'Power Supply 12V 5A',
                    'default_price' => 75000
                ],
                [
                    'sku' => 'PSU-002',
                    'name' => 'Power Supply 12V 10A',
                    'default_price' => 120000
                ],
                [
                    'sku' => 'PSU-003',
                    'name' => 'Power Supply 12V 20A',
                    'default_price' => 220000
                ],
            ],

            'Accessories' => [
                [
                    'sku' => 'ACC-001',
                    'name' => 'BNC Connector',
                    'default_price' => 5000
                ],
                [
                    'sku' => 'ACC-002',
                    'name' => 'CCTV Bracket',
                    'default_price' => 25000
                ],
                [
                    'sku' => 'ACC-003',
                    'name' => 'CCTV Cable Roll 100m',
                    'default_price' => 250000
                ],
            ],
        ];

        foreach ($productsByType as $typeName => $items) {
            $type = ProductType::where('name', $typeName)->first();

            foreach ($items as $product) {
                Product::create([
                    'sku' => $product['sku'],
                    'name' => $product['name'],
                    'default_price' => $product['default_price'],
                    'description' => $product['name'],
                    'product_type_id' => $type->id,
                ]);
            }
        }
    }
}
