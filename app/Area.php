<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model {

    protected $table = 'area';

    protected $fillable = ['nombre_area','usucrea','estado','created_at','updated_at'];
    protected $hidden = ['nombre_area','usucrea','estado','created_at','updated_at'];

    public function ticket(){
        // return $this->hasMany('App\persona_ticket','ticket_id','id');
        return $this->belongsToMany('App\Aplicativo', 'aplicativo_area', 'area_id', 'aplicativo_id');
    }


    public function Aplicativo_ticket(){
        return $this->belongsTo('App\aplicativo_ticket','id','aplicativo_ticket_id');
    }

    public static function aplicativoxArea($idArea){

        $result=\DB::table('area')
            ->select(['aplicativo_area.aplicativo_id','aplicativo.nombre_aplicativo'])
            ->where('aplicativo_area.area_id',$idArea)
            ->join('aplicativo_area','area.id','=','aplicativo_area.area_id')
            ->join('aplicativo','aplicativo_area.aplicativo_id','=','aplicativo.id')
            ->get();
        return $result;
    }

}
