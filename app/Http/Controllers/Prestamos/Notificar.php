<?php
namespace App\Http\Controllers\Prestamos;

use App\Models\Prestamos\Pago;
use App\Models\Prestamos\Prestamo;
use App\Models\Prestamos\Notificacion;
use Carbon\Carbon;


 class Notificar{
public function CrearNotificaciones() {
           $prestamos = Prestamo::all()->where("estado","1")->where("usuario_id", auth()->id());
           $notificaciones = Notificacion::all()->where("usuario_id", auth()->id());
           
           foreach($notificaciones as $notificacion){
                $aaa = Carbon::createFromFormat('Y-m-d', $notificacion["creado"]);
                $diferencia = $aaa->diffInDays(Carbon::now());
                if($diferencia > 3){
                    $notificacion->delete();
                }
           }
           
           foreach($prestamos as $prestamo){
               $abono = Pago::where("prestamo_id",$prestamo['id'])->where("tipopago","Intereses")->count();
               
               if($abono === 0){
                   if($prestamo["mesesmora"] > 0){
                $fecha_inicio = Carbon::createFromFormat('Y-m-d', $prestamo["fechinicio"]);                
                $meses_mora   = $prestamo["mesesmora"];               
              $fechaprometida = $fecha_inicio->addMonth($meses_mora);               
               $diferenciaesperada = $fecha_inicio->diffInDays(Carbon::now());
                        if(Carbon::now() > $fechaprometida && $diferenciaesperada >= 0 && $diferenciaesperada <=3){
                            $notiante = Notificacion::where("prestamo_id",$prestamo['id'])->count();
                            if($notiante === 0){
                                $new["cliente_id"]= $prestamo["cliente_id"];
                            $new["prestamo_id"]= $prestamo["id"];
                            $new["mora"] = $prestamo["mesesmora"];
                            $new["creado"]= Carbon::now()->subDays($diferenciaesperada);
                            $new["usuario_id"]= auth()->id();
                            Notificacion::create($new);
                            }                            
                        }                       
                   }                   
               }else{
                   $ultimopago = Pago::where("cliente_id",$prestamo['cliente_id'])
                           ->where("prestamo_id",$prestamo['id'])->where("tipopago","Intereses")
                           ->orderBy('num_cuota', 'desc')->first();
                   $fecha_inicio = Carbon::createFromFormat('Y-m-d', $ultimopago["mespago"]);                
                   $lastpago = Carbon::createFromFormat('Y-m-d', $ultimopago["fechpago"]);                     
                $meses_mora   = $prestamo["mesesmora"];               
              $fechaprometida = $fecha_inicio->addMonth($meses_mora);               
             $diferenciaesperada = $fecha_inicio->diffInDays(Carbon::now());
             
             if($lastpago->diffInDays(Carbon::now()) >= 0 && $lastpago->diffInDays(Carbon::now()) <=3){
            
             }else{           
              if(Carbon::now() > $fechaprometida && $diferenciaesperada >= 0 && $diferenciaesperada <=3){
          
                            $notiante = Notificacion::where("prestamo_id",$prestamo['id'])->count();
                            if($notiante === 0){
                            $new["cliente_id"]= $prestamo["cliente_id"];
                            $new["prestamo_id"]= $prestamo["id"];
                            $new["mora"] = $prestamo["mesesmora"];
                            $new["creado"]= Carbon::now()->subDays($diferenciaesperada);
                            $new["usuario_id"]= auth()->id();
                            Notificacion::create($new);
                            
                  }
               }
             }
               }
           }
      }
      }
      
      ?>