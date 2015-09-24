<?php namespace App\Http\Controllers;

use App\Aplicativo;
use App\Area;
use App\Http\Requests;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTicketRequest;
use App\aplicativo_ticket;
use App\Cuenta;
use App\persona_ticket;
use App\aplicativo_ticket_persona;
use App\Ticket;
use App\Persona;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;


class CuentaController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $rq)
	{
        $usuCrea=\Auth::user()->email;
        $aplicativo = Input::get('nomAplicativo');
        $numeroTicket = Input::get('nomticket');


        $persona=Persona::findOrFail($rq->persona_cuenta);
        if($this->validacionAplicativoRegistrado($aplicativo,$persona->id)==true)
        {
            $mensaje="";


            if($this->validacionAplicativoPerteneceTicket($numeroTicket,$aplicativo)){
               $cuenta= Cuenta::insertarCuenta($numeroTicket,$aplicativo,$persona->id,$rq->nombre_cuenta,$rq->clave,$usuCrea);
               $personaxAplicativo=Cuenta::CuentaPersona($persona->id);//todos los aplicativos registrados en la tabla cuenta de la persona
               $data=Ticket::buscarAplicativoRelacionados($persona->id);///todos los aplicativos registrados en el ticket
               $numCuenta=persona_ticket::ticketRelacionado_persona($persona->id);


                if($this->ValidacionTicketPorPersona($persona->id)==true) {//si la persona tiene mayor de 1 ticket
                    for($i=0;$i<=count($numCuenta)-1;$i++){
                        $aplicativoTicket=aplicativo_ticket_persona::where('ticket_persona_id','=',$numCuenta[$i]->id)->get();

                        if($this->validacionTicket($aplicativoTicket,$personaxAplicativo)==count($aplicativoTicket)){
                            $persona_tickets3=persona_ticket::find($numCuenta[$i]->id);//cierra persona_ticket
                            $persona_tickets3->estado_persona_ticket=1;
                            $persona_tickets3->save();
                        }
                    }
                }else{
                    for($i=0;$i<=count($numCuenta)-1;$i++){
                        $aplicativoTicket=aplicativo_ticket_persona::where('ticket_persona_id','=',$numCuenta[$i]->id)->get();
                        if($this->validacionTicket($aplicativoTicket,$personaxAplicativo)==true){
                            $persona_tickets3=persona_ticket::find($numCuenta[$i]->id);//cierra persona_ticket
                            $persona_tickets3->estado_persona_ticket=1;
                            $persona_tickets3->save();
                        }
                    }
                }

            }else{

                   $personaxAplicativo=Cuenta::CuentaPersona($persona->id);//todos los aplicativos registrados en la tabla cuenta de la persona
                    $data=Ticket::buscarAplicativoRelacionados($persona->id);
                    $mensaje="El aplicatvo que desea registrar NO esta en este Ticket :".$numeroTicket;
            }


        }else{
            $personaxAplicativo=Cuenta::CuentaPersona($persona->id);//todos los aplicativos registrados en la tabla cuenta de la persona
            $data=Ticket::buscarAplicativoRelacionados($persona->id);
            $mensaje="El Aplicativo se encuentra Registrado, favor de Registrar otro Aplicativo";
        }
        $numeroTicket=persona_ticket::ticketPesona($persona->id,0);
        return view('persona.create_Aplicativo_person',compact('persona','data','personaxAplicativo','mensaje','numeroTicket'));
    }

    public function  validacionTicket($aplicativoTicket,$aplicativoPersona){
            $contador=0;

            for($a=0;$a<=count($aplicativoTicket)-1;$a++){
                for($b=0;$b<=count($aplicativoPersona)-1;$b++){
                    if($aplicativoTicket[$a]->aplicativo_id==$aplicativoPersona[$b]->cuenta_aplicativo){
                        $contador=$contador+1;
                    }

                }
            }
            if(count($aplicativoTicket)==$contador){
                return true;
            }else{
                return  false;
            }


    }
    public function validacionAplicativoRegistrado($aplicativo,$idPersona){

        $cantidad=Cuenta::existeData($aplicativo,$idPersona);
        if(count($cantidad)>0){
            return false;
        }else{
            return true;
        }
    }
    public function ValidacionTicketPorPersona($idPersona){
        $cantidad=persona_ticket::Cantidad_ticket_persona($idPersona);
       if($cantidad>1){
            return true;
        }else{
            return false;
        }
       // dd($idTicket[0]->ticket_id);
    }
    public function validacionAplicativoPerteneceTicket($nroTicket,$idAplicativo){
            $cantidad=persona_ticket::Ticket_Aplicativo_existe($nroTicket,$idAplicativo);
            if($cantidad>0){
                return true;

            }else{
                return false;
            }
    }


    public function eliminarCuenta($idcuenta,$wo){

        $cuentas=Cuenta::find($idcuenta);
        $numCuenta=$cuentas->cuenta_persona;
        $cuentas->delete();
        $persona=Persona::findOrFail($numCuenta);
        $personaxAplicativo=Cuenta::CuentaPersona($numCuenta);//todos los aplicativos registrados en la tabla cuenta de la persona
        $data=Ticket::buscarAplicativoRelacionados($numCuenta);
        $numeroTicket=persona_ticket::ticketPesona2($numCuenta);
        for($i=0;$i<=count($numeroTicket)-1;$i++){

            if($numeroTicket[$i]->nroticket==$wo){

               if(count($data)>=count($personaxAplicativo))
                {
                    $id=persona_ticket::sacarIDTabla2($numeroTicket[$i]->id,$numCuenta);
                   // dd($id);
                    $ticket_persona=persona_ticket::find($id[0]->id);
                    $ticket_persona->estado_persona_ticket=0;
                    $ticket_persona->save();
                    break;
                }


            }
        }
        $numeroTicket=persona_ticket::ticketPesona($persona->id,0);
        $mensaje="";
        return view('persona.create_Aplicativo_person',compact('persona','data','personaxAplicativo','mensaje','numeroTicket'));

    }

    ///05/05/2015 cargar data masiva
    public function  cargarDataMasiva(Request $rq){
        set_time_limit(5000);
        $usuCrea=\Auth::user()->email;
       $idticket=Ticket::registrar($rq->nro_ticket,$usuCrea);//registrar ticket
        $file=\Illuminate\Support\Facades\Input::file("excel");
        $file->move("documentos",$file->getClientOriginalName());

        $paso=   $this->registrarDataExcelMasivo($file,$idticket,$usuCrea,$rq->nro_ticket);

        if($paso=true){
            $mensaje='Se registro con exito';
            return view('persona.persona_carga_Data',compact('mensaje'));
        }else{
            $mensaje='Error en el Registro, favor de Verificar el documento.';
            return view('persona.persona_carga_Data',compact('mensaje'));
        }
    }
        public function registrarDataExcelMasivo($file,$idticket,$usuCrea,$nroTicket){

            try{
                Excel::load('public/documentos/'.$file->getClientOriginalName(), function($archivo) use($idticket,$usuCrea,$nroTicket) {

                    $result=$archivo->get();
                    foreach($result as $key => $value) {
                        for($i=0;$i<count($value);$i++){
                            $existeDNI=Persona::where('dni',$value[$i]->dni);
                            if($existeDNI->count()==0){
                                $personaCompleta= $value[$key]->primer_nombre.' '.$value[$i]->segundo_nombre.' '.$value[$i]->apellido_paterno.' '.$value[$i]->apellido_materno;
                               $persona= Persona::insertPersonaMasivo($personaCompleta,$value[$i]->dni,$value[$i]->correo,$usuCrea);
                              $personaticket=persona_ticket::regiser_PersonaTicket_masivo($persona->id,$idticket, $usuCrea);//registrar ticket persona
                                $aplicativosxarea=Area::aplicativoxArea($value[$i]->codigo);

                                for($p=0;$p<count($aplicativosxarea)-1;$p++){

                                    $aplicativos=new aplicativo_ticket_persona();
                                    $aplicativos->aplicativo_id=$aplicativosxarea[$p]->aplicativo_id;
                                    $aplicativos->ticket_persona_id= $personaticket->id;
                                    $aplicativos->usucrea=$usuCrea;
                                    $aplicativos->estado=1;
                                    $aplicativos->save();
                                    $aplicativoNombre=$this->convertir($aplicativosxarea[$p]->nombre_aplicativo);
                                    if($value[$i]->$aplicativoNombre!=null){
                                        $this->creacioUsuario($aplicativoNombre,$value[$i]->$aplicativoNombre,$persona->id,$nroTicket);
                                    }
                                }
                            }else{
                                return false;
                                break;
                            }
                        }

                    }

               });
                return true;
               }
            catch (NotFoundHttpException $e) {
                return false;
            }

        }
    public function convertir($nombre){

        $nombre_verdadero="";
        switch($nombre){

            case "codigo de llamadas":
                $nombre_verdadero='llamada';
                break;
            case "acsel e":
                $nombre_verdadero='axcele';
                break;
            case "acsel x":
                $nombre_verdadero='acselx';
                break;
            case "carta Garantia":
                $nombre_verdadero='carta_garantia';
                break;
            case "rimac salud":
                $nombre_verdadero='rimac_salud';
                break;
            case "Sap CRM":
                $nombre_verdadero='sap_crm';
                break;
            case "Sap Pensiones":
                $nombre_verdadero='sap_pensiones';
                break;
            default:
                $nombre_verdadero=$nombre;
                break;

        }
        return $nombre_verdadero;
    }
    public function creacioUsuario($aplicativo,$usuario,$idUsuario,$ticket){
        $cuenta=new Cuenta();
        if($usuario!='') {
            switch ($aplicativo) {
                case 'acselx':
                    $cuenta->cuenta_aplicativo = '1';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;
                case 'acsele':
                    $cuenta->cuenta_aplicativo = '2';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;
                case 'riminter':
                    $cuenta->cuenta_aplicativo = '3';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;
                case 'rimac_salud':
                    $cuenta->cuenta_aplicativo = '4';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;
                case 'rel':
                    $cuenta->cuenta_aplicativo = '5';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;
                case 'sram':
                    $cuenta->cuenta_aplicativo = '6';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;
                case 'pivotal':
                    $cuenta->cuenta_aplicativo = '7';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;
                case 'red':
                    $cuenta->cuenta_aplicativo = '8';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;
                case 'llamada':
                    $cuenta->cuenta_aplicativo = '9';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;
                case 'lotus':
                    $cuenta->cuenta_aplicativo = '10';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;
                case 'jubilare':
                    $cuenta->cuenta_aplicativo = '11';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;
                case 'bizagi':
                    $cuenta->cuenta_aplicativo = '12';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;
                case 'vul':
                    $cuenta->cuenta_aplicativo = '13';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;
                case 'DWR':
                    $cuenta->cuenta_aplicativo = '14';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;

                case 'carta_garantia':
                    $cuenta->cuenta_aplicativo = '15';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;

                case 'vantive':
                    $cuenta->cuenta_aplicativo = '16';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;

                case 'sap_pensiones':
                    $cuenta->cuenta_aplicativo = '17';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;

                case 'sap_crm':
                    $cuenta->cuenta_aplicativo = '18';
                    $cuenta->cuenta_persona = $idUsuario;
                    $cuenta->cuenta_usu = $usuario;
                    $cuenta->clave = '';
                    $cuenta->ticket = $ticket;
                    break;

            }
        }
        $cuenta->save();
    }
    public function cargarData_excel(Request $rq){
        set_time_limit(5000);
        $usuCrea=\Auth::user()->email;
        $idticket=Ticket::registrar($rq->nro_ticket,$usuCrea);//registrar ticket
        $file=\Illuminate\Support\Facades\Input::file("excel");
        $file->move("documentos",$file->getClientOriginalName());

        $paso= $this->registrarDataExcel($file,$idticket,$usuCrea);

        if($paso=true){
            $mensaje='Se registro con exito';
            return view('persona.persona_carga_Data',compact('mensaje'));
        }else{
            $mensaje='Error en el Registro, favor de Verificar el documento.';
            return view('persona.persona_carga_Data',compact('mensaje'));
        }

    }
    public function registrarDataExcel($file,$idticket,$usuCrea){
        try{
            Excel::load('public/documentos/'.$file->getClientOriginalName(), function($archivo) use($idticket,$usuCrea)
            {
                $result=$archivo->get();
                foreach($result as $key => $value)
                {
                    for($i=0;$i<count($value);$i++){

                        $existeDNI=Persona::where('dni',$value[$i]->dni);
                        if($value[$i]->dni!='' ){
                            if($existeDNI->count()==0){
                                $nombre_completoPersona=$value[$i]->primer_nombre.' '.$value[$i]->segundo_nombre.' '.$value[$i]->apellido_paterno.' '.$value[$i]->apellido_materno;
                                $dni=$value[$i]->dni;
                                $email="";
                                $persona= Persona::insertPersonaMasivo($nombre_completoPersona,$dni,$email,$usuCrea);
                                $personaticket=persona_ticket::regiser_PersonaTicket($persona->id,$idticket, $usuCrea);//registrar ticket persona
                                $aplicativosxarea=Area::aplicativoxArea($value[$i]->codigo);
                                for($p=0;$p<count($aplicativosxarea);$p++){
                                    $aplicativos=new aplicativo_ticket_persona();
                                    $aplicativos->aplicativo_id=$aplicativosxarea[$p]->aplicativo_id;
                                    $aplicativos->ticket_persona_id= $personaticket->id;
                                    $aplicativos->usucrea=$usuCrea;
                                    $aplicativos->estado="";
                                    $aplicativos->save();
                                }
                            }
                            else{
                                $i++;
                            }
                        }else{
                            break;
                        }

                    }
                }

            })->get();

            return true;
        }catch (NotFoundHttpException $e){
            return false;
        }




    }
    public function cargarExcel(){

        $mensaje="";
        return view('persona.persona_carga_Data',compact('mensaje'));

    }
    public function cargarExcel_masiva(){

        $mensaje="";
        return view('persona.persona_carga_Data_masiva',compact('mensaje'));

    }
    public function  agregar_aplicativo_nuevo(CreateTicketRequest $request){
        $usuCrea=\Auth::user()->email;
        $persona=Persona::findOrFail($request->persona_cuenta);
        $idticket=Ticket::registrarHIjo($request->ticket,$request->ticket_padre,$usuCrea);//registrar ticket
        $idPersonaTicket=persona_ticket::regiser_PersonaTicket($persona->id,$idticket, $usuCrea);//registrar ticket persona
        $numeroTicket=$request->ticket;
        //registrar Aplicativos con el ticket;
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
        $data=Ticket::buscarAplicativoRelacionados($persona->id);///todos los aplicativos registrados en el ticket
        $mensaje="";
        return view('persona.create_Aplicativo_person',compact('persona','data','personaxAplicativo','mensaje','numeroTicket'));
    }

    public function  exportarCuenta(){


    }

    public function cuentaCambiar($idCuenta){


    }
}
