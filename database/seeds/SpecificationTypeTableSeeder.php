<?php

use App\Admin\SpecificationType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SpecificationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $arr = array(
            'units',
            'value',
            'tolerance',
            'method'
        );
        $type= array();

        foreach ($arr as $key) {
            $now = Carbon::now();
            $type[] = [
                'name' => $key,
                'updated_at' => $now,
                'created_at' => $now,
            ];
        }
        SpecificationType::insert($type);
    }
}
