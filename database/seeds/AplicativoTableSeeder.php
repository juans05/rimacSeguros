<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 31/03/2015
 * Time: 23:00
 */
use Faker\Factory as faker;
use Illuminate\Database\Seeder;

class aplicativoTableSeeder extends Seeder {
    public function run()
    {

        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'acsel x'
        ));
        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'acsel e'
        ));
        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'riminter'
        ));\DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'rimac salud'
        ));
        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'rel'
        ));
        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'sram'
        ));
        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'pivotal'
        ));
        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'a'
        ));
        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'red'
        ));  \DB::table('aplicativo')->insert(array(
             'nombre_aplicativo'=>'codigo de llamadas'
         ));
        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'lotus'
        ));
        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'riminter'
        ));
        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'jubilare'
        ));
        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'bizagi'
        ));
        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'vul'
        ));
        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'DWR'
        ));

        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'carta Garantia'
        ));

        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'vantive'
        ));

        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'Sap Pensiones'
        ));

        \DB::table('aplicativo')->insert(array(
            'nombre_aplicativo'=>'Sap CRM'
        ));
        \DB::table('users')->insert(array(

            'name'=>'Juan',
            'email'=>'ptec0127@rimac.com.pe',
            'password'=>\Hash::make('secret')

        ));
    }
}