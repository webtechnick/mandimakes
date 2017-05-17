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
            ['name' => 'Dragon'],
        ];

        foreach ($data as $tag) {
            factory(Tag::class)->create($tag);
        }
    }
}
