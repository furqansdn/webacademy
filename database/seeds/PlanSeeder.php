<?php

use App\Models\Membership\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'name' => 'Coba-Coba',
                'description' => 'Bagi pemula yang ingin tau',
                'month_of_subscription' => 1,
                'price' => 300000
            ],
            [
                'name' => 'Serius',
                'description' => 'Bagi pemula yang ingin serius',
                'month_of_subscription' => 3,
                'price' => 500000
            ],
            [
                'name' => 'Profesional',
                'description' => 'Bagi pemula yang ingin menjadi seorang pro',
                'month_of_subscription' => 12,
                'price' => 600000
            ],
        ];

        foreach ($plans as $key) {
            Plan::firstOrCreate($key);
        }
    }
}
