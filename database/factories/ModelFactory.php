<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'group' => 'user',
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Item::class, function (Faker\Generator $faker) {
    $text = implode("\n\n",$faker->paragraphs(2));
    return [
        'title' => $faker->sentence,
        'description' => $text,
        'short_description' => str_limit($text, 200),
        'status' => 1,
        'qty' => 1,
        'is_featured' => 0,
        'cart_count' => 0,
        'price_dollars' => $faker->randomFloat(2, '5', '500'),
    ];
});

$factory->define(\App\Address::class, function (Faker\Generator $faker) {
    return [
        'name_line' => $faker->name,
        'street' => $faker->streetAddress,
        'street_2' => $faker->secondaryAddress,
        'city' => $faker->city,
        'state' => $faker->stateAbbr,
        'zipcode' => $faker->postcode,
        'country' => 'USA',
    ];
});

$factory->define(\App\Tag::class, function (Faker\Generator $faker) {
    $word = ucwords($faker->word);
    return [
        'name' => $word,
        'slug' => str_slug($word)
    ];
});

$factory->define(\App\Order::class, function (Faker\Generator $faker) {
    $shipping_dollars = $faker->randomFloat(2, '2', '10');
    $tax_dollars = $faker->randomFloat(2, '0', '2');
    $discount_dollars = 0;
    $total_dollars = $faker->randomFloat(2, '50', '500') + $shipping_dollars + $tax_dollars;
    return [
        'user_id' => 1,
        'billing_address_id' => 1,
        'shipping_address_id' => 1,
        'phone' => $faker->phoneNumber,
        'email' => $faker->safeEmail,
        'is_new' => 1,
        'special_request' => null,
        'shipping_price_dollars' => $shipping_dollars,
        'discount_dollars' => 0,
        'tax_dollars' => $tax_dollars,
        'total_dollars' => $total_dollars,
        'shipping_id' => 1,
        'shipping_date' => null,
        'tracking_number' => null,
    ];
});

$factory->define(\App\Sale::class, function (Faker\Generator $faker) {
    $price_dollars = $faker->randomFloat(2, '5', '500');
    return [
        'item_id' => 1,
        'order_id' => 1,
        'price_dollars' => $price_dollars,
        'qty' => 1,
        'description' => $faker->paragraph
    ];
});

$factory->define(\App\ShippingType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(\App\Shipping::class, function (Faker\Generator $faker) {
    $shipping_dollars = $faker->randomFloat(2, '2', '10');
    return [
        'shipping_type_id' => 1,
        'name' => $faker->sentence,
        'price_dollars' => $shipping_dollars,
        'is_active' => 1,
    ];
});

$factory->define(\App\Photo::class, function (Faker\Generator $faker) {
    $name = time() . '-' . $faker->word . $faker->fileExtension;
    return [
        'item_id' => 1,
        'is_primary' => 0,
        'name' => $name,
        'path' => 'uploads/photos/' . $name,
        'thumbnail_path' => 'uploads/photos/tn-' . $name
    ];
});