<?php

use App\Admin\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = array("Stretches", "Agriculture", "Film");
        $category = array();

        foreach ($arr as $key){
            $now = Carbon::now();
            $category[] = [
                'name' => $key,
                'updated_at' => $now,
                'created_at' => $now,
            ];
        }
        Category::insert($category);
    }
}
