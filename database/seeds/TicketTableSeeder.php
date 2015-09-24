<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 31/03/2015
 * Time: 23:00
 */

use Faker\Factory as faker;
use Illuminate\Database\Seeder;
class ticketTableSeeder extends Seeder {
    public function run()
    {
        $faker=Faker::create();







        for($i=1;$i<30;$i++)
        {


            \DB::table('persona_tickets')->insert(array(
                'ticket_id'=>$faker->unique()->numberBetween($min = 1, $max = 30),
                'persona_id'=>$faker->unique()->numberBetween($min = 6, $max = 30),
                'usucrea'=>'ptec0127@rimac.com.pe'
            ));




        }

    }
}