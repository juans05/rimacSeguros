<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class area_aplicativo extends Model {

    protected $table = 'aplicativo_area';

    protected $fillable = ['area_id','aplicativo_id','usucrea'];


    protected $hidden = ['area_id','aplicativo_id','usucrea'];

    public function aplicativo(){
        return $this->belongsTo('App\Ticket','aplicativo_id','id');
    }

    public function area(){
        return $this->belongsTo('App\Area','area_id','id');
    }

    public static function buscarAplicativo($idarea){

        $result=\DB::table('aplicativo_area')
            ->select(['aplicativo_area.id','aplicativo.nombre_aplicativo'])
            ->join('area','aplicativo_area.area_id','=','area.id')
            ->join('aplicativo','aplicativo_area.aplicativo_id','=','aplicativo.id')
            ->where('area.id',$idarea)->get();


        return $result;

    }
    public static function AplicativoAreaFaltante($idarea){
        $resultado=\DB::table('aplicativo')
            ->select(['aplicativo.id','aplicativo.nombre_aplicativo'])
            ->whereNotIn('aplicativo.id',function($query)use($idarea)
            {
                $query->select(['aplicativo_area.aplicativo_id'])
                    ->from('aplicativo_area')
                    ->where('area.id',$idarea)
                    ->join('area','aplicativo_area.area_id','=','area.id')
                    ->get();
            }
            )
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