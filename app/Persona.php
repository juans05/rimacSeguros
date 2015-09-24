<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Http\Requests\CreatePersonaRequest;
use App\Aplicativo;
use App\Ticket;

class Persona extends Model {

	//
    protected $table = 'persona';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre_persona', 'dni', 'email','usuCrea','usuModi','remember_token','created_at','updated_at','estado'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['nombre_persona', 'dni', 'email','usuCrea','usuModi','remember_token','created_at','updated_at','estado'];

    public static function ticketxPersonaxid($idPersona){
        $result=\DB::table('persona')
            ->select(['persona_tickets.id as id_ticket','ticket.nroticket','persona.id','persona.nombre_persona','persona.dni','persona_tickets.estado_persona_ticket','persona_tickets.created_at'])
            ->join('persona_tickets','persona.id','=','persona_tickets.persona_id')
            ->join('ticket','persona_tickets.ticket_id','=','ticket.id')
            ->where('persona_tickets.persona_id','=',$idPersona)
            ->get();

        return $result;
    }
    public static function ticketxPersona(){
        $result=\DB::table('persona')
            ->select(['ticket.nroticket','persona.nombre_persona','persona.dni'])
            ->join('persona_ticket','persona.id','=','persona_ticket.persona_id')
            ->join('ticket','persona_ticket.ticket_id','=','ticket.id')
            ->get();

        return $result;
    }
    public function ticket(){
        // return $this->hasMany('App\persona_ticket','ticket_id','id');
        return $this->belongsToMany('App\Ticket', 'persona_tickets', 'persona_id', 'ticket_id');
    }
    public static  function consulta2(){

        $result=\DB::table('persona')
                ->select(['ticket.id','ticket.nroticket','persona.nombre_persona','persona.dni','ticket.estado','persona_tickets.persona_id','persona_tickets.estado_persona_ticket'])
                ->join('persona_tickets','persona.id','=','persona_tickets.persona_id')
                ->join('ticket','persona_tickets.ticket_id','=','ticket.id')
                ->where('ticket.ticket_padre','=','0')
                ->orderBy('persona.nombre_persona', 'ASC')
                ->paginate(25);

        return $result;
    }
    public static  function consulta(){

        $result=\DB::table('persona')
            ->select(['persona.nombre_persona','persona.dni','persona_tickets.persona_id','persona.estado'])
            ->join('persona_tickets','persona.id','=','persona_tickets.persona_id')
            ->join('ticket','persona_tickets.ticket_id','=','ticket.id')
            ->where('ticket.ticket_padre','=','0')
            ->orderBy('persona.nombre_persona', 'ASC')
            ->paginate(25);

        return $result;
    }

   public static function  insertPersona(CreatePersonaRequest $request){

       $persona=new Persona($request->all());
       $persona->nombre_persona=$request->nombre_persona;
       $persona->dni=$request->dni;
       $persona->email=$request->email;
       $persona->usuCrea='';
       $persona->usuModi="";
       $persona->save();

       return $persona;
   }
    public static function BuscarXDNI($name){

        $result=\DB::table('persona')
            ->select(['ticket.id','ticket.nroticket','persona.nombre_persona','persona.dni','ticket.estado','persona_tickets.persona_id','persona_tickets.estado_persona_ticket'])
            ->where('persona.dni','like','%'.$name.'%')
            ->join('persona_tickets','persona.id','=','persona_tickets.persona_id')
            ->join('ticket','persona_tickets.ticket_id','=','ticket.id')
            ->where('ticket.ticket_padre','=','0')
            ->orderBy('persona.nombre_persona', 'ASC')
            ->paginate(25);

        return $result;
    }
    public static function buscarXNombre($name){

        $result=\DB::table('persona')
            ->select(['ticket.id','ticket.nroticket','persona.nombre_persona','persona.dni','ticket.estado','persona_tickets.persona_id','persona_tickets.estado_persona_ticket'])
            ->where('persona.nombre_persona','like','%'.$name.'%')
            ->where('ticket.ticket_padre','=','0')
            ->join('persona_tickets','persona.id','=','persona_tickets.persona_id')
            ->join('ticket','persona_tickets.ticket_id','=','ticket.id')

            ->orderBy('persona.nombre_persona', 'ASC')
            ->paginate(25);

        return $result;
    }
    ////////////////pantalla listar personas
    public static function BuscarXDNILIstaPersona($name){

        $result=\DB::table('persona')
            ->select(['ticket.id','ticket.nroticket','persona.nombre_persona','persona.dni','ticket.estado','persona_tickets.persona_id','persona_tickets.estado_persona_ticket'])
            ->where('persona.dni','like','%'.$name.'%')
            ->join('persona_tickets','persona.id','=','persona_tickets.persona_id')
            ->join('ticket','persona_tickets.ticket_id','=','ticket.id')
            ->orderBy('persona.nombre_persona', 'ASC')
            ->paginate(25);

        return $result;
    }
    public static function buscarXNombreListarPersonas($name){

        $result=\DB::table('persona')
            ->select(['ticket.id','ticket.nroticket','persona.nombre_persona','persona.dni','ticket.estado','persona_tickets.persona_id','persona_tickets.estado_persona_ticket'])
            ->where('persona.nombre_persona','like','%'.$name.'%')
            ->join('persona_tickets','persona.id','=','persona_tickets.persona_id')
            ->join('ticket','persona_tickets.ticket_id','=','ticket.id')
            ->orderBy('persona.nombre_persona', 'ASC')
            ->paginate(25);

        return $result;
    }
    public static function  insertPersonaMasivo($nombre_completoPersona,$dni,$email,$usucrea){

        $persona=new Persona();
        $persona->nombre_persona=$nombre_completoPersona;
        $persona->dni=$dni;
        $persona->email="";
        $persona->usuCrea=$usucrea;
        $persona->usuModi="";
        $persona->save();

        return $persona;
    }

    public static function PersonaXAplicativo($idPersona){

        $result=\DB::table('aplicativo_ticket_persona')
            ->select(['aplicativo.id','aplicativo.nombre_aplicativo'])
            ->where('persona_tickets.persona_id',$idPersona)
            ->join('persona_tickets','aplicativo_ticket_persona.ticket_persona_id','=','persona_tickets.id')
            ->join('aplicativo','aplicativo_ticket_persona.aplicativo_id','=','aplicativo.id')
            ->get();
        return $result;
    }

    public static function eliminarTicket_persona($id_ticketPersona,$personaID){

        $aplicativo_ticket_persona=Persona::aplicativo_ticket_persona2($id_ticketPersona);
        $cuenta=Cuenta::existeData($personaID);
        if(count($cuenta)>0){
            if(count($aplicativo_ticket_persona)>0){
                for($i=0;$i<count($aplicativo_ticket_persona);$i++){
                    Cuenta::eliminarCuenta($aplicativo_ticket_persona[$i]->aplicativo_id,$personaID);///elimina las cuentas registradas
                }
            }
            aplicativo_ticket_persona::eliminarAplicativo_Ticket($id_ticketPersona);//eliminar aplicativo por ticket de la persona

        }else{
            aplicativo_ticket_persona::eliminarAplicativo_Ticket($id_ticketPersona);//eliminar aplicativo por ticket de la persona

        }

    }
    public static  function aplicativo_ticket_persona2($id_ticketPersona){
        $result=\DB::table('aplicativo_ticket_persona')
            ->select(['aplicativo_ticket_persona.aplicativo_id'])
            ->where('aplicativo_ticket_persona.ticket_persona_id',$id_ticketPersona)
            ->get();
        return $result;
    }


}
