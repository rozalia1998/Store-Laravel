<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;

class SubCatSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubCategory::create([[
            'category_id'=>'2',
            'name'=>'Laptops'
        ],[
            'category_id'=>'2',
            'name'=>'Mobiles'
        ]]);
    }
}
