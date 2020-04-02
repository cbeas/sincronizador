<?php

namespace App\Http\Controllers\web;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteRequest;
use App\Cliente ;
use App\Tarjeta ;
use App\Ubicacion ;
use App\Membresia;
use App\TarjetaCC ;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function create()
    {
        $ubicaciones=Ubicacion::where('estatus',1)->get();
        $membresias=Membresia::where('estatus',1)->get();
        
        return view('cliente.create',
            array(
                "ubicaciones"=>$ubicaciones,
                "membresias"=>$membresias,                
                "estatusCliente"=>$this->estatusCliente,               
                "flotilla"=>$this->flotilla,                
                "sexo"=>$this->sexo
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

        //Crear cliente
        $cliente = new Cliente;        
        if($response=$this->createUpdateCliente($request,$cliente,true))
            return $response;

       
        
         return redirect("/cliente/search")->with('statusOK', 'Cliente Creado');
    }

    function createUpdateCliente($request,$cliente,$create)
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
        
        $cliente->nombre = $request->nombre;
        $cliente->paterno = $request->paterno;        
        $cliente->materno = $request->materno;
        $cliente->correo = $request->email;
        $cliente->celular = $request->celular;
        $cliente->estatus = $request->estatus;
        $cliente->flotilla = $request->flotilla;        
        $cliente->id_memebresia = $request->membresia;        
        $cliente->sexo = $request->sexo;
        $cliente->id_ubicacion_inicial = $request->ubicacion;
        $cliente->fecha_actualizacion = date('Y-m-d H:i:s');
        if($create)
        {
            $cliente->id_tarjeta_principal = $tarjetaCC->id_tarjeta;               
            $cliente->saldo = 0;                    
            $cliente->fecha_creacion = date('Y-m-d H:i:s');                    
        }
        
        $cliente->save();



        if($create)
        {
            //Crear tarjeta
            $tarjeta = new Tarjeta;        
            $tarjeta->id_tarjeta = $tarjetaCC->id_tarjeta;
            $tarjeta->tarjeta = $request->tarjeta;
            $tarjeta->id_cliente = $cliente->id_cliente;
            $tarjeta->fecha_creacion = date('Y-m-d H:i:s');                    
        }
        else
        {
            $tarjeta=Tarjeta::where('id_tarjeta',$cliente->id_tarjeta_principal)->first();        
        }    
                        
        $tarjeta->nombre = $request->nombre;
        $tarjeta->adicional = false;
        $tarjeta->estatus = $request->estatus;        
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $cliente=Cliente::findOrFail($id);
        $ubicaciones=Ubicacion::where('estatus',1)->get();
        $membresias=Membresia::where('estatus',1)->get();
        $tarjeta=Tarjeta::where('id_tarjeta',$cliente->id_tarjeta_principal)->first();


        return view('cliente.edit',
            array(
                "cliente"=>$cliente,
                "ubicaciones"=>$ubicaciones,
                "membresias"=>$membresias,                
                "estatusCliente"=>$this->estatusCliente,               
                "flotilla"=>$this->flotilla,                
                "sexo"=>$this->sexo,
                "tarjeta"=>$tarjeta,
                
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
         $cliente=Cliente::findOrFail($id);

          //actualizar cliente
        if($response=$this->createUpdateCliente($request,$cliente,false))
            return $response;

       
        
         return redirect("/cliente/search")->with('statusOK', 'Cliente Actualizado');
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
