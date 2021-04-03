<?php

namespace App\Http\Controllers\Prestamos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Http\Controllers\Prestamos\Recalcular;
use App\Http\Controllers\Prestamos\Notificar;
use App\Models\Seguridad\Usuario;
use App\Models\Seguridad\Cliente;
use App\Models\Prestamos\Saldo;
use App\Models\Prestamos\Prestamo;
use App\Models\Prestamos\Pago;
use App\Models\Prestamos\Notificacion;
use Session;


class PrestamoController extends Controller
{
    
     public function __construct() {
        $this->middleware('auth');
    }
    
    
    
    
      public function TipoPrestamo() {
          
          $clientes = Cliente::all()->where("prestamoactivo", false)->where("usuario_id", auth()->id());
        return view("Prestamos.HacerPrestamos", compact('clientes'));
    }
    
      public function EditarPrestamos() {
          $this->RecalcularDeudas();
          
          $prestamos = Prestamo::all()->where("pagos",0)->where("usuario_id", auth()->id());
        return view("Prestamos.EditarPrestamos", compact("prestamos"));
            
    }
    
      public function EditarPrestamo($id) {
          
          $prestamo = Prestamo::findOrFail($id);
        return view("Prestamos.EditarPrestamo", compact("prestamo"));      
    }
    
      public function EditPrestamo(Request $request,$id) {
          
          $prestamo = Prestamo::findOrFail($id);
          $user = Usuario::findOrFail(auth()->id());
           $permitido = $user["cupo"]+$prestamo["monto"];
           $request->monto = str_replace(",","",$request->monto);
           $fecha = Carbon::createFromFormat('Y-m-d', $request->fechaprestamo);
           
          if($request->monto <= $permitido && $request->monto > 0 && $fecha <= Carbon::now()){
                $cupupd["cupo"]= $user["cupo"]+$prestamo["monto"];
                $new["monto"] = $request->monto;
                $new["intereses"]= $request->intereses;
                $new["fechinicio"]= $fecha->addDay();
                $new["total_deuda"]= $request->monto;
                $prestamo->update($new);
                $cupupd["cupo"] = $cupupd["cupo"]-$request->monto;
                $user->update($cupupd);
          $this->RecalcularDeudas();
          Session::flash('bien','El prestamo ha sido editado correctamente');
                return redirect("EditarPrestamo");
          }
          $this->RecalcularDeudas();
          Session::flash('mal','El monto debe ser menor a "saldodisponible"+"anteriormonto" o debe ser mayor a 0, o la fecha es superior al dia de hoy');
        return redirect("EditarPrestamo");
    }
      public function EliminarPrestamo($id) {
          
          $prestamo = Prestamo::findOrFail($id);
          $user = Usuario::findOrFail(auth()->id());
          $cliente = Cliente::findOrFail($prestamo["cliente_id"]);
          $upd1["cupo"]= $user["cupo"]+ $prestamo["monto"];
          $upd2["prestamoactivo"]= 0;
          
          $user->update($upd1);
          $cliente->update($upd2);
          $prestamo->delete();
          Session::flash('buena','Prestamo eliminado correctamente');
        return redirect("EditarPrestamo");
    }
    
      public function LiquidarDeuda(Request $request, $id) {
          $prestamo = Prestamo::findOrFail($id);
          $usuario  = Usuario::findOrFail(auth()->id());
          $cliente = Cliente::findOrFail($prestamo["cliente_id"]);
          $request->pago = str_replace(",","",$request->pago);
          $ingreso = $request->pago;
          $deudatotal = $request->interesactual + $request->porcobrar;
          $liquidado = $deudatotal - $ingreso;
          $num_cuota = Pago::select("num_cuota")->where("prestamo_id",$id)->count() + 1;
          
          
          
          if($ingreso <= $deudatotal && $ingreso>0){
              if($ingreso>=$prestamo["total_deuda"]){
                  $exedente = $ingreso - $prestamo["total_deuda"];
                  
                  $pago["cliente_id"] = $cliente["id"];
                  $pago["prestamo_id"] = $id;
                  $pago["num_cuota"] = $num_cuota;
                  $pago["tipopago"] = "Abono";
                  $pago["valor_deuda_inicial"] = $prestamo["total_deuda"];
                  $pago["ganancias"] = $prestamo["total_deuda"];                  
                  $pago["fechpago"] = Carbon::now();
                  $pago["valor_pago"] = $prestamo["total_deuda"];
                  $pago["usuario_id"] = auth()->id();
                  $upd["cupo"] = $usuario["cupo"]+ $prestamo["total_deuda"];
                  $usuario->update($upd);
                  Pago::create($pago);
                  
                  
                  
                  if($exedente>0){
                  $pago["cliente_id"] = $cliente["id"];
                  $pago["prestamo_id"] = $id;
                  $pago["num_cuota"] = $num_cuota+1;
                  $pago["tipopago"] = "Intereses";
                  $pago["valor_deuda_inicial"] = 0;
                  $pago["ganancias"] = $exedente;                  
                  $pago["mespago"] = Carbon::now();
                  $pago["fechpago"] = Carbon::now();
                  $pago["valor_pago"] = $exedente;
                  $pago["usuario_id"] = auth()->id();
                  Pago::create($pago);
                  }
                  
                  if($liquidado>0){
                      $pago["cliente_id"] = $cliente["id"];
                  $pago["prestamo_id"] = $id;
                  $pago["num_cuota"] = $num_cuota+1;
                  $pago["tipopago"] = "Liquidado";
                  $pago["fechpago"] = Carbon::now();
                  $pago["valor_pago"] = $liquidado;
                  $pago["usuario_id"] = auth()->id();
                  Pago::create($pago);
                  }
                  
                  
                  $upd2["pagos"]=1;
                  $upd2["prestamoactivo"]=0;
                  $cliente->update($upd2);
                  
                  $upd3["estado"]=0;                  
                  $upd3["pagos"]=1;                  
                  $upd3["fechafin"] = Carbon::now();                  
                  $upd3["total_deuda"]=0;
                  $upd3["total_intereses"]=0;
                  $prestamo->update($upd3);
                  Session::flash('deudafinalizada','Felicidades, su cliente ha finalizado su deuda');
                return redirect ("RegistrarPago");
          }else{
              Session::flash('pagonovalido','El pago realizado no supera o iguala el valor de la deuda sin intereses, o supera la deuda total');
          return redirect ("RegistrarPago");
              
          }
              
          }else{
              Session::flash('pagonovalido','El pago realizado es menor a 0, no supera o iguala el valor de la deuda sin intereses, o supera la deuda total');
          return redirect ("RegistrarPago");
          }   
    }
    
    public function ShowViewModiSal(){
        return view ("Seguridad.ModificarSaldo");
    }
    
    public function ModificarSaldo(Request $request){
        $this->validate($request, ['ingreso' => 'required']);
        $request->ingreso = str_replace(",","",$request->ingreso);
        $saldo["ingresado"] = $request->ingreso;
        $usuario = Usuario::findOrFail(auth()->id());
    if($request->tipo === "true"){
        $saldo["tipo"] = 1;
        $saldo["usuario_id"] = auth()->id();
        Saldo::create($saldo);
        
          
          $new["cupo"] = $usuario["cupo"] + $saldo["ingresado"];
           $usuario->update($new);           
    }
    
    if($request->tipo === "false"){
        if($request->ingreso <= $usuario["cupo"]  && $request->ingreso > 0){
            $saldo["tipo"] = 0;
        $saldo["usuario_id"] = auth()->id();
        Saldo::create($saldo);        
      
          $new["cupo"] = $usuario["cupo"] - $saldo["ingresado"];
           $usuario->update($new); 
        } else{
            
            Session::flash('saldoerror','El dinero a retirar supera el saldo disponible o es menor a 0');
            return redirect("home");
            
        }
                  
    }
 
        return redirect("home");
    }
    

      public function ObtenerPrestamos() {
     $this->RecalcularDeudas();
     $this->CrearNotificaciones();
         $prestamosactivos = Prestamo::all()->where("estado", true)->where("usuario_id", auth()->id());
     return view("Prestamos.RegistrarPagos", compact("prestamosactivos"));
    }
    
      public function ObtenerAllPrestamos($id) {   
         $cliente = Cliente::findOrFail($id);
         $prestamos = Prestamo::all()->where("cliente_id", $id);
         $count = 1;
        foreach ($prestamos as $prestamo){
            $prestamo["orden"]=$count++;
        }
     return view("Prestamos.HistorialPago", compact("prestamos","cliente"));
    }  
      public function ObtenerAllPagos($id, Request $request) {   
          $idd = $id;
         $pagos = Pago::all()->where("prestamo_id",$id);
         $cliente = Cliente::findOrFail($request->id);
         $prestamo = Prestamo::findOrFail($id);
          return view("Prestamos.HistorialPrestamos", compact("pagos","cliente","prestamo","idd"));
    }  
    
      public function ObtenerCliente() {         
        
       $clientes = Cliente::all()->where("usuario_id", auth()->id());
        return view("Prestamos.HistorialClientes", compact("clientes"));
    }
    
     
    
      public function ObtenerInformacion($id) {
          
          $prest = Prestamo::findOrFail($id);
          $prestamo = $prest;        
          $num_cuota = Pago::select("num_cuota")->where("prestamo_id",$id)->count() + 1;
          $ultimopago = Pago::select("fechpago")->where("cliente_id",$prest['cliente_id'])->where("prestamo_id",$id)->orderBy('fechpago', 'asc')->first();
          $count = Pago::select("fechpago")->where("cliente_id",$prest['cliente_id'])->where("prestamo_id",$id)->count();
 
     
          $prestamo['num_cuota'] = $num_cuota;
          
          if($count === 0){
              $prestamo['fechpago'] = "no registra";
          }
          
          if($count >= 1){
              $prestamo['fechpago'] = $ultimopago["fechpago"];
          }
          
          $prestamo['ultimopago'] = $ultimopago;
          $prestamo['deudaactual'] = $prest['total_deuda'];
          $prestamo['interesesactuales'] = $prest['total_intereses'];
          $prestamo['recomendado'] = ($prest['total_deuda']/100)*$prest['intereses'];
          
          $prestamo['cant_cuotas'] = $prest['num_cuotas'];
          
          if(Pago::select("num_cuota")->where("prestamo_id", $id)->count() === 0){
             $prestamo['porcobrar'] = $prest['total_deuda'];
          }else{
            $aa = Pago::where("cliente_id",$prest['cliente_id'])->where("prestamo_id",$id)->orderBy('por_cobrar', 'asc')->first();
            $prestamo['porcobrar'] = $aa['por_cobrar'];
          }
          
          
    return view("Prestamos.ConfirmarPago" , compact("prestamo"));
    }   
    
    
      public function RegistrarPago(Request $request, $id) {
         $this->validate($request, ['pago' => 'required']);          
         $prestamo = Prestamo::findOrFail($id);
         $cliente = Cliente::findOrFail($prestamo["cliente_id"]);
         $usuario = Usuario::findOrFail(auth()->id());
         $request->pago = str_replace(",","",$request->pago);
         $ingreso = $request->pago;
         $a = $request->interesactual;
         $b = $request->porcobrar;
         
         $c = $a + $b;  
         
         if($ingreso <= $c && $ingreso > 0){
         $pago['cliente_id'] = $prestamo['cliente_id'];          
         $pago['prestamo_id'] = $id;          
         $pago['num_cuota'] = $request->fknum_cuota;
         $pago['valor_deuda_inicial'] = $prestamo['total_deuda'];
         $pago['fechpago'] = Carbon::now();         
         $pago['usuario_id'] = auth()->id();         
         $registros = Pago::where("prestamo_id",$id)
                     ->where("tipopago","Intereses")
                     ->count();
         $intereses = ($prestamo['total_deuda']/100)*$prestamo['intereses'];
          
         
         if($request->interesactual > 0){
             if($request->interesactual >= $intereses){               
                 if($registros===0){
                     if($ingreso < $intereses){
                         $fecha = Carbon::createFromFormat('Y-m-d', $prestamo['fechinicio']);
                         $fecha->addMonth();
                         $pago['mespago'] = $fecha;
                         $pago['ganancias'] = $request->pago;
                         $pago['tipopago'] = "Intereses";
                         $pago['pagocompleto'] = false;
                         $pago['valor_pago'] = $request->pago;
                         Pago::create($pago);
                         $ingreso = 0;
                         $upd["pagos"] = 1;
                        $prestamo->update($upd);
                         
                     }
                     
                     if($ingreso == $intereses){
                         $fecha = Carbon::createFromFormat('Y-m-d', $prestamo['fechinicio']);
                         $fecha->addMonth();
                         $pago['mespago'] = $fecha;
                         $pago['ganancias'] = $request->pago;
                         $pago['tipopago'] = "Intereses";
                         $pago['pagocompleto'] = true;
                         $pago['valor_pago'] = $request->pago;
                         Pago::create($pago);
                         $ingreso = 0;
                         $upd["pagos"] = 1;
                        $prestamo->update($upd);
                          Session::flash('pagorealizado','El pago fue realizado correctamente');
                         return redirect("RegistrarPago");
                     }
                     
                     if($ingreso > $intereses){
                         $numcuota = $request->fknum_cuota;
                         $exedente = $request->pago - $request->interesactual;
                         if($ingreso > $request->interesactual){
                             $ingreso = $ingreso - $exedente;
                             
                         }
                         
                         $pagos['cliente_id'] = $prestamo['cliente_id'];          
                         $pagos['prestamo_id'] = $id;          
                         $pagos['num_cuota'] = $numcuota;
                         $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];
                         $pagos['fechpago'] = Carbon::now();
                         $pagos['usuario_id'] = auth()->id();
                         $pagos['ganancias'] = $intereses;
                         $pagos['tipopago'] = "Intereses";
                         $pagos['valor_pago'] = $intereses;
                         $pagos['pagocompleto'] = true;               
                         $fecha = (Carbon::createFromFormat('Y-m-d', $prestamo['fechinicio']));
                         $fecha->addMonth();
                         $pagos['mespago'] = $fecha;
                         $ingreso  = $ingreso - $intereses;
                         $numcuota++;
                         
                         Pago::create($pagos);
                         
                             while($ingreso >= $intereses){
                                 $pagos['cliente_id'] = $prestamo['cliente_id'];          
                                 $pagos['prestamo_id'] = $id;          
                                 $pagos['num_cuota'] = $numcuota;
                                 $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];
                                 $pagos['fechpago'] = Carbon::now();
                                 $pagos['usuario_id'] = auth()->id();
                                 $pagos['ganancias'] = $intereses;
                                 $pagos['valor_pago'] = $intereses;
                                 $pagos['tipopago'] = "Intereses";
                                 $pagos['pagocompleto'] = true;
                                 $ultimopagos = Pago::select("mespago")
                                    ->where("cliente_id",$prestamo['cliente_id'])
                                    ->where("prestamo_id",$id)
                                    ->where("tipopago","Intereses")
                                    ->orderBy('id', 'desc')->first();
                                 $fechas = Carbon::createFromFormat('Y-m-d', $ultimopagos['mespago']);
                                 $fechas->addMonth();
                                 $pagos['mespago'] = $fechas;
                                 $ingreso  = $ingreso - $intereses;    
                                 $numcuota++;
                                 Pago::create($pagos);
                                 $upd["pagos"] = 1;
             $prestamo->update($upd);
                             }
                             
                           
                             
                         if($ingreso >= 0){
                             if($exedente < 0 && $ingreso>0){
                                     $pagos['cliente_id'] = $prestamo['cliente_id'];          
                             $pagos['prestamo_id'] = $id;          
                             $pagos['num_cuota'] = $numcuota;
                             $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];
                             $pagos['fechpago'] = Carbon::now();
                             $pagos['usuario_id'] = auth()->id();
                             $pagos['ganancias'] = $ingreso;
                             $pagos['valor_pago'] = $ingreso;
                             $pagos['tipopago'] = "Intereses";
                             $pagos['pagocompleto'] = false;                             
                             $ultimopagos = Pago::select("mespago")
                                ->where("cliente_id",$prestamo['cliente_id'])
                                ->where("prestamo_id",$id)
                                ->where("tipopago","Intereses")
                                ->orderBy('id', 'desc')->first();
                             $fechas = Carbon::createFromFormat('Y-m-d', $ultimopagos['mespago']);
                             $fechas->addMonth();
                             $pagos['mespago'] = $fechas;
                             $ingreso  = $ingreso - $intereses;                                   
                             Pago::create($pagos);
                                 }
                                 
                                 if($exedente > 0){
                                     $pagos['cliente_id'] = $prestamo['cliente_id'];          
                             $pagos['prestamo_id'] = $id;          
                             $pagos['num_cuota'] = $numcuota;
                             $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];                             
                             $pagos['usuario_id'] = auth()->id();
                             $pagos['ganancias'] = $exedente;
                             $pagos['valor_pago'] = $exedente;
                             $pagos['tipopago'] = "Abono";
                             $pagos['pagocompleto'] = false;
                             
                           
                             $ingreso  = $ingreso - $intereses;                                   
                             Pago::create($pagos);
                             
                             $usu["cupo"] = $usuario["cupo"]+ $exedente;
                            $usuario->update($usu);
                             
                             
                             
                             $upd["total_deuda"] = $prestamo["total_deuda"]-$exedente;
                             $upd["pagos"] = 1;
                             $prestamo->update($upd);
                                 }
                         }
                         
                                 }
                    }
                    
                    if($registros > 0){
                        
                        $lastpago = Pago::where("prestamo_id",$id)
                                ->where("tipopago","Intereses")->OrderBy("num_cuota","desc")->first();
                        
                        if($lastpago["pagocompleto"] === 1){
                            if($ingreso < $intereses){
                             
                         $fecha = Carbon::createFromFormat('Y-m-d', $lastpago['mespago']);
                         $fecha->addMonth();
                         $pago['mespago'] = $fecha;
                         $pago['ganancias'] = $request->pago;
                         $pago['tipopago'] = "Intereses";
                         $pago['pagocompleto'] = false;
                         $pago['valor_pago'] = $request->pago;
                         Pago::create($pago);
                         $ingreso = 0;
               
                     }
                     if($ingreso == $intereses){
                         $fecha = Carbon::createFromFormat('Y-m-d', $lastpago['mespago']);
                         $fecha->addMonth();
                         $pago['mespago'] = $fecha;
                         $pago['ganancias'] = $request->pago;
                         $pago['tipopago'] = "Intereses";
                         $pago['pagocompleto'] = true;
                         $pago['valor_pago'] = $request->pago;
                         Pago::create($pago);
                         $ingreso = 0;
                     }
                         if($ingreso > $intereses){
                                $numcuota = $request->fknum_cuota;
                                $exedente = $request->pago - $request->interesactual;
                         if($ingreso > $request->interesactual){
                             $ingreso = $ingreso - $exedente;
                             
                         }                         
                         $pagos['cliente_id'] = $prestamo['cliente_id'];          
                         $pagos['prestamo_id'] = $id;          
                         $pagos['num_cuota'] = $numcuota;
                         $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];
                         $pagos['fechpago'] = Carbon::now();
                         $pagos['usuario_id'] = auth()->id();
                         $pagos['ganancias'] = $intereses;
                         $pagos['tipopago'] = "Intereses";
                         $pagos['valor_pago'] = $intereses;
                         $pagos['pagocompleto'] = true;               
                         $fecha = (Carbon::createFromFormat('Y-m-d',$lastpago['mespago']));
                         $fecha->addMonth();
                         $pagos['mespago'] = $fecha;
                         $ingreso  = $ingreso - $intereses;
                         $numcuota++;
                         
                         Pago::create($pagos);
                         $update["total_intereses"] = $prestamo["total_intereses"]-$intereses;
                         $prestamo->update($update);
                         
                         if($prestamo["total_intereses"] > 0){
                             while($ingreso >= $intereses){
                                 $pagos['cliente_id'] = $prestamo['cliente_id'];          
                                 $pagos['prestamo_id'] = $id;          
                                 $pagos['num_cuota'] = $numcuota;
                                 $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];
                                 $pagos['fechpago'] = Carbon::now();
                                 $pagos['usuario_id'] = auth()->id();
                                 $pagos['ganancias'] = $intereses;
                                 $pagos['valor_pago'] = $intereses;
                                 $pagos['tipopago'] = "Intereses";
                                 $pagos['pagocompleto'] = true;
                                 $ultimopagos = Pago::select("mespago")
                                    ->where("cliente_id",$prestamo['cliente_id'])
                                    ->where("prestamo_id",$id)
                                    ->where("tipopago","Intereses")
                                    ->orderBy('id', 'desc')->first();
                                 $fechas = Carbon::createFromFormat('Y-m-d', $ultimopagos['mespago']);
                                 $fechas->addMonth();
                                 $pagos['mespago'] = $fechas;
                                 $ingreso  = $ingreso - $intereses;    
                                 $numcuota++;
                                 Pago::create($pagos);
                                 $update["total_intereses"] = $prestamo["total_intereses"]-$intereses;
                                $prestamo->update($update);
                             }
                      
                         }

                
                         if($ingreso >= 0){
                             if($exedente < 0 && $ingreso>0){
                             $pagos['cliente_id'] = $prestamo['cliente_id'];          
                             $pagos['prestamo_id'] = $id;          
                             $pagos['num_cuota'] = $numcuota;
                             $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];
                             $pagos['fechpago'] = Carbon::now();
                             $pagos['usuario_id'] = auth()->id();
                             $pagos['ganancias'] = $ingreso;
                             $pagos['valor_pago'] = $ingreso;
                             $pagos['tipopago'] = "Intereses";
                             $pagos['pagocompleto'] = false;                             
                             $ultimopagos = Pago::select("mespago")
                                ->where("cliente_id",$prestamo['cliente_id'])
                                ->where("prestamo_id",$id)
                                ->where("tipopago","Intereses")
                                ->orderBy('id', 'desc')->first();
                             $fechas = Carbon::createFromFormat('Y-m-d', $ultimopagos['mespago']);
                             $fechas->addMonth();
                             $pagos['mespago'] = $fechas;                                                    
                             Pago::create($pagos);
                                 }
                                 
                                 if($exedente > 0){
                             $pagos['cliente_id'] = $prestamo['cliente_id'];          
                             $pagos['prestamo_id'] = $id;          
                             $pagos['num_cuota'] = $numcuota;
                             $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];
                             $pagos['fechpago'] = Carbon::now();
                             $pagos['usuario_id'] = auth()->id();
                             $pagos['ganancias'] = $exedente;
                             $pagos['valor_pago'] = $exedente;
                             $pagos['tipopago'] = "Abono";
                             $pagos['pagocompleto'] = false;
                             
                           
                             $ingreso  = $ingreso - $intereses;                                   
                             Pago::create($pagos);
                             
                             $usu["cupo"] = $usuario["cupo"]+ $exedente;
                            $usuario->update($usu);
                             
                             $upd["total_deuda"] = $prestamo["total_deuda"]-$exedente;
                             $upd["pagos"] = 1;
                             $prestamo->update($upd);
                         }
                         
                                 }
                               
                            }
                        
                            
                        }
                        
                        if($lastpago["pagocompleto"] === 0){
                            $restante = $intereses - $lastpago["ganancias"];
                          
                           if($ingreso < $restante){
                                $fecha = Carbon::createFromFormat('Y-m-d', $lastpago['mespago']);                         
                         $pago['mespago'] = $fecha;
                         $pago['ganancias'] = $request->pago + $lastpago["ganancias"];
                      
                         $pago['tipopago'] = "Intereses";
                         $pago['pagocompleto'] = false;
                         $pago['valor_pago'] = $request->pago;
                         Pago::create($pago);
                         $ingreso = 0;
                        
                           
                                
                            }
                            if($ingreso == $restante){
                                $fecha = Carbon::createFromFormat('Y-m-d', $lastpago['mespago']);                         
                         $pago['mespago'] = $fecha;
                         $pago['ganancias'] = $request->pago + $lastpago["ganancias"];
                         $pago['tipopago'] = "Intereses";
                         $pago['pagocompleto'] = true;
                         $pago['valor_pago'] = $request->pago;
                         Pago::create($pago);
                         $ingreso = 0;
                                
                            }
                            if($ingreso > $restante){
                                $numcuota = $request->fknum_cuota;
                                $exedente = $request->pago - $request->interesactual;
                         if($ingreso > $request->interesactual){
                             $ingreso = $ingreso - $exedente;
                             
                         }
                         
                         $pagos['cliente_id'] = $prestamo['cliente_id'];          
                         $pagos['prestamo_id'] = $id;          
                         $pagos['num_cuota'] = $numcuota;
                         $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];
                         $pagos['fechpago'] = Carbon::now();
                         $pagos['usuario_id'] = auth()->id();
                         $pagos['ganancias'] = $restante + $lastpago["ganancias"];
                         $pagos['tipopago'] = "Intereses";
                         $pagos['valor_pago'] = $restante;
                         $pagos['pagocompleto'] = true;               
                         $fecha = (Carbon::createFromFormat('Y-m-d',$lastpago['mespago']));
                         $pagos['mespago'] = $fecha;
                         $ingreso  = $ingreso - $restante;
                         $numcuota++;
                         
                         Pago::create($pagos);
                         $update["total_intereses"] = $prestamo["total_intereses"]-$restante;
                         $prestamo->update($update);
                         
                         if($prestamo["total_intereses"] > 0){
                             while($ingreso >= $intereses){
                                 $pagos['cliente_id'] = $prestamo['cliente_id'];          
                                 $pagos['prestamo_id'] = $id;          
                                 $pagos['num_cuota'] = $numcuota;
                                 $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];
                                 $pagos['fechpago'] = Carbon::now();
                                 $pagos['usuario_id'] = auth()->id();
                                 $pagos['ganancias'] = $intereses;
                                 $pagos['valor_pago'] = $intereses;
                                 $pagos['tipopago'] = "Intereses";
                                 $pagos['pagocompleto'] = true;
                                 $ultimopagos = Pago::select("mespago")
                                    ->where("cliente_id",$prestamo['cliente_id'])
                                    ->where("prestamo_id",$id)
                                    ->where("tipopago","Intereses")
                                    ->orderBy('id', 'desc')->first();
                                 $fechas = Carbon::createFromFormat('Y-m-d', $ultimopagos['mespago']);
                                 $fechas->addMonth();
                                 $pagos['mespago'] = $fechas;
                                 $ingreso  = $ingreso - $intereses;    
                                 $numcuota++;
                                 Pago::create($pagos);
                                 $update["total_intereses"] = $prestamo["total_intereses"]-$restante;
                                $prestamo->update($update);
                             }
                
                         }

                
                         if($ingreso >= 0){
                             if($exedente < 0 && $ingreso>0){
                             $pagos['cliente_id'] = $prestamo['cliente_id'];          
                             $pagos['prestamo_id'] = $id;          
                             $pagos['num_cuota'] = $numcuota;
                             $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];
                             $pagos['fechpago'] = Carbon::now();
                             $pagos['usuario_id'] = auth()->id();
                             $pagos['ganancias'] = $ingreso;
                             $pagos['valor_pago'] = $ingreso;
                             $pagos['tipopago'] = "Intereses";
                             $pagos['pagocompleto'] = false;                             
                             $ultimopagos = Pago::select("mespago")
                                ->where("cliente_id",$prestamo['cliente_id'])
                                ->where("prestamo_id",$id)
                                ->where("tipopago","Intereses")
                                ->orderBy('id', 'desc')->first();
                             $fechas = Carbon::createFromFormat('Y-m-d', $ultimopagos['mespago']);
                             $fechas->addMonth();
                             $pagos['mespago'] = $fechas;
                             $ingreso  = $ingreso - $intereses;                                   
                             Pago::create($pagos);
                                 }
                                 
                                 if($exedente > 0){
                             $pagos['cliente_id'] = $prestamo['cliente_id'];          
                             $pagos['prestamo_id'] = $id;          
                             $pagos['num_cuota'] = $numcuota;
                             $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];
                             $pagos['fechpago'] = Carbon::now();
                             $pagos['usuario_id'] = auth()->id();
                             $pagos['ganancias'] = $exedente;
                             $pagos['valor_pago'] = $exedente;
                             $pagos['tipopago'] = "Abono";
                             $pagos['pagocompleto'] = false;
                             $ingreso  = $ingreso - $intereses;                                   
                             Pago::create($pagos);
                             
                             $usu["cupo"] = $usuario["cupo"]+ $exedente;
                            $usuario->update($usu);
                             $upd["total_deuda"] = $prestamo["total_deuda"]-$exedente;
                             $upd["pagos"] = 1;
                             $prestamo->update($upd);
                         }
                         
                                 }
                               
                            }
                            
                        }
              
                        
                        
                    }                
                }
                
             if($request->interesactual < $intereses){
                 $lastpago = Pago::where("prestamo_id",$id)
                                ->where("tipopago","Intereses")->OrderBy("num_cuota","desc")->first();
                 
                 if($ingreso < $request->interesactual){
                     $fecha = Carbon::createFromFormat('Y-m-d', $lastpago['mespago']);
                     
                         $pago['mespago'] = $fecha;
                         $pago['ganancias'] = $ingreso + $lastpago["ganancias"];
                         $pago['tipopago'] = "Intereses";
                         $pago['pagocompleto'] = false;
                         $pago['valor_pago'] = $ingreso ;
                         Pago::create($pago);
                         
                     
                 }
                 if ($ingreso == $request->interesactual){
                     $fecha = Carbon::createFromFormat('Y-m-d', $lastpago['mespago']);
                         $pago['mespago'] = $fecha;
                         $pago['ganancias'] = $ingreso + $lastpago["ganancias"];
                         $pago['tipopago'] = "Intereses";
                         $pago['pagocompleto'] = true;
                         $pago['valor_pago'] = $ingreso ;
                         Pago::create($pago);
                 }
                 
                 if($ingreso > $request->interesactual){
                     //por defecto el ultimo pago fue incompleto y al completar los exedentes los intereses quedan en 0
                     $sobrante = $ingreso - $request->interesactual;  
                     $numcuota = $request->fknum_cuota;
                     $intact = $request->interesactual;
                   
                     
                     $fecha = Carbon::createFromFormat('Y-m-d', $lastpago['mespago']);
                         $pago['mespago'] = $fecha;
                         $pago['ganancias'] = $intact + $lastpago["ganancias"];
                         $pago['tipopago'] = "Intereses";
                         $pago['pagocompleto'] = true;
                         $pago['valor_pago'] = $request->interesactual;
                         Pago::create($pago);
                         $numcuota++;
                         
                         $pagos['cliente_id'] = $prestamo['cliente_id'];          
                         $pagos['prestamo_id'] = $id;          
                         $pagos['num_cuota'] = $numcuota;
                         $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];
                         $pagos['fechpago'] = Carbon::now();
                         $pagos['usuario_id'] = auth()->id();
                         $pagos['ganancias'] = $sobrante;
                         $pagos['tipopago'] = "Abono";
                         $pagos['valor_pago'] = $sobrante;
                         $pagos['pagocompleto'] = false;               
                         $fecha = (Carbon::createFromFormat('Y-m-d',$lastpago['mespago']));
                         $pagos['mespago'] = $fecha;
                         
                         Pago::create($pagos);
                         $usu["cupo"] = $usuario["cupo"]+ $sobrante;
                            $usuario->update($usu);
                         
                         $upd["total_deuda"] = $prestamo["total_deuda"]-$sobrante;
                         $upd["pagos"] = 1;
                             $prestamo->update($upd);
                         
                         
                 }
                 
                
                 
             }
            
            }    
            else{
                
                $pagos['cliente_id'] = $prestamo['cliente_id'];          
                         $pagos['prestamo_id'] = $id;          
                         $pagos['num_cuota'] = $request->fknum_cuota;;
                         $pagos['valor_deuda_inicial'] = $prestamo['total_deuda'];
                         $pagos['fechpago'] = Carbon::now();
                         $pagos['usuario_id'] = auth()->id();
                         $pagos['ganancias'] = $request->pago;
                         $pagos['tipopago'] = "Abono";
                         $pagos['valor_pago'] = $request->pago;
                         $pagos['pagocompleto'] = false;               
                        
                         
                         Pago::create($pagos);
                         $usu["cupo"] = $usuario["cupo"]+ $request->pago;
                            $usuario->update($usu);
                         
                         $upd["total_deuda"] = $prestamo["total_deuda"]- $ingreso;
                         $upd["pagos"] = 1;
                             $prestamo->update($upd);
                
            }
            
            
         }else{
                 
                 Session::flash('pagosuperior','El pago supera la deuda total o es inferior/igual a 0');
            return redirect("RegistrarPago");             
             }
         
         
          if($prestamo["total_deuda"]==0){
                 $upd["estado"] = false;
                 $prestamo["fechafin"] = Carbon::now();
                 $upd["pagos"] = 1;
                 $prestamo->update($upd);
                 $cli["prestamoactivo"] = false;
                 $cliente->update($cli);
                 
                 $prestamootravez = Prestamo::findOrFail($id);             
             if($prestamootravez["estado"] === 0){
                 $pre["total_intereses"]= 0;
                 $prestamootravez->update($pre);
             }   
             
             $noti = Notificacion::where("cliente_id",$cliente["id"])->count();
             $notifi = Notificacion::where("cliente_id",$cliente["id"]);
             if($noti > 0){
                 $notifi->delete();
             }
             $upd["pagos"] = 1;
             $prestamo->update($upd);
                 Session::flash('deudafinalizada','Felicidades, su cliente ha finalizado su deuda');
            return redirect("RegistrarPago");                 
             }
             
             $noti = Notificacion::where("cliente_id",$cliente["id"])->count();
             $notifi = Notificacion::where("cliente_id",$cliente["id"]);
             if($noti > 0){
                 $notifi->delete();
             }
             
             $upd["pagos"] = 1;
             $prestamo->update($upd);
             Session::flash('pagorealizado','El pago fue realizado correctamente');
            return redirect("RegistrarPago");
        }
        
          public function HacerPrestamo(Request $request) {
          
         
          $this->validate($request, ['cliente' => 'required']);
          $this->validate($request, ['monto' => 'required']);
          $this->validate($request, ['intereses' => 'required|numeric|max:999999999']);
         // $this->validate($request, ['fechaprestamo' => 'required']);
     
          $request->monto = str_replace (",","", $request->monto);
          $prestamo['cliente_id'] = $request->cliente;
          $prestamo['monto'] = $request->monto;
          $prestamo['intereses'] = $request->intereses;
          $prestamo['total_deuda'] = $request->monto;
          $prestamo['total_intereses'] = (($request->monto / 100)*$request->intereses);
          $prestamo['pagos'] = 0;
          $prestamo['estado'] = false;
          $hoyy = date("Y-m-d");          
          if($request->fechaprestamo > $hoyy){
              Session::flash('message-successs','La fecha del prestamo no puede ser superior a hoy');
            return redirect("HacerPrestamo");
          }
          if($request->fechaprestamo === null){
              $prestamo["fechinicio"] = Carbon::now()->addDays(1);
          }else{
          $prestamo["fechinicio"] = Carbon::createFromFormat("Y-m-d", $request->fechaprestamo)->addDays(1);
          }
           $usu = Usuario::findOrFail(auth()->id());
          
          if($request->monto > $usu["cupo"] | $request->monto <= 0   ){
              
              Session::flash('sobrecupos','El prestamo no puede ser superior a lo que puedes prestar o ser inferior/igual a 0');
              return redirect("HacerPrestamo");
          }
          
          if($request->intereses < 5){
              Session::flash('faltadinero','Los intereses de la deuda no pueden ser inferiores al 5%');
        
        return redirect("TipoPrestamo");
          }
          
          if($request->intereses > 20){
              Session::flash('faltadinero','Los intereses de la deuda no pueden ser superiores al 20%');
       return redirect("TipoPrestamo");
          }
          
          $prestamo['estado'] = true;
          $prestamo['usuario_id'] = auth()->id();
          
          Prestamo::create($prestamo);
          
           $cliente = Cliente::findOrFail($request->cliente);
           $cliente->prestamoactivo = true;
           $cliente->save();
           
           
           $upd["cupo"] = $usu["cupo"] - $request->monto;
           $usu->update($upd);

         Session::flash('message-success','El prestamo fue registrado correctamente');
         //$clientes = Cliente::all()->where("prestamoactivo", false);
            return redirect("HacerPrestamo");
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
