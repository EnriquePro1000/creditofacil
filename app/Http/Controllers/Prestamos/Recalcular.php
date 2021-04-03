<?php

namespace App\Http\Controllers\Prestamos;
use Carbon\Carbon;
use App\Models\Prestamos\Prestamo;
use App\Models\Prestamos\Pago;



class Recalcular
{

  public function RecalcularDeudas() {
          
          $prestamos = Prestamo::all()->where("estado", true);
          
          foreach($prestamos as $prest){
              $abono = Pago::where("prestamo_id",$prest['id'])->where("tipopago","Intereses")->count();
              $valorintereses = ($prest["total_deuda"]/100)* $prest["intereses"];
              
              if($abono === 0){
                  $today = Carbon::now();
                  $fechaprestamo = Carbon::createFromFormat('Y-m-d', $prest['fechinicio']);
                 $diasDiferencia = $fechaprestamo->diffInDays($today);
                 $mesDiferencia = $fechaprestamo->diffInMonths($today);
                  $dias = 0;
                  $meses = 0;
                  $mes = 1;
                  while ($meses <= $mesDiferencia){                   
                      $intereses['total_intereses'] = (($prest['total_deuda']/100)*$prest['intereses'])*$mes;
                  $intereses["mesesmora"] = $mesDiferencia;
                      $mes++;
                  $meses++;
                  }
                   $prest->update($intereses);
                  }
                  
                  
                  else{
                      
                      
                      $today = Carbon::now();
                      $fechaprestamo = Pago::select("mespago","pagocompleto","ganancias")->where("cliente_id",$prest['cliente_id'])->where("prestamo_id",$prest['id'])->where("tipopago","Intereses")->orderBy('num_cuota', 'desc')->first();
                  $ultimomespago = Carbon::createFromFormat('Y-m-d', $fechaprestamo['mespago']);
                  $diasDiferencia = $ultimomespago->diffInDays($today);
                  $mesDiferencia = $ultimomespago->diffInMonths($today);
                  
                  if($fechaprestamo['pagocompleto'] === 1){
                      
                      if($fechaprestamo["mespago"] >= Carbon::now()){
                          $intereses['total_intereses'] = 0;
                           $intereses["mesesmora"] = $mesDiferencia;
                          $prest->update($intereses);
                  
                      }else{
                       
                     
                      $dias = 0;
                  $meses = 0;
                  
                  $mes = 1;
                     
                    
                         
                           while ($meses <= $mesDiferencia ){           
                          
                      $intereses['total_intereses'] = (($prest['total_deuda']/100)*$prest['intereses'])*$mes;
                   $intereses["mesesmora"] = $mesDiferencia;
                  $mes++;
                  $meses++;

                  
                  }
                  $prest->update($intereses);
                   
                      }
                  }
                  
                  
                  if($fechaprestamo['pagocompleto'] === 0){
                      
                      if($fechaprestamo["mespago"] >= Carbon::now()){
                          $intereses['total_intereses'] = $valorintereses - $fechaprestamo["ganancias"];
                   $intereses["mesesmora"] = $mesDiferencia;
                          $prest->update($intereses);
                  
                      }else{
                  $dias = 0;
                  $meses = 0;
                  
                  $mes = 1;
                  
                
                           while ($meses <= $mesDiferencia){    
                         
                                    $intereses['total_intereses'] = (($prest['total_deuda']/100)*$prest['intereses'])*$mes + ($valorintereses - $fechaprestamo["ganancias"]);
                   $intereses["mesesmora"] = $mesDiferencia;
                      
                   $mes++;
                  $meses++;
         
                         }
                         $prest->update($intereses);
                      }
                  }}
              
          }
          
        return true;
          
    }   
}