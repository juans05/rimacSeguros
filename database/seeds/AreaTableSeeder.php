<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 12/04/2015
 * Time: 22:09
 */
use Faker\Factory as faker;
use Illuminate\Database\Seeder;

class areaTableSeeder extends Seeder {
    public function run()
    {

        \DB::table('area')->insert(array(
            'nombre_area'=>'FFVV WORKSITE',
            'usucrea'=>'ptec0127@rimac.com.pe'
        ));
        \DB::table('area')->insert(array(
            'nombre_area'=>'FFVV SALUD',
            'usucrea'=>'ptec0127@rimac.com.pe'
        ));
        \DB::table('area')->insert(array(
            'nombre_area'=>'FFVV RENTAS VITALICIAS',
            'usucrea'=>'ptec0127@rimac.com.pe'
        ));
        \DB::table('area')->insert(array(
            'nombre_area'=>'FFVV VIDA',
            'usucrea'=>'ptec0127@rimac.com.pe'
        ));
        \DB::table('area')->insert(array(
            'nombre_area'=>'FFVV MULTISEGUROS',
            'usucrea'=>'ptec0127@rimac.com.pe'
        ));
    }
}