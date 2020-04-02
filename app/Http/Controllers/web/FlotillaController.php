<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\ClienteRequest;
use App\Cliente ;
use App\Tarjeta ;
use App\Ubicacion ;
use App\Membresia;
use App\TarjetaCC ;

class FlotillaController extends Controller
{
    protected $estatusCliente=["values"=>["1"=>"Activo","0"=>"Suspendido"],"default"=>"1"];
    protected $flotilla=["values"=>["1"=>"Si","0"=>"No"],"default"=>"0"];
    protected $sexo=["values"=>["M"=>"Hombre","F"=>"Mujer"],"default"=>"M"];

    //Para buscador
    protected $adicional=["values"=>["1"=>"Si","0"=>"No"],"default"=>"0"];

    //Para Tabla Resultados
    protected $tblEstatus=["1"=>"Activo","0"=>"Suspendido"];
    protected $tblAdicional=["1"=>"SI","0"=>"No"];

    public function index()
    {

    

    }

    public function search(Request $request)
    {
         
         
        $clientes = DB::table('clientes')
            ->join('tarjetas', 'clientes.id_cliente', '=', 'tarjetas.id_cliente')            
            ->select('clientes.*', 'tarjetas.tarjeta','tarjetas.adicional')
            ->where(function ($query) use ($request) {
                
                $query->where(function ($query) use ($request) { 
                        $query->where(DB::raw("CONCAT(clientes.nombre, ' ', paterno,' ',materno)"), 'LIKE', '%'. $request->input('q').'%')
                        ->orWhere(DB::raw("CONCAT(clientes.nombre, ' ', paterno)"), 'LIKE', '%'. $request->input('q').'%')
                        ->orWhere(DB::raw("CONCAT(clientes.nombre)"), 'LIKE', '%'. $request->input('q').'%')
                        ->orWhere(DB::raw("CONCAT(clientes.paterno)"), 'LIKE', '%'. $request->input('q').'%')
                        ->orWhere(DB::raw("CONCAT(clientes.materno)"), 'LIKE', '%'. $request->input('q').'%');
                })               
                        
                    ->orWhere('tarjetas.tarjeta', '=', $request->input('q',''));
                })            
            ->where('clientes.estatus', '=', $request->input('estatus',1))            
             ->when($request->input('adicional'), function ($query) {
                    return $query->whereNotNull('adicional');
                }, function ($query) {
                    return $query->where('adicional', 0);
                })
             ->orderBy('clientes.nombre', 'ASC')
             ->orderBy('clientes.paterno', 'ASC')
             ->orderBy('clientes.materno', 'ASC')
            ->paginate(5);

            $clientes->appends($request->except("_token"));

       return view('cliente.search',
            array(          
                "clientes"=>$clientes,
                "estatusCliente"=>$this->estatusCliente,
                "adicional"=>$this->adicional,
                "request"=>$request->all(),
                "tblEstatus"=>$this->tblEstatus,
                "tblAdicional"=>$this->tblAdicional,                
                )
        );
    
       
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $cliente=Cliente::findOrFail($id);        
        $tarjetas=Tarjeta::where('id_cliente',$id)->get();


        return view('flotilla.create',
            array(
                "cliente"=>$cliente,                                
                "tarjetas"=>$tarjetas,
                
        )
    );        
 
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteRequest $request)
    {
    	
        //Crear Tarjeta
        $tarjeta = new Tarjeta;        
        if($response=$this->createUpdateTarjeta($request,$tarjeta,true))
            return $response;

        return redirect()->action('web\FlotillaController@show',$request->id_cliente)->with('statusOK', 'Tarjeta Creada');		
       
        
    }
         

    function createUpdateTarjeta($request,$tarjeta,$create)
    {
        

         if($create)
        {
            
           //Buscar Que tarjeta exista en CC
            $tarjetaCC = TarjetaCC::where('tarjeta', '=',  $request->tarjeta)->first();
            
            if ($tarjetaCC === null) 
                return back()->withInput()->with('statusFail', 'No existe Tarjeta: '.$request->tarjeta);   

            //Buscar que tarjeta no este asiganada a otro cliente
            $tarjeta = Tarjeta::where('tarjeta', '=',  $request->tarjeta)->first();
         
            if ($tarjeta) 
                return back()->withInput()->with('statusFail', 'Tarjeta asignada a otro cliente: '. $request->tarjeta);
         }   
        
  

        if($create)
        {
            //Crear tarjeta
            $tarjeta = new Tarjeta;        
            $tarjeta->id_tarjeta = $tarjetaCC->id_tarjeta;
            $tarjeta->tarjeta = $request->tarjeta;
            $tarjeta->id_cliente = $request->id_cliente;
            $tarjeta->fecha_creacion = date('Y-m-d H:i:s');                    
        }
                     
        $tarjeta->nombre = $request->nombre;
        $tarjeta->adicional = true;
        $tarjeta->estatus = 1;//$request->estatus;        
        $tarjeta->fecha_actualizacion = date('Y-m-d H:i:s');
        $tarjeta->save();  

        
        

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
               
       $cliente=Cliente::findOrFail($id);        
        $tarjetas=Tarjeta::where('id_cliente',$id)->get();


        return view('flotilla.show',
            array(
                "cliente"=>$cliente,                                
                "tarjetas"=>$tarjetas,
                
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $tarjeta=Tarjeta::findOrFail($id);        
        $cliente=Cliente::where('id_cliente',$tarjeta->id_cliente)->first();


        return view('flotilla.edit',
            array(
            	"tarjeta"=>$tarjeta,
                "cliente"=>$cliente,                                
                
                
        )
    );        


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         
        //Actualizar Tarjeta
        $tarjeta=Tarjeta::findOrFail($id);
        if($response=$this->createUpdateTarjeta($request,$tarjeta,false))
            return $response;

        return redirect()->action('web\FlotillaController@show',$request->id_cliente)->with('statusOK', 'Tarjeta Actualizada');		
        
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    
}
