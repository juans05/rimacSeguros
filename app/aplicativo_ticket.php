<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class aplicativo_ticket extends Model {

    protected $table = 'aplicativo_ticket';

    protected $fillable = ['aplicativo_id','ticket_id','usucrea','usumodifico','estado'];

    public   $tickets="";

    protected $hidden =['aplicativo_id','ticket_id','usucrea','usumodifico','estado'];

    public function ticket(){
        return $this->belongsTo('App\Ticket','ticket_id','id');
    }
    public function Aplicativo(){
        return $this->belongsTo('App\Aplicativo','aplicativo_id','id');
    }
    public function cuenta(){
        return $this->hasOne('App\Cuenta','aplicativo_ticket_id','id');
    }

    public static function Aplicat($ticket){


        /*$result=\DB::table('ticket')
            ->select(['aplicativo.id','aplicativo.nombre_aplicativo'])
            ->where('ticket.id',$ticket)
            ->join('aplicativo_tickets','ticket.id','=','aplicativo_tickets.ticket_id')
            ->join('aplicativo','aplicativo_tickets.aplicativo_id','=','aplicativo.id')
            ->leftjoin('cuenta','aplicativo_tickets.id','=','cuenta.aplicativo_ticket_id')
            ->get();

        return $result;
       /* $result=\DB::table('ticket')
            ->select(['aplicativo.id','aplicativo.nombre_aplicativo'])
            ->where('ticket.id',$ticket)
            ->join('aplicativo_tickets','ticket.id','=','aplicativo_tickets.ticket_id')
            ->join('aplicativo','aplicativo_tickets.aplicativo_id','=','aplicativo.aplicativo_id')
            ->get();*/

    }

    public static function cuentasAplicativos($ticket_id){
        /*  $resultado=\DB::table('cuenta')
            ->select(['cuenta.id','cuenta.cuenta_usu','ticket.nroticket','aplicativo.nombre_aplicativo','cuenta.created_at'])
            ->whereIn('cuenta.aplicativo_ticket_id',function($query)use($ticket_id)
                            {
                                $query->select(['aplicativo_tickets.id'])
                                    ->from('ticket')
                                    ->where('ticket.id',$ticket_id)
                                    ->join('aplicativo_tickets','ticket.id','=','aplicativo_tickets.ticket_id')
                                    ->join('aplicativo','aplicativo_tickets.aplicativo_id','=','aplicativo.id')
                                    ->get();
                            }
            )
            ->join('aplicativo_tickets','cuenta.aplicativo_ticket_id','=','aplicativo_tickets.id')
            ->join('aplicativo','aplicativo_tickets.aplicativo_id','=','aplicativo.id')
            ->join('ticket','aplicativo_tickets.ticket_id','=','ticket.id')
            ->get();
        return $resultado;*/
    }

    public static function cuentasAplicativosExportar($ticket_id){
        $resultado=\DB::table('cuenta')
            ->select(['cuenta.id','cuenta.cuenta_usu','ticket.nroticket','aplicativo.nombre_aplicativo','cuenta.created_at','cuenta.clave'])
            ->whereIn('cuenta.aplicativo_ticket_id',function($query)use($ticket_id)
            {
                $query->select(['aplicativo_tickets.id'])
                    ->from('ticket')
                    ->where('ticket.id',$ticket_id)
                    ->join('aplicativo_tickets','ticket.id','=','aplicativo_tickets.ticket_id')
                    ->join('aplicativo','aplicativo_tickets.aplicativo_id','=','aplicativo.id')
                    ->get();
            }
            )
            ->join('aplicativo_tickets','cuenta.aplicativo_ticket_id','=','aplicativo_tickets.id')
            ->join('aplicativo','aplicativo_tickets.aplicativo_id','=','aplicativo.id')
            ->join('ticket','aplicativo_tickets.ticket_id','=','ticket.id')
            ->get();
        return $resultado;
    }
}
/*
 *   $result=\DB::table('ticket')
            ->select(['aplicativo_tickets.id'])
            ->where('aplicativo_tickets.ticket_id',$ticket)
            ->join('aplicativo_tickets','ticket.id','=','aplicativo_tickets.ticket_id')
            ->join('aplicativo','aplicativo_tickets.aplicativo_id','=','aplicativo.id')
            ->get();

        return $result;
 */