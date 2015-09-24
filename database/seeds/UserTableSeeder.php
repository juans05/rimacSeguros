<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 31/03/2015
 * Time: 23:00
 */

use Faker\Factory as faker;
use Illuminate\Database\Seeder;
class userTableSeeder extends Seeder {
    public function run()
    {




        \DB::table('users')->insert(array(

            'name'=>'Victor Gonzales',
            'email'=>'ptec0129@rimac.com.pe',
            'password'=>\Hash::make('secret')

        ));
        \DB::table('users')->insert(array(

        'name'=>'Javier Lozano',
        'email'=>'ptec0156@rimac.com.pe',
        'password'=>\Hash::make('secret')

         ));
        \DB::table('users')->insert(array(

            'name'=>'Angel Quispe',
            'email'=>'xt0019@rimac.com.pe',
            'password'=>\Hash::make('secret')

        ));
        \DB::table('users')->insert(array(

            'name'=>'Jorge Nuñez',
            'email'=>'xt0030@rimac.com.pe',
            'password'=>\Hash::make('secret')

        ));
        \DB::table('users')->insert(array(

            'name'=>'Lazaro Rivera',
            'email'=>'xt0025@rimac.com.pe',
            'password'=>\Hash::make('secret')

        ));
        \DB::table('users')->insert(array(

            'name'=>'Fernando Tamashiro',
            'email'=>'ptec0155@rimac.com.pe',
            'password'=>\Hash::make('secret')

        ));
        \DB::table('users')->insert(array(

            'name'=>'Heber',
            'email'=>'ptec0176@rimac.com.pe',
            'password'=>\Hash::make('secret')

        ));




    }
}