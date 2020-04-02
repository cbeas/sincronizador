<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TarjetaCC ;
use App\Tarjeta ;
use App\Cliente ;
use App\Consumo ;
use App\TiendaCC ;
use App\BdCC ;

use Illuminate\Support\Facades\DB;

class CompuCController extends Controller
{
    public function receiveTarjetasNuevas(Request $request)
    {
		//Tarjetas Creadas en local y en nube no
		//Recibe arreglo de Tarjetas
		//Retorna Tarjetas Registradas
	

		$i=0;
		$response=array();
		if(is_array($request->tarjetas))
		{
				foreach ($request->tarjetas as $key => $tarjeta) 
				{
					
					if(!$tarCC =TarjetaCC::where('tarjeta', $tarjeta)->first())
						$tarCC = new TarjetaCC;
					
				    $tarCC->tarjeta = $tarjeta;
				    $tarCC->fecha_sync_nueva_tarjeta = date('Y-m-d H:i:s');
				    $tarCC->save();

					$response[$i]["id_tarjeta"]=$tarCC->id_tarjeta; 
					$response[$i]["tarjeta"]=$tarCC->tarjeta; 
					$response[$i]["fecha_sync_nueva_tarjeta"]=$tarCC->fecha_sync_nueva_tarjeta; 
							
					$i++;
				}

		}	

	    		
        return response()->json(
        	array(
        		"method"=>__FUNCTION__,
				"request"=>$request->all(),
				"response"=>$response
			 ), 200);
    }
	 public function sendTarjetasActualizadas(Request $request)
    {
		//Tarjetas actualizadas en estatus en nube
		//Recibe vacio
		//Retorna Tarjetas Actualizadas
		
		
		$response = DB::table('tarjetas')->select('id_tarjeta', 'tarjeta','estatus','fecha_sync_update_tarjeta')
		->where('fecha_sync_update_tarjeta','<=',DB::raw('fecha_actualizacion'))->get();

		//Mandar fecha actual de sincronizacion
		foreach ($response as $tarjeta) 
			$tarjeta->fecha_sync_update_tarjeta= date('Y-m-d H:i:s');
			
          return response()->json(array("method"=>__FUNCTION__,"response"=>$response), 200);
    }
	 public function receiveSyncOkTarjetasActualizadas(Request $request)
    {
		//Recibe estatus de sincronizacion de tarjetas actualizadas
		//Recibe Fecha de tarjetas actualizadas
		//Retorna vacio
		
		$i=0;
		$response=array();
		if(is_array($request->tarjetas))
		{
				foreach ($request->tarjetas as  $req) 
				{
					
					if($tar =Tarjeta::where('tarjeta', $req['tarjeta'])->first())
					{
						
						//Guardar fecha sincronizacion			
						$tar->fecha_sync_update_tarjeta = $req["fecha_sync_update_tarjeta"];
				    	$tar->save();

				    	$response[$i]["tarjeta"]=$tar->tarjeta; 						
						$response[$i]["fecha_sync_update_tarjeta"]=$tar->fecha_sync_update_tarjeta; 
							
						$i++;



					}	
					

				}

		}		    	        

          return response()->json(
        	array("method"=>__FUNCTION__,
				"request"=>$request->all(),
				"response"=>$response
			 ), 200);
		
		
        
	}
	 public function sendTarjetasPorMigrarSaldo(Request $request)
    {
		//Tarjetas creadas en nube aun no sincronizado saldo
		//Retorna Tarjetas y BD inicial
		
    	$response = DB::table('tarjetas')->select('id_cliente','id_tarjeta', 'tarjeta','adicional')
    	->where('estatus',1)
		->where('fecha_sync_por_migrar','<=',DB::raw('fecha_creacion'))->get();


		
		foreach ($response as $tarjeta) 
		{
			//Mandar fecha actual de sincronizacion
			$tarjeta->fecha_sync_por_migrar= date('Y-m-d H:i:s');

			//Obtener Id BD inicial
			$result=DB::table('clientes')
            ->join('ubicaciones', 'clientes.id_ubicacion_inicial', '=', 'ubicaciones.id_ubicacion')            
            ->select('ubicaciones.id_bd')
            ->where('clientes.id_cliente',$tarjeta->id_cliente)
            ->first();

            if($result)
            	$tarjeta->id_bd=$result->id_bd;
            else
            	$tarjeta->id_bd="";
            
			
           
		}

        return response()->json(array("method"=>__FUNCTION__,"response"=>$response), 200);		
		
        
    }
	 public function receiveSyncOkPorMigrarSaldo(Request $request)
    {
		//Recibe estatus de tarjetas por migrar saldo
		//Recibe Estatus
		//Retorna vacio
		

		$i=0;
		$response=array();
		if(is_array($request->tarjetas))
		{
				foreach ($request->tarjetas as  $req) 
				{
					
					if($tar =Tarjeta::where('id_tarjeta', $req['id_tarjeta'])->first())
					{
						
						//Guardar fecha sincronizacion			
						$tar->fecha_sync_por_migrar = $req["fecha_sync_por_migrar"];
				    	$tar->save();

				    	$response[$i]["id_tarjeta"]=$tar->id_tarjeta; 						
						$response[$i]["fecha_sync_por_migrar"]=$tar->fecha_sync_por_migrar; 
							
						$i++;



					}	
					

				}

		}		    	        

          return response()->json(
        	array("method"=>__FUNCTION__,
				"request"=>$request->all(),
				"response"=>$response
			 ), 200);
			}
	
	public function receiveSaldoInicial(Request $request)
    {
		//Recibe saldo inicial de la tarjeta
		//Recibe arreglo de Tarjetas con saldo inicial
		//Retorna Saldo inicial Registrado
		

		$i=0;
		$response=array();
		
		if(is_array($request->saldo_inicial))
		{
				foreach ($request->saldo_inicial as $req) 
				{
					
					if($tar =Tarjeta::where('id_tarjeta', $req["id_tarjeta"])->first())
					{						
					    $tar->fecha_sync_saldo_inicial= date('Y-m-d H:i:s');
					    $tar->saldo_migracion= $req["saldo_migracion"];
					    $tar->save();

					    $response[$i]["id_tarjeta"]=$tar->id_tarjeta; 						
						$response[$i]["fecha_sync_saldo_inicial"]=$tar->fecha_sync_saldo_inicial; 

						


						$i++;	
					}	
						
				
				}

		}	

	    		
        return response()->json(
        	array("method"=>__FUNCTION__,
				"request"=>$request->all(),
				"response"=>$response
			 ), 200);

		
    }
	public function sendSaldo(Request $request)
    {
		//Saldo actualizado en la nube
		//Retorna saldo por cliente, id_tarjeta y  fecha_sync_saldo
		
		$response = DB::table('clientes')
		->join('tarjetas', 'clientes.id_tarjeta_principal', '=', 'tarjetas.id_tarjeta')            
		->select('clientes.id_cliente', 'clientes.id_tarjeta_principal as id_tarjeta', 'tarjetas.tarjeta','saldo','fecha_sync_saldo')
		->where('fecha_sync_saldo','<=',DB::raw('fecha_actualizacion_saldo'))->get();


		//Mandar fecha actual de sincronizacion
		foreach ($response as $tarjeta) 
			$tarjeta->fecha_sync_saldo= date('Y-m-d H:i:s');
			
          return response()->json(array("method"=>__FUNCTION__,"response"=>$response), 200);
		
    }
	 public function receiveSyncOkSaldo(Request $request)
    {
		//Recibe estatus de saldo actualizado
		//Recibe Estatus
		//Retorna vacio
		
		$i=0;
		$response=array();
		if(is_array($request->clientes))
		{
				foreach ($request->clientes as  $req) 
				{
					
					if($cte =Cliente::where('id_cliente', $req['id_cliente'])->first())
					{
						
						//Guardar fecha sincronizacion			
						$cte->fecha_sync_saldo = $req["fecha_sync_saldo"];
				    	$cte->save();

				    	$response[$i]["id_cliente"]=$cte->id_cliente; 						
						$response[$i]["fecha_sync_saldo"]=$cte->fecha_sync_saldo; 
							
						$i++;



					}	
					

				}

		}		    	        

          return response()->json(
        	array("method"=>__FUNCTION__,
				"request"=>$request->all(),
				"response"=>$response
			 ), 200);
		

		
	}
	public function receiveConsumos(Request $request)
    {
		//Recibe consumos compucaja
		//Recibe arreglo de consumos en compucaja
		//Retorna consumos registrados
		

		$i=0;
		$response=array();
		if(is_array($request->consumos))
		{
				foreach ($request->consumos as $consumo) 
				{
					
					//Obtener Id de Ubicacion 
					$result=DB::table('ubicaciones')		            
		            ->select('id_ubicacion')
		            ->where('id_tda',$consumo["id_tda"])
		            ->first();

					//Obtener id_cliente e id_tarjera
					$cte=DB::table('tarjetas')		            
		            ->select('id_tarjeta','id_cliente')
		            ->where('tarjeta',$consumo["tarjeta"])
		            ->first();


		            if($result && $cte)
		            {	

						if(!$con =
							Consumo::where('origen', "tienda")
							->where('id_ubicacion', $result->id_ubicacion)
							->where('hash_local', $consumo["hash_local"])->first()
						   )
								$con = new Consumo;
						
						$con->origen = "tienda";						
						$con->id_ubicacion = $result->id_ubicacion;
						$con->hash_local = $consumo["hash_local"];
						$con->id_cliente = $cte->id_cliente;
						$con->id_tarjeta = $cte->id_tarjeta;
						$con->folio = $consumo["folio"];
						$con->monto = $consumo["monto"];
						$con->tipo = $consumo["tipo"];
						$con->fecha_consumo = $consumo["fecha_consumo"];					 
					    $con->fecha_sync_consumo = date('Y-m-d H:i:s');
					    $con->save();

						$response[$i]["hash_local"]=$con->hash_local; 					
						$response[$i]["fecha_sync_consumo"]=$con->fecha_sync_consumo; 
								
						$i++;
					}	
				}

		}	

	    		
        return response()->json(
        	array("method"=>__FUNCTION__,
				"request"=>$request->all(),
				"response"=>$response
			 ), 200);


		
    }

	public function receiveTiendas(Request $request)
    {
		//Recibe Tiendas nuevas o modificadas en CC
		//Recibe arreglo de tiendas
		//Retorna tiendas registradas
		

		$i=0;
		$response=array();
		if(is_array($request->tiendas))
		{
				foreach ($request->tiendas as  $tienda) 
				{
					
					if(!$tda=TiendaCC::where('id_tda', $tienda["id_tda"])->first())
						$tda = new TiendaCC;
					
					$tda->id_tda = $tienda["id_tda"];
				    $tda->nombre = $tienda["nombre"];
				    $tda->fecha_sync_establecimiento = date('Y-m-d H:i:s');
				    $tda->save();

				    //Neceario enviar id desde array	
					$response[$i]["id_tda"]=$tienda["id_tda"]; 					
					$response[$i]["fecha_sync_establecimiento"]=$tda->fecha_sync_establecimiento; 
							
					$i++;
				}

		}	

	    		
        return response()->json(
        	array("method"=>__FUNCTION__,
				"request"=>$request->all(),
				"response"=>$response
			 ), 200);

		
    }
    public function sendBd(Request $request)
    {
		//Envia BD de CC
		//Recibe vacio



		$response = DB::table('bds_cc')->select('id_bd', 'nombre','bd','estatus')
		->where('fecha_sync_bd','<=',DB::raw('fecha_actualizacion'))->get();


		//Mandar fecha actual de sincronizacion
		foreach ($response as $bd) 
			$bd->fecha_sync_bd= date('Y-m-d H:i:s');
			
          return response()->json(array("method"=>__FUNCTION__,"response"=>$response), 200);

    }
    
     public function receiveSyncOkBd(Request $request)
    {
		//Recibe estatus de sincronizacion de BD, ultimo mensaje y ultima fecha de conexion
		//Retorna vacio
		$i=0;
		$response=array();
		if(is_array($request->bds))
		{
				foreach ($request->bds as  $req) 
				{
					
					if($bd =BdCC::where('id_bd', $req['id_bd'])->first())
					{

						//Guardar fecha sincronizacion			
						$bd->fecha_sync_bd = $req["fecha_sync_bd"];
						$bd->ultima_conexion = $req["ultima_conexion"];
						$bd->last_message = $req["last_message"];
				    	$bd->save();

				    	$response[$i]["id_bd"]=$bd->id_bd; 						
						$response[$i]["fecha_sync_bd"]=$bd->fecha_sync_bd; 
							
						$i++;



					}	
					

				}

		}		    	        

          return response()->json(
        	array(
        		"method"=>__FUNCTION__,
				"request"=>$request->all(),
				"response"=>$response
			 ), 200);
		
		
        
	}



}
