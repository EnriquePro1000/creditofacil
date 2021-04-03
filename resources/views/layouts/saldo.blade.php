<?php 
use App\Models\Seguridad\Usuario;
$a = Usuario::all()->where("id", auth()->id());
      
        foreach($a as $sal){
          $saldo = $sal["cupo"];           
        }
        ?>


<h4 class="m-0 font-weight-bold text-primary">saldo disponible: <?php echo number_format($saldo) ?>$</h4>