<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Prestamos\Recalcular;
use App\Http\Controllers\Prestamos\Notificar;
use App\Models\Prestamos\Pago;
use App\Models\Prestamos\Prestamo;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
        $this->RecalcularDeudas();
       $this->CrearNotificaciones();
        
        $hoy = date("Y-m-d");
        $ayer = date("Y-m-d",strtotime($hoy."- 30 days"));
        $dinpres = Prestamo::all()->where("usuario_id", auth()->id())->sum("monto");
        $dinpres2 = Prestamo::all()->where("usuario_id", auth()->id())->whereBetween("fechinicio",[$ayer,$hoy])->sum("monto");
        $dinliq = Pago::all()->where("tipopago","Liquidado")->where("usuario_id", auth()->id())->sum("valor_pago");
        $dinrec = Prestamo::all()->where("estado","1")->sum("total_deuda");
        $dinrec2 = Pago::all()->where("tipopago","Abono")->where("usuario_id", auth()->id())->whereBetween("fechpago",[$ayer,$hoy])->sum("valor_pago");
        $ganancias = Pago::all()->where("tipopago","Intereses")->where("usuario_id", auth()->id())->whereBetween("fechpago",[$ayer,$hoy])->sum("valor_pago");
        $intporco = Prestamo::all()->where("estado","1")->sum("total_intereses");
       $presrea = Prestamo::all()->where("usuario_id", auth()->id())->whereBetween("fechinicio",[$ayer,$hoy])->count();
        $intgan = Pago::all()->where("tipopago","Intereses")->where("usuario_id", auth()->id())->sum("valor_pago");
        $porcob = Prestamo::all()->where("usuario_id", auth()->id())->sum("total_intereses");
        
        return view('home',compact("intgan","dinpres","dinrec","ganancias",
                "dinliq","porcob","intporco","ayer","hoy","dinpres2","dinrec2","presrea"));
        
    }
    public function consulta(Request $request)
    {

        $hoy = $request->fin;
        $ayer = $request->inicio;
        $dinpres = Prestamo::all()->where("usuario_id", auth()->id())->sum("monto");
        $dinpres2 = Prestamo::all()->where("usuario_id", auth()->id())->whereBetween("fechinicio",[$ayer,$hoy])->sum("monto");
        $dinliq = Pago::all()->where("tipopago","Liquidado")->where("usuario_id", auth()->id())->sum("valor_pago");
        $dinrec = Prestamo::all()->where("estado","1")->sum("total_deuda");
        $dinrec2 = Pago::all()->where("tipopago","Abono")->where("usuario_id", auth()->id())->whereBetween("fechpago",[$ayer,$hoy])->sum("valor_pago");
        $ganancias = Pago::all()->where("tipopago","Intereses")->where("usuario_id", auth()->id())->whereBetween("fechpago",[$ayer,$hoy])->sum("valor_pago");
        $intporco = Prestamo::all()->where("estado","1")->sum("total_intereses");
       $presrea = Prestamo::all()->where("usuario_id", auth()->id())->whereBetween("fechinicio",[$ayer,$hoy])->count();
        $intgan = Pago::all()->where("tipopago","Intereses")->where("usuario_id", auth()->id())->sum("valor_pago");
        $porcob = Prestamo::all()->where("usuario_id", auth()->id())->sum("total_intereses");
        
        return view('home',compact("intgan","dinpres","dinrec","ganancias",
                "dinliq","porcob","intporco","ayer","hoy","dinpres2","dinrec2","presrea"));
        
    }
    
      public function RecalcularDeudas() {
            $e = new Recalcular();
            $e->RecalcularDeudas();   
      }
      
      public function CrearNotificaciones() {
            $e = new Notificar();
            $e->CrearNotificaciones();   
      }
}
