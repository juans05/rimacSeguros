<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {

    protected $table = 'ticket';


    protected $fillable = ['nroticket','usucrea','estado'];


    protected $hidden = ['nroticket','usucrea','estado'];


    public function persona(){
       // return $this->hasMany('App\persona_ticket','persona_id','id');
        return $this->belongsToMany('App\Persona', 'persona_tickets', 'ticket_id', 'persona_id');
    }



    public static function registrar($nroTicket,$usucrea){
        $ticket=new Ticket();
        $ticket->nroticket=$nroTicket;
        $ticket->usucrea=$usucrea;
        $ticket->estado=0;
        $ticket->ticket_padre=0;
        $ticket->save();
        return $ticket->id;
    }
    public static function registrarHIjo($nroTicket,$ticketPadre,$usucrea){
        $ticket=new Ticket();
        $ticket->nroticket=$nroTicket;
        $ticket->usucrea=$usucrea;
        $ticket->ticket_padre=$ticketPadre;
        $ticket->save();
        return $ticket->id;
    }
    public static function buscarIDticket($ticket,$idAplicativo){
        $result=\DB::table('ticket')
            ->select(['aplicativo_ticket_persona.id'])
            ->where('aplicativo_ticket_persona.id',$ticket)
            ->where('aplicativo_ticket_persona.aplicativo_id',$idAplicativo)
            ->join('aplicativo_ticket_persona','ticket.id','=','aplicativo_ticket_persona.ticket_id')
            ->join('aplicativo','aplicativo_ticket_persona.aplicativo_id','=','aplicativo.id')
            ->get();
        return $result;
    }
    public static function buscarAplicativoRelacionados($idPersona){
        $result=\DB::table('aplicativo_ticket_persona')
                  ->select(['aplicativo.nombre_aplicativo','aplicativo.id','aplicativo_ticket_persona.created_at','aplicativo_ticket_persona.usucrea'])
                 ->whereIn('aplicativo_ticket_persona.ticket_persona_id',function($query)use($idPersona)
                    {
                        $query->select(['persona_tickets.id'])
                            ->from('persona_tickets')
                            ->where('persona_tickets.persona_id',$idPersona)
                            ->get();
                    }
                    )
                 ->join('aplicativo','aplicativo_ticket_persona.aplicativo_id','=','aplicativo.id')
                 ->get();

        return $result;
    }
    public static function buscarAplicativoRelacionados2($idTicket_persona){
        $result=\DB::table('aplicativo_ticket_persona')
            ->select(['aplicativo.nombre_aplicativo','aplicativo.id','aplicativo_ticket_persona.created_at','aplicativo_ticket_persona.usucrea'])
            ->whereIn('aplicativo_ticket_persona.ticket_persona_id',function($query)use($idTicket_persona)
            {
                $query->select(['persona_tickets.id'])
                    ->from('persona_tickets')
                    ->where('persona_tickets.id',$idTicket_persona)
                    ->get();
            }
            )
            ->join('aplicativo','aplicativo_ticket_persona.aplicativo_id','=','aplicativo.id')

            ->get();

        return $result;
    }
}
