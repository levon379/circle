<?php

use App\Admin\Specification;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SpecificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $arr = array(
            "Thickness",
            "Tensile strength at break",
            "Elongate at break",
            "Peel cling",
            "Pre stretch (max)",
            "Pre stretch (guaranteed)",
        );
        $specification = array();

        foreach ($arr as $key) {
            $now = Carbon::now();
            $specification[] = [
                'name' => $key,
                'updated_at' => $now,
                'created_at' => $now,
            ];
        }
        Specification::insert($specification);
    }
}
