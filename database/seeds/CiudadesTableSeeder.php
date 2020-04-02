<?php

use Illuminate\Database\Seeder;

class CiudadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados=array(
        		["estado"=>"Aguascalientes",
        			"ciudades"=>
	        		array(
		        	'Aguascalientes', 
					'Asientos', 
					'Calvillo', 
					'Cosío', 
					'Jesús María', 
					'Pabellón de Arteaga', 
					'Rincón de Romos', 
					'San José de Gracia', 
					'Tepezalá', 
					'El Llano', 
					'San Francisco de los Romo', 
					)]


	        );//Fin array ciudades por estado


		for($i=0;$i<count($estados);$i++)
		{
		

			$estado= DB::table('estados')
			->select('id_estado')
			->where('estado','=',$estados[$i]["estado"])->first();

			foreach ($estados[$i]["ciudades"] as $ciudad)			
			{	
					//echo $ciudad."-".$estado->id_estado."\n";
				DB::table('ciudades')->updateOrInsert(
        		["id_estado"=>1,"ciudad"=>$ciudad]);        		
        	}	

		}




    }
}
