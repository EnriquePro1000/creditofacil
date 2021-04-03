<!DOCTYPE html>

@include('layouts.config1')
<title>Registrar Pago</title>
@include('layouts.config2')
    
  @include('layouts.seguridad')
  
         <li class="nav-item active">
        <a class="nav-link collapsed"  data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i> </i>
          <span>Prestamos</span>
        </a>
        <div id="collapseUtilities" class="collapse show" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="HacerPrestamo" onclick = "location = 'HacerPrestamo'" href="utilities-color.html">Hacer Prestamo</a>
            <a class="collapse-item" href="EditarPrestamo" onclick = "location = 'EditarPrestamo'" href="utilities-color.html">Editar Prestamo</a>
            <a class="collapse-item active" href="RegistrarPago" onclick = "location = 'RegistrarPago'" href="utilities-border.html">Registrar Pago</a>            
          <a class="collapse-item" href="HistorialPago" onclick = "location = 'HistorialPago'" href="utilities-border.html">Historial de Pago</a>
          </div>
        </div>
      </li>
      
            @include('layouts.logout')   
      
              
      
    @include('layouts.middleconfig1')
    
        @include('layouts.saldo')
    
    
    @include('layouts.middleconfig2')

      <div id="content">

        <div class="container-fluid">

          <!-- Page Heading -->
        
          <!-- DataTales Example -->
        
             <div class="col-lg-4" style="margin: 0 auto;">
            
         
              
        <form method="post" enctype="multipart/form-data" action="RegistrarPago{{$prestamo->id}}"> {{csrf_field()}}                
                  @if(count($errors)>0)
    <div class="alert alert-danger">
        <ul>
    @foreach($errors->all() as $error)
     <?php echo "corrige los siguientes errores: "?><li>{{$error}}</li>
    @endforeach
        </ul>
    </div>
    @endif
                    <div class="form-group">
                        <?php echo "Cliente"; ?> 
                     <input type="text" readonly="readonly"  class="form-control form-control-user" name ='informacion' value=" {{$prestamo->cliente->identidad}} ({{$prestamo->cliente->primer_nombre}} {{$prestamo->cliente->primer_apellido}})">
                </div>
           
                    <div class="form-group">
                        <?php echo "Fecha del prestamo"; ?> 
                     <input type="text" readonly="readonly" class="form-control form-control-user" name ='fechaprestamo' value="<?php 
                         $originalDate = $prestamo['fechinicio'];
                       $newDate = date("d/m/Y", strtotime($originalDate));  
                       echo $newDate;?>">
                </div>
    
    
                    <div class="form-group">
                        <?php echo "Fecha ultimo pago"; ?> 
                     <input type="text" readonly="readonly" class="form-control form-control-user" name ='fechaultimopago' value="<?php 
                     if($prestamo['fechpago'] === "no registra"){
                         echo "no registra";
                     }else{
                      $originalDate = $prestamo['fechpago'];
                       $newDate = date("d/m/Y", strtotime($originalDate));  
                       echo $newDate;   
                     }
                     ?>">
                </div>
           
       
               
            
                  <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                      
                      <script>
        
    function format(input)
{
var num = input.value.replace(/\,/g,'');
if(!isNaN(num)){
num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,');
num = num.split('').reverse().join('').replace(/^[\,]/,'');
input.value = num;
}
 
else{ alert('Solo se permiten numeros');
input.value = input.value.replace(/[^\d\,]*/g,''," ");
}
}
    </script>
                      
                       <?php echo "Pago #{$prestamo['num_cuota']}  por valor de:"; ?> 
                      
                    
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                      <input type="text" class="form-control form-control-user" onkeyup="format(this)" onchange="format(this)" name ='pago' value="{{number_format($prestamo['recomendado'])}}">
                  
                   
                  </div>
                    </div> 
   
               
            
            
                  <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                       <?php echo "Actualmente Debe: "; ?> 
                      
                    
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                        <?php $num15 = $prestamo['deudaactual'];
                      $num16 = number_format($num15);
                              ?>
                      
                      <input id="number"  readonly="readonly" class="form-control form-control-user" name ='porcobrarmuestra' value="{{$num16}}">
                      <input id="number" type="hidden" readonly="readonly" class="form-control form-control-user" name ='porcobrar' value="{{$prestamo['deudaactual']}}">
                  
                   
                  </div>
                </div> 
    
                  <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                       <?php echo "Actualmente debe en intereses: "; ?> 
                      
                    
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                      <?php $num11 = $prestamo['interesesactuales'];
                      $num12 = number_format($num11);
                              ?>
                      
                      <input id="number"  readonly="readonly" class="form-control form-control-user" name ='interesactualmuestra' value="{{$num12}}">
                      <input id="number"  type="hidden" readonly="readonly" class="form-control form-control-user" name ='interesactual' value="{{$prestamo['interesesactuales']}}">
                  
                   
                  </div>
                </div> 
    
                  
                    
            <input type="hidden" readonly="readonly" class="form-control form-control-user" name='fknum_cuota' value="{{$prestamo['num_cuota']}}">
                  
                
               
       
                       
                    <button class="btn btn-success btn-user btn-block"  data-toggle="modal" data-target="#RegistrarModal" type="button">Registrar Pago</button>
                    <div class="modal fade" id="RegistrarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿Seguro?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Selecciona "Registrar" si estas seguro de querer registrar un abono de la deuda</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          
          
          <button type="submit" class="btn btn-success">Registrar</button>
          
        </div>
      </div>
    </div>
  </div>   
                     
        
        </form>
                 
                 <br>
                 
          
                 <form  method="post" enctype="multipart/form-data" action="LiquidarDeuda{{$prestamo->id}}"> {{csrf_field()}} 
                     <button class="btn btn-danger btn-user btn-block"  data-toggle="modal" data-target="#LiquidarModal" type="button">Liquidar deuda</button>
                 <div class="modal fade" id="LiquidarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿Seguro?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
          
          
        <div class="modal-body">Al liquidar una deuda, se perdonará una pequeña cantidad de dinero, recuerda, solo puedes liquidar intereses, no se permiten perdidas sobre el dinero prestado.</div>
        <div class="modal-body"> <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                      
                      
                      
                       <?php echo "Pago por:"; ?> 
                      
                    
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                      <input type="text" class="form-control form-control-user" onkeyup="format(this)" onchange="format(this)" name ='pago' required>
                  
                   
                  </div>
                    </div></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          
          
          <input id="number"  type="hidden" readonly="readonly" class="form-control form-control-user" name ='interesactual' value="{{$prestamo['interesesactuales']}}">
           <input id="number" type="hidden" readonly="readonly" class="form-control form-control-user" name ='porcobrar' value="{{$prestamo['deudaactual']}}">
           
          <button type="submit" class="btn btn-danger">Liquidar</button>
          
        </div>
      </div>
    </div>
  </div>   
                 </form> 
 
             </div>
      
        
                
                
                
                
                
                
                
                
                
                
          


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      
      
            <div class="col-lg-6 mb-4">                
            </div>          
          </div>
              
      </div>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>

