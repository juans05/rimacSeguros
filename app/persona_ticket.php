<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class persona_ticket extends Model {

    protected $table = 'persona_tickets';

    protected $fillable = ['aplicativo_id','ticket_id','usucrea','usumodifico','estado_persona_ticket'];


    protected $hidden = ['aplicativo_id','ticket_id','usucrea','usumodifico','estado_persona_ticket'];



    public function Cuenta(){
        return $this->belongsToMany('App\Aplictivo', 'Cuenta', 'persona_ticket_id', 'aplicativo_id');
    }

    public static function regiser_PersonaTicket($persona,$ticket2, $usuCrea){
        $ticket=new persona_ticket();
        $ticket->ticket_id=$ticket2;
        $ticket->persona_id=$persona;
        $ticket->usucrea=$usuCrea;
        $ticket->estado_persona_ticket=0;
        $ticket->save();
        return $ticket;

    }
    public static function regiser_PersonaTicket_masivo($persona,$ticket2, $usuCrea){
        $ticket=new persona_ticket();
        $ticket->ticket_id=$ticket2;
        $ticket->persona_id=$persona;
        $ticket->usucrea=$usuCrea;
        $ticket->estado_persona_ticket=1;
        $ticket->save();
        return $ticket;

    }
   ///21/04/2015
    public static function ticketRelacionado_persona($idpersona){
            $result=\DB::table('persona_tickets')
                ->select(['persona_tickets.id','persona_tickets.ticket_id','persona_tickets.persona_id'])
                ->where('persona_tickets.persona_id',$idpersona)
                ->get();
            return $result;
    }


    public static function Cantidad_ticket_persona($idPersona){
        $result=\DB::table('persona_tickets')
            ->select(['persona_tickets.id'])
            ->where('persona_tickets.persona_id',$idPersona)
            ->count();
        return $result;
    }
    public static  function ticketPesona($idPersona,$estado){

        $result=\DB::table('persona_tickets')
            ->select(['ticket.id','ticket.nroticket'])
            ->join('ticket','persona_tickets.ticket_id','=','ticket.id')
            ->where('persona_tickets.persona_id',$idPersona)
            ->where('persona_tickets.estado_persona_ticket',$estado)
            ->get();
        return $result;
    }
    public static  function ticketPesona2($idPersona){

        $result=\DB::table('persona_tickets')
            ->select(['ticket.id','ticket.nroticket'])
            ->join('ticket','persona_tickets.ticket_id','=','ticket.id')
            ->where('persona_tickets.persona_id',$idPersona)
            ->where('persona_tickets.estado_persona_ticket',1)
            ->get();
        return $result;
    }
    public static function Ticket_Aplicativo_existe($nroTicket,$idAplicativo){

        $result=\DB::table('persona_tickets')
            ->select(['ticket.id','ticket.nroticket'])
            ->join('ticket','persona_tickets.ticket_id','=','ticket.id')
            ->join('aplicativo_ticket_persona','persona_tickets.id','=','aplicativo_ticket_persona.ticket_persona_id')
            ->where('aplicativo_ticket_persona.aplicativo_id',$idAplicativo)
            ->where('ticket.nroticket',$nroTicket)
            ->count();
        return $result;
    }
    ///28/04/2015

    public static function sacarIDTabla($nomTabla,$selectTabla,$whereTabla,$variable){
        $result=\DB::table($nomTabla)
            ->select([$selectTabla])
            ->where($whereTabla,$variable)
            ->get();
        return $result;
    }

    public static function sacarIDTabla2($variable,$variable2){
        $result=\DB::table('persona_tickets')
            ->select('persona_tickets.id')
            ->where('persona_tickets.ticket_id',$variable)
            ->where('persona_tickets.persona_id',$variable2)
            ->get();
        return $result;
    }
}
