<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Aplicativo extends Model {

    protected $table = 'aplicativo';


    protected $fillable = ['nombre_aplicativo'];


    protected $hidden = ['nombre_aplicativo'];



    public function aplicativo_ticket(){
        return $this->hasMany('App\aplicativo_ticket','aplicativo_id','id');
    }
    public function persona(){
        // return $this->hasMany('App\persona_ticket','persona_id','id');
        return $this->belongsToMany('App\Area', 'aplicativo_area', 'aplicativo_id', 'area_id');
    }
    public function Cuenta(){
        // return $this->hasMany('App\persona_ticket','ticket_id','id');
        return $this->belongsToMany('App\persona_ticket', 'Cuenta', 'aplicativo_id', 'persona_ticket_id');
    }
    public static function AplicativoFaltantedelTicket($idPersona){
        $resultado=\DB::table('aplicativo')
            ->select(['aplicativo.id','aplicativo.nombre_aplicativo'])
            ->whereNotIn('aplicativo.id',function($query)use($idPersona)
                {
                    $query->select(['aplicativo_ticket_persona.aplicativo_id'])
                        ->from('persona_tickets')
                        ->where('persona_tickets.persona_id',$idPersona)
                        ->join('aplicativo_ticket_persona','persona_tickets.id','=','aplicativo_ticket_persona.ticket_persona_id')
                        ->get();
                }
            )
            ->get();
        return $resultado;

    }

}
