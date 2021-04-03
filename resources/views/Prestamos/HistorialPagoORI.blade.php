<?php
use App\Models\Prestamos\Pago;
?>

@include('layouts.config1')
<title>Historial de Pago</title>

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
            <a class="collapse-item" href="RegistrarPago" onclick = "location = 'RegistrarPago'" href="utilities-border.html">Registrar Pago</a>            
          <a class="collapse-item active" href="HistorialPago" onclick = "location = 'HistorialPago'" href="utilities-border.html">Historial de Pago</a>
          </div>
        </div>
      </li>
      
    @include('layouts.logout')    
    @include('layouts.middleconfig1')
     <h4 class="m-0 font-weight-bold text-primary"> <?php echo "Clientes / ".$cliente->primer_nombre." ".$cliente->primer_apellido;?> </h4>
    <!--@include('layouts.saldo')-->
    
    @include('layouts.middleconfig2')
    
    
    
      <div id="content">

        <div class="container-fluid">
              

          <!-- Page Heading -->
        
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
             
         
            <div class="card-body">

              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Monto / Tarifa</th>
                      <th>Ganancias</th>
                      <th>Recuperado</th>
                      <th>Inicio / Fin</th>
                      <th>Historial de Pagos</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                       <th>#</th>
                      <th>Monto / Tarifa</th>
                      <th>Ganancias</th>
                      <th>Recuperado</th>
                      <th>Inicio / Fin</th>
                      <th>Historial de Pagos</th>
                    </tr>
                  </tfoot>
                  <tbody>
                      
                                 @foreach($prestamos as $prestamo)  
                                 
                                   <tr>
                                       
                                       
                                       
                      
                      <td><?php $originalDate = $prestamo['fechinicio'];
                       $newDate = date("d/m/Y", strtotime($originalDate));  ?> 
                      {{$prestamo->orden}}</td>
                      <td>{{number_format($prestamo->monto)}}$ <strong>({{$prestamo->intereses}}%)<strong></td>
                      <td><?php
                      $total = Pago::where("prestamo_id",$prestamo->id)->where("tipopago","Intereses")->sum("valor_pago");
                      echo number_format($total)."$"; ?></td>
                        <td>{{number_format($prestamo->monto - $prestamo->total_deuda)}}$</td>                    
                      <td><?php 
                      if($prestamo["fechafin"] === null){
                          $originalDate12 = $prestamo['fechinicio'];
                       $newDate12 = date("d/m/Y", strtotime($originalDate12));
                          echo $newDate12." / no registra";
                      }else{
                          $originalDate12 = $prestamo['fechinicio'];
                       $newDate12 = date("d/m/Y", strtotime($originalDate12));
                          $originalDate = $prestamo['fechafin'];
                       $newDate = date("d/m/Y", strtotime($originalDate));  
                       echo $newDate12." / ".$newDate;
                      }
                      ?></td>
                      
                      <form method="post" action="HistorialPago{{$prestamo->id}}"> {{csrf_field()}} 
                                          <th scope="row">
                                            
                                                  
                    <input type="hidden" class="cons" readonly="readonly" class="form-control form-control-user" name='id' value="{{$cliente->id}}">                  
                    <button type="submit" style="border: 1em; background: rgba(0, 0, 0, .0); "><img src="images/3678499.jpg" style="width: 50px; height: 50px; margin-left: 50px;"></button></th> 
         
                                       </form>
                   
                    
                      
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




