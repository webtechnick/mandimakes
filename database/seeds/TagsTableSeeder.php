<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'New'],
            ['name' => 'Featured'],
            ['name' => 'Dragon'],
        ];

        foreach ($data as $tag) {
            Tag::create($tag);
        }
    }
}
