<?php namespace App\Http\Controllers;

use App\Aplicativo;
use App\aplicativo_ticket_persona;
use App\Cuenta;
use App\Http\Requests\CreatePersonaRequest;
use App\Http\Requests\CreateCuentaRequest;
use App\persona_ticket;
use App\Ticket;
use Illuminate\Http\Request;
use App\Persona;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class PersonaController extends Controller {


    public function __construct()
    {
       $this->middleware('auth');
    }
	public function index(Request $rq)
    {
       $paginador=Persona::consulta();
        return view('persona.lista',compact('paginador'));
	}

    public function  busquedaAvanzada(Request $rq){
        $paginador="";
        switch($rq->TipBusqu){
            case 1:
                $paginador= Persona::BuscarXDNI($rq->name);
                break;
            case 2:
                $paginador=Persona::buscarXNombre($rq->name);
                break;
        }
       return view('persona.'.$rq->pantalla,compact('paginador'));
    }
    public function  busquedaAvanzadaVincular(Request $rq){
        $paginador="";
        switch($rq->TipBusqu){
            case 1:
                $paginador= Persona::BuscarXDNILIstaPersona($rq->name);
                break;
            case 2:
                $paginador=Persona::buscarXNombreListarPersonas($rq->name);
                break;
        }
        return view('persona.'.$rq->pantalla,compact('paginador'));
    }

	public function create()
	{
        $aplicativo= Aplicativo::all();

        return view('persona.create_person',compact('aplicativo'));
	}



	public function store(CreatePersonaRequest $request)
	{
       $usuCrea=\Auth::user()->email;
        $persona=Persona::insertPersona($request);
        $idticket=Ticket::registrar($request->ticket,$usuCrea);//registrar ticket
        $idPersonaTicket=persona_ticket::regiser_PersonaTicket($persona->id,$idticket, $usuCrea);//registrar ticket persona
        $aplicativo = Input::get('aplicativo');
        for($i=0;$i<count($aplicativo);$i++){
            $cuenta=new aplicativo_ticket_persona();
            $cuenta->aplicativo_id=$aplicativo[$i];
            $cuenta->ticket_persona_id= $idPersonaTicket->id;
            $cuenta->usucrea=$usuCrea;
            $cuenta->estado="0";
            $cuenta->save();
        }
        $numeroTicket=persona_ticket::ticketPesona($persona->id,0);
        $personaxAplicativo=Cuenta::CuentaPersona($persona->id);//todos los aplicativos registrados en la tabla cuenta de la persona
        $data=Ticket::buscarAplicativoRelacionados($persona->id);
        $mensaje="";
         return view('persona.create_Aplicativo_person',compact('persona','data','personaxAplicativo','mensaje','numeroTicket'));
	}


	public function show($id)
	{
		//
	}


	public function edit($id)
	{
		$persona=Persona::findOrFail($id);

        return view('persona.edit_person',compact('persona'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request)
	{

        $usuCrea=\Auth::user()->email;
        $aplicativo_persona=Persona::PersonaXAplicativo($request->id_persona);
        $aplicativo = Input::get('aplicativo');
        for($i=0;$i<count($aplicativo);$i++){
        for($a=0;$a<count($aplicativo_persona);$a++){
                if($aplicativo[$i]!=$aplicativo_persona[$a]->id){
                    $cuenta=new aplicativo_ticket_persona();
                    $cuenta->aplicativo_id=$aplicativo[$i];
                    $cuenta->ticket_persona_id= $request->nomticket;
                    $cuenta->usucrea=$usuCrea;
                    $cuenta->estado="0";
                    $cuenta->save();

                }
            break;
            }
        }
        $aplicativo_persona=Persona::PersonaXAplicativo($request->id_persona);
        //dd($aplicativo_persona);
/*
        return Redirect::route('persona.index');*/

	}

	/**
	 * Remove the specified9 resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public function cerrarAplicativoPersona($slug){


        $ticket_persona=persona_ticket::find($slug);
        $ticket_persona->estado_persona_ticket=2;
        $ticket_persona->save();
        $paginador=Persona::consulta();


        return view('persona.lista',compact('paginador'));
    }
    public function registerAplicativoPersona(CreateCuentaRequest $request){
        return view('persona.create_Aplicativo_person',compact('persona','data','personaxAplicativo','mensaje'));

    }

    public function  listar_personas(){

        $paginador=Persona::consulta2();
        return view('persona.lista_personas',compact('paginador'));
    }

    public function  vinculacion_nuevo_ticket_persona($idPersona,$ticketPadre){

        $aplicativo= Aplicativo::all();
        $persona=Persona::find($idPersona);
        $ticketPadre2=$ticketPadre;

        return view('persona.vinculacion_ticket_person',compact('aplicativo','persona','ticketPadre2'));
       // echo $ticketid;
    }

    public function  modificar_cuenta($idpersona){
        $persona=Persona::findOrFail($idpersona);
        $ticket=Persona::ticketxPersonaxid($idpersona);
      /*  $aplicativos2=array();
        $persona=Persona::findOrFail($idpersona);
        $ticket=Persona::ticketxPersonaxid($idpersona);
        $aplicativo_persona=Persona::PersonaXAplicativo($idpersona);
        $aplicativo= Aplicativo::all();
             for($i=0;$i<=count($aplicativo)-1;$i++){
                 $contador=0;
                 for($a=0;$a<=count($aplicativo_persona)-1;$a++) {
                    if($aplicativo[$i]->id==$aplicativo_persona[$a]->id) {
                        $aplicativos2[]=array(
                            'id_aplicativo'=>$aplicativo[$i]->id,
                            'nombre_aplicativo'=>$aplicativo[$i]->nombre_aplicativo,
                            'estado'=>'true'
                        );
                        $contador=1;
                    }
                 }
                if($contador==0){
                    $aplicativos2[]=array(
                        'id_aplicativo'=>$aplicativo[$i]->id,
                        'nombre_aplicativo'=>$aplicativo[$i]->nombre_aplicativo,
                        'estado'=>'false'

                    );
                }
            }
      return view('persona.edit_person',compact('persona','aplicativos2','ticket'));*/

        return view('persona.edit_person',compact('ticket','persona'));
    }

    public function EliminarPersona($idTicket,Request $rq){
        $persona_ticket=persona_ticket::find($idTicket);
        $ticket= Ticket::find($persona_ticket->ticket_id);
        if($ticket->ticket_padre!=0){
            Persona::eliminarTicket_persona($idTicket,$persona_ticket->persona_id);
            $mensaje=  $ticket->nroticket . ' fue eliminado ';
            $persona_ticket->delete();
            $ticket->delete();
        }else{
            $mensaje= 0;
        }
        if($rq->ajax()) {
            return  $mensaje;
        }

       /* Session::flash('mesanje',$mensaje);
        return redirect()->route('persona.edit_person');*/
    }


    public function getInfo(){
        return view('persona.info');
    }

}
