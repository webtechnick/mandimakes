<?php

use App\Shipping;
use Illuminate\Database\Seeder;

class ShippingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['shipping_type_id' => 1, 'name' => 'Ground', 'price_dollars' => '12'],
            ['shipping_type_id' => 1, 'name' => '3 Day Select', 'price_dollars' => '24'],
            ['shipping_type_id' => 2, 'name' => 'Ground', 'price_dollars' => '12'],
            ['shipping_type_id' => 2, 'name' => '3 Day Select', 'price_dollars' => '24'],
        ];

        foreach ($data as $shipping) {
            factory(Shipping::class)->create($shipping);
        }
    }
}
