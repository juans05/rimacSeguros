<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model {

    protected $table = 'cuenta';

    protected $fillable = ['aplicativo_id','persona_ticket_id','cuenta_usu','clave','usucrea'];
    protected $hidden = ['aplicativo_id','persona_ticket_id','cuenta_usu','clave','usucrea'];

    public function Aplicativo(){
        return $this->belongsTo('App\Aplicativo','id','aplicativo_id');
    }

    public function Persona_Ticket(){
        return $this->belongsTo('App\persona_ticket','id','persona_ticket_id');
    }


    public static function insertarCuenta($numeroTicket,$cuentaAplicativo,$cuentaPersona,$cuenta_usu,$clave,$usucrea){

        $persona=new Cuenta();
        $persona->cuenta_aplicativo=$cuentaAplicativo;
        $persona->cuenta_persona=$cuentaPersona;
        $persona->ticket=$numeroTicket;
        $persona->cuenta_usu=$cuenta_usu;
        $persona->clave=$clave;
        $persona->usucrea=$usucrea;
        $persona->estado="1";
        $persona->save();

        return $persona;

    }

    public static function existeData($idPersona){
        $result=\DB::table('cuenta')
            ->select(['cuenta.cuenta_persona'])
            ->where('cuenta.cuenta_persona',$idPersona)
            ->where('cuenta.cuenta_usu','<>',"''")
            ->get();
        return $result;

    }

    public static function aplicativosTicket_persona($idticket_persona){
        $result=\DB::table('aplicativo_ticket_persona')
                ->select(['aplicativo.id','aplicativo.nombre_aplicativo'])
                ->where('aplicativo_ticket_persona.id',$idticket_persona)
                ->join('aplicativo','aplicativo_ticket.aplicativo_id','=','aplicativo.id')
                ->join('ticket','aplicativo_ticket_persona.id','=','ticket.id')
                 ->get();
        return $result;
    }

    public static function CuentaPersona($idPersona){
        $result=\DB::table('cuenta')
            ->select(['cuenta.id','aplicativo.nombre_aplicativo','cuenta.cuenta_usu','cuenta.cuenta_aplicativo','cuenta.created_at','cuenta.usucrea','cuenta.ticket','cuenta.estado'])
            ->where('cuenta.cuenta_persona',$idPersona)
            ->join('persona','cuenta.cuenta_persona','=','persona.id')
            ->join('aplicativo','cuenta.cuenta_aplicativo','=','aplicativo.id')
            ->get();
        return $result;
    }
    public static  function eliminarCuenta($id_aplicativo,$idPersona){
           return  \DB::table('cuenta')->where('cuenta_persona', '=', $idPersona)->where('cuenta_aplicativo','=',$id_aplicativo)->delete();

    }

}
