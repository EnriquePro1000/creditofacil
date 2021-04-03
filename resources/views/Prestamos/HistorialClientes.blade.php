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
    
     <h5 class="m-0 font-weight-bold text-primary"> <?php echo "Clientes";?> </h5>
    <!--@include('layouts.saldo')-->
    
    @include('layouts.middleconfig2')
    
    
    

      <div id="content">

        <div class="container-fluid">
              

          <!-- Page Heading -->
        
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
             
         
            <div class="card-body">
                 <?php echo "Cliente"; ?>

              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                     <th><h5><strong><p style="color: black;">Identificación</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Nombres</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Apellidos</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Telefono</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Cedula</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Prestamos</p></strong></h5></th>  
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th><h5><strong><p style="color: black;">Identificación</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Nombres</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Apellidos</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Telefono</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Cedula</p></strong></h5></th>
                      <th><h5><strong><p style="color: black;">Prestamos</p></strong></h5></th>  
                    </tr>
                  </tfoot>
                  <tbody>
                      
                                 @foreach($clientes as $cliente)  
                                 
                                   <tr>
                                  
                      
                      <td> <h5><p style="color:#218BC3;">{{$cliente->identidad}}</p></h5></td>
                      <td> <h5><p style="color:#218BC3;">{{$cliente->primer_nombre}}</p></h5></td>
                      <td> <h5><p style="color:#218BC3;">{{$cliente->primer_apellido}}</p></h5></td>
                      <td> <h5><p style="color:#218BC3;">{{$cliente->telefono}}</p></h5></td>
              <td><a href="PDFClientes/{{$cliente->pdf}}" target="_blank"><img src="images/eyes.png" style="width: 60px; height: 50px; margin-left: 10px;"></td>
                      
                   
                    
                      <td><a href="HistorialPago{{$cliente->id}}"><img src="images/3678499.jpg" style="width: 50px; height: 50px; margin-left: 50px;"></td>
                      
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

