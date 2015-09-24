<?php namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 28/03/2015
 * Time: 19:16
 */

namespace App\Http\Controllers;

use App\Aplicativo;
use App\aplicativo_ticket_persona;
use App\Area;
use App\area_aplicativo;
use App\Persona;
use App\aplicativo_ticket;
use App\Cuenta;
use App\Http\Requests\CreatePersonaRequest;
use App\Http\Requests\CreateCuentaRequest;
use App\persona_ticket;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class AplicativoController extends Controller{


    public function addAplicativoPersona($slug){
       $persona=Persona::findOrFail($slug);
       $personaxAplicativo=Cuenta::CuentaPersona($persona->id);//todos los aplicativos registrados en la tabla cuenta de la persona
       $data=Ticket::buscarAplicativoRelacionados($persona->id);///todos los aplicativos registrados en el ticket
       $mensaje="";
       $numeroTicket=persona_ticket::ticketPesona($persona->id,0);
       return view('persona.create_Aplicativo_person',compact('persona','data','personaxAplicativo','mensaje','numeroTicket'));
    }

    public function verCuentaAplicativo($idTicket){
        $persona_ticket=persona_ticket::find($idTicket);
        $persona=Persona::findOrFail($persona_ticket->persona_id);
        $aplicativo=Aplicativo::AplicativoFaltantedelTicket($persona_ticket->persona_id);
        $data=Ticket::buscarAplicativoRelacionados2($idTicket);///todos los aplicativos registrados en el ticket
        //$numeroTicket=persona_ticket::ticketPesona($persona_ticket->persona_id,0);
        $mensaje="";
        return view('persona.create_Aplicativo_ticket',compact('persona','data','aplicativo','mensaje','persona_ticket'));

    }


    public  function registrarAplicativo(Request $rq){

        $usuCrea=\Auth::user()->email;
        $registro_ticket_persona=aplicativo_ticket_persona::registroPersonaTicket($rq->persona_ticket,$rq->nomAplicativo,$usuCrea);//registro
        $persona_ticket=persona_ticket::find($rq->persona_ticket);
        $persona=Persona::findOrFail($persona_ticket->persona_id);
        $aplicativo=Aplicativo::AplicativoFaltantedelTicket($persona_ticket->persona_id);
        $data=Ticket::buscarAplicativoRelacionados2($rq->persona_ticket);///todos los aplicativos registrados en el ticket
        if($registro_ticket_persona!=0){
            $mensaje="Se registro Correctamente";
        }else{
            $mensaje="No se Registro Correctamente";

        }

        return view('persona.create_Aplicativo_ticket',compact('persona','data','aplicativo','mensaje','persona_ticket'));
    }

    public function EliminarAplicativoTicket($idPersona_ticket,$idAplicativo){
       // return $idPersona_ticket.'   '.$idAplicativo;

        $eliminarDatoAplicativo=aplicativo_ticket_persona::eliminarAplicativo_Ticket_persona($idAplicativo,$idPersona_ticket);
        if($eliminarDatoAplicativo==1){
            return "Aplicativo eliminado del ticket";
        }
        else{
            return "No se pudo eliminar el aplicativo del ticket";
        }
    }
    public function areaporAplicativo(){
        $area=Area::all();//->lists('id','nombre_area');

        $mensaje="";
        return view('persona.create_Aplicativo_area',compact('mensaje','area'));
    }
    public function  armarGrilla($idarea){
        $datos=area_aplicativo::buscarAplicativo($idarea);

       return view('persona.grillaDinamica.grilla',compact('datos'));

    }

    public function aplicativoFaltante($idArea){
        $datos=area_aplicativo::AplicativoAreaFaltante($idArea);
        return view('persona.grillaDinamica.combobox',compact('datos'));
    }
    public function  registroNuevoAplicativo($idArea,$idAplicativo){
        $usuCrea=\Auth::user()->email;
        $aplicativo = new area_aplicativo();
        $aplicativo->area_id=$idArea;
        $aplicativo->aplicativo_id=$idAplicativo;
        $aplicativo->usucrea=$usuCrea;
   //     $aplicativo->save();
        if($aplicativo->save()){

            $datos=area_aplicativo::buscarAplicativo($idArea);
            return view('persona.grillaDinamica.grilla',compact('datos'));
        }
        else{

            return "0";
        }


    }
    public function  eliminarAreaAplicativo($id,$idArea){
        $area_aplicativo=area_aplicativo::find($id);
        if (is_null ($area_aplicativo))
        {
           // App::abort(404);
            return "0";

        }

        $area_aplicativo->delete();
        $datos=area_aplicativo::buscarAplicativo($idArea);
        return view('persona.grillaDinamica.grilla',compact('datos'));
    }
}