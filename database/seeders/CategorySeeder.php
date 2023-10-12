<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = array(
            [
                'name'=>'Category 1',
                'status' => true,
            ],
            [
                'name'=>'Category 2',
                'status' => true,
            ],
        );


        foreach($categories as $category){
            Category::updateOrCreate($category);
        }
    }
}
