<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class aplicativo_ticket_persona extends Model {

    protected $table = 'aplicativo_ticket_persona';

    protected $fillable = ['aplicativo_id','ticket_persona_id','usucrea','usumodifico','estado'];

    public   $tickets="";

    protected $hidden =['aplicativo_id','ticket_persona_id','usucrea','usumodifico','estado'];


    public static  function BuscarIDTicketPersona($idPersona){
        $result=\DB::table('aplicativo_ticket_persona')
            ->select(['persona_tickets.id'])
            ->where('persona_tickets.persona_id',$idPersona)
            ->join('persona_tickets','aplicativo_ticket_persona.ticket_persona_id','=','persona_tickets.id')
            ->get();
        return $result;
    }
    public static  function eliminarAplicativo_Ticket($idPersona){
       // return   App\DB::delete('delete from aplicativo_ticket_persona where aplicativo_ticket_persona.ticket_persona_id = '.$idPersona);
        return  \DB::table('aplicativo_ticket_persona')->where('ticket_persona_id', '=', $idPersona)->delete();
    }
    public static  function eliminarAplicativo_Ticket_persona($idAplicativo,$idPersona_ticket){

        $persona_ticket_aplicativo=aplicativo_ticket_persona::where('aplicativo_id','=',$idAplicativo)->where('ticket_persona_id','=',$idPersona_ticket);
        $persona_ticket_aplicativo->delete();
        return  1;
    }
    public static function registroPersonaTicket($idPersona,$id_ticket,$idUsuCrea){

        $persona_aplicativo=new aplicativo_ticket_persona();
        $persona_aplicativo->aplicativo_id=$id_ticket;
        $persona_aplicativo->ticket_persona_id=$idPersona;
        $persona_aplicativo->usucrea=$idUsuCrea;
        $persona_aplicativo->estado='0';
        $persona_aplicativo->save();
        \Log::info('Se registro Correctamente el aplicativo en la cuenta...dao: aplicativo_ticket_persona/36.');
        return $persona_aplicativo->ticket_persona_id;

    }

}
