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
          <a class="collapse-item active" href="HistorialPago{{$cliente->id}}" onclick = "location = 'HistorialPago{{$cliente->id}}'" href="utilities-border.html">Historial de Pago</a>
          </div>
        </div>
      </li>
      
    @include('layouts.logout')    
    @include('layouts.middleconfig1')
    
    <?php 
                $originalDate3 = $prestamo->fechinicio;
                $newDate3 = date("d/m/Y", strtotime($originalDate3));?>
                
                <h5 class="m-0 font-weight-bold text-primary"> <?php echo "Clientes / ".$cliente->primer_nombre." ".$cliente->primer_apellido." / Historial de pago";?> </h5>
    
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
                      <th><h5><strong><p style="color: black;">#</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Tipo Pago</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Pago por</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">P.C</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Mes Pagado</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Fecha Pago</p></strong></h5></th>                                         
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                   <th><h5><strong><p style="color: black;">#</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Tipo Pago</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Pago por</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">P.C</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Mes Pagado</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Fecha Pago</p></strong></h5></th>  
                    </tr>
                  </tfoot>
                  <tbody>
                      
                                 @foreach($pagos as $pago)  
                                 
                                   <tr>                                                                            
                                       
                      
                      <td><h5><strong><p style="color: black;">{{$pago->num_cuota}}</p></strong></h5></td>
                      <td><?php if ($pago->tipopago === "Intereses"){ ?>
                          <h5><p style="color:green;">{{$pago->tipopago}}</p></h5> 
                      <?php } if ($pago->tipopago === "Abono"){ ?>
                          <h5><p style="color: #218BC3;">{{$pago->tipopago}}</p></h5> 
                      <?php } if ($pago->tipopago === "Liquidado"){ ?>
                          <h5><p style="color:red;">{{$pago->tipopago}}</p></h5> 
                     <?php };?></td>
                      
                      <td><h5><p style="color: green;">{{number_format($pago->valor_pago)}} $</p></h5></td>
                      
                      <td>
                          <?php if($pago->tipopago === "Abono"){ ?>
                             <h5><p style="color:#218BC3;">-- </p></h5>         
                         <?php }else if($pago->tipopago === "Liquidado"){ ?>
                             <h5><p style="color:red;">-- </p></h5>    
                        <?php }else{ if($pago->pagocompleto === 1){ ?>
                          <h5><p style="color: green;">si </p></h5>
                     <?php } else { ?>
                      <h5><p style="color:red;">no </p></h5>                      
                        <?php }} ?>
                      </td>
                      <td><?php                       
                      if($pago->tipopago === "Abono"){ ?>
                         <h5><p style="color:#218BC3;">no aplica</p></h5>  
                      <?php }else if($pago->tipopago === "Liquidado"  ){ ?>
                          <h5><p style="color:red;">no aplica</p></h5>  
                      <?php } else if($pago->tipopago === "Intereses"){
                          $originalDate2 = $pago->mespago;
                       $newDate2 = date("d/m/Y", strtotime($originalDate2));
                       $newDate2;
                          $repeat= 0;
                          
                      $pagos2 = Pago::all()->where("prestamo_id",$idd)->where("tipopago","Intereses");
                      foreach ($pagos2 as $pay){
                          if($pago->mespago === $pay->mespago){
                              $repeat++;
                          }                          
                      }
                      if($repeat >1){ ?>
                          <h5><p style="color:red;">{{$newDate2}}</p></h5>  
                      <?php }else{ ?>
                          <h5><p style="color:green;">{{$newDate2}}</p></h5>  
                       <?php }}?></td>
                      <td><?php 
                      $repeat= 0;
                      foreach ($pagos as $pay){
                          if($pago->fechpago === $pay->fechpago){
                              $repeat++;
                          }                          
                      }
                      $originalDate1 = $pago->fechpago;
                       $newDate1 = date("d/m/Y", strtotime($originalDate1));
                       $newDate1;
                      if($repeat>1){ ?>
                          <h5><p style="color:green;">{{$newDate1}}</p></h5>  
                     <?php }else{ ?>
                         <h5><p style="color:green;">{{$newDate1}}</p></h5>  
                    <?php }
                      
                      ?></td>

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




