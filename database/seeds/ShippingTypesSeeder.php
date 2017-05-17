<?php

use App\ShippingType;
use Illuminate\Database\Seeder;

class ShippingTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'USPS'],
            ['name' => 'UPS'],
        ];

        foreach ($data as $shipping_type) {
            factory(ShippingType::class)->create($shipping_type);
        }
    }
}
