 <?php 
 use App\Models\Prestamos\Notificacion; 
 use App\Models\Seguridad\Cliente; 
 $contnoti = Notificacion::where("usuario_id", auth()->id())->count();
 $notificaciones = Notificacion::all()->where("usuario_id", auth()->id());
 
 ?>       
<div class="card-body"></div>
 
     <span> Bienvenid@ {{auth()->user()->nombres}} {{auth()->user()->apellidos}} </span>
     
      <div class="topbar-divider d-none d-sm-block"></div>

              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                @if($contnoti > 0)
                <span class="badge badge-danger badge-counter">{{$contnoti}}</span>
                @endif
                
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Notificaciones
                </h6>
                
                  @if($contnoti === 0)
                  <a class="dropdown-item d-flex align-items-center">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500"><?php
                     $originalDate = date("Y-m-d");
                       $newDate = date("d/m/Y", strtotime($originalDate));  
                       echo $newDate;?></div>
                    Usted no tiene notificaciones actualmente
                  </div>
                </a>
                  @endif
                  
                  @if($contnoti > 0)
                  
                  @foreach ($notificaciones as $notificacion)
                   <a class="dropdown-item d-flex align-items-center" href="RegistrarPago{{$notificacion["prestamo_id"]}}">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500"><?php
                     $originalDate = $notificacion["creado"];
                       $newDate = date("d/m/Y", strtotime($originalDate));  
                       echo $newDate;?></div>
                    <?php
                    $cliente = Cliente::findOrFail($notificacion["cliente_id"]);
                    
                    echo "El cliente ".$cliente["primer_nombre"]." ".$cliente["primer_apellido"].""
                            . " acumula ".($notificacion["mora"]+1)." mes(es) de mora"?>
                  </div>
                </a>
                  @endforeach
                  @endif                
                <a class="dropdown-item text-center small text-gray-500" >Developed by Enrique de Armas</a>
              </div>

     <div class="topbar-divider d-none d-sm-block"></div>
     
     <img class="img-profile rounded-circle" style="width: 60px; height: 60px; " src="images/user.png">
              
     

</ul>
        </nav>
        <div class="container-fluid">