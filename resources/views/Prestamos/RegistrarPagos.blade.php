  <?php 
  use Carbon\Carbon;
  ?>
@include('layouts.config1')
<title>Registrar Pago</title>
@include('layouts.config2')

    
  @include('layouts.seguridad')
         <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
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
             @if(Session::has('pagosuperior'))
 <div class="alert alert-danger alert-dismissible" role="alert">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('pagosuperior')}}</b>
 </div>
     
 @endif
            
 @if(Session::has('pagorealizado'))
 <div class="alert alert-success alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('pagorealizado')}}</b>
 </div>
     
 @endif
 
 @if(Session::has('actualizado'))
 <div class="alert alert-success alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('actualizado')}}</b>
 </div>
     
 @endif
 
 @if(Session::has('pagodiferente'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('pagodiferente')}}</b>
 </div>
     
 @endif
 @if(Session::has('nodebeintereses'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('nodebeintereses')}}</b>
 </div>
     
 @endif
 @if(Session::has('debeintereses'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('debeintereses')}}</b>
 </div>
     
 @endif
 @if(Session::has('pagonovalido'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('pagonovalido')}}</b>
 </div>
     
 @endif
 @if(Session::has('pagodemas'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('pagodemas')}}</b>
 </div>
     
 @endif
 @if(Session::has('pagodemenos'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('pagodemenos')}}</b>
 </div>
     
 @endif
 
 @if(Session::has('deudafinalizada'))
 <div class="alert alert-success alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('deudafinalizada')}}</b>
 </div>
     
 @endif

          <!-- Page Heading -->
        
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
           
            <div class="card-body">
                
             
              <div class="table-responsive">
                  
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Identificación</th>
                      <th>Nombre completo</th>

                    <th>Fecha del Prestamo</th>
                      <th>Dirección</th>
                      <th>Valor deuda</th>
                                            <th>Valor intereses</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                       <th>Identificación</th>
                      <th>Nombre completo</th>
                      
                      <th>Fecha del Prestamo</th>
                      <th>Dirección</th>
                      <th>Valor deuda</th>
                      <th>Valor intereses</th>
                    </tr>
                  </tfoot>
                  <tbody>
                      
                                @foreach($prestamosactivos as $prestamo)  
                                 
                                   <tr>
                                       <?php if(Carbon::now() < $prestamo->fechinicio){ ?>
                                          <td>{{$prestamo->cliente->identidad}}</td>  
                                       <?php }else{ ?>
                                          <th scope="row"><a href="RegistrarPago{{$prestamo->id}}">{{$prestamo->cliente->identidad}}</a></th>
 
                                      <?php } ?>
                                       
                      <td>{{$prestamo->cliente->primer_nombre}} {{$prestamo->cliente->primer_apellido}}</td>
                                          
                      <td><?php $originalDate = $prestamo->fechinicio;
                       $newDate = date("d/m/Y", strtotime($originalDate));  
                       echo $newDate; 
                       if($prestamo->total_intereses > 0){
                           echo " (".($prestamo->mesesmora+1).")";
                       }
                       
                       if($prestamo->total_intereses === 0){
                           echo " (".($prestamo->mesesmora).")";
                       }
                       
                       
                       
                       ?></td>
                      <td>{{$prestamo->cliente->direccion}}</td>  
                      <td>{{number_format($prestamo->total_deuda)}}</td>
                      <td>{{number_format($prestamo->total_intereses)}}</td> 

                      
                    </tr>

      


        @endforeach
                  
                    
                    
                    
                  </tbody>
                </table>
              </div>
            </div>
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
            <span>Copyright &copy; Developed by Enrique de Armas<br>
                  All rights reserved
            </span>
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

