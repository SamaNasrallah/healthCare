<?php

namespace Database\Seeders;

use App\Models\MedicalAdviceAd;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicalAdviceAdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MedicalAdviceAd::create([
            'title' => 'Medical Advice 1',
            'content' => 'Make sure you drink enough water to keep your skin healthy.',
            'type' => 'medical_advice',
        ]);

        MedicalAdviceAd::create([
            'title' => 'Advertisement 1',
            'content' => 'Get 10% off all cosmetics today only!',
            'type' => 'advertisement',
        ]);
    }
}
