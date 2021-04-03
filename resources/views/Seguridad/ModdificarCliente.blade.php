    @include('layouts.config1')
<title>Modificar Cliente</title>
@include('layouts.config2')  
    
    
      <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i> </i>
          <span>Seguridad</span>
        </a>
        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            @if (auth()->id() === 1)
              
              <a class="collapse-item" href="RegistrarUsuario" onclick = "location = 'RegistrarUsuario'">Registrar usuario</a>
            @endif
              <a class="collapse-item" href="RegistrarCliente" onclick = "location = 'RegistrarCliente'">Registrar cliente</a>
            <a class="collapse-item active" href="ModificarCliente" onclick = "location = 'ModificarCliente'">Modificar cliente</a>
          <a class="collapse-item" href="ModificarSaldo" onclick = "location = 'ModificarSaldo'">Modificar saldo</a>
          </div>
        </div>
      </li>
    @include('layouts.prestamos')
    @include('layouts.logout')    
    @include('layouts.middleconfig1')
    
    @include('layouts.saldo')
    
    @include('layouts.middleconfig2')
     
      <div id="content">

        <div class="container-fluid">
              
@if(Session::has('cedularepetida'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('cedularepetida')}}</b>
 </div>
 @endif
 
    @if(Session::has('pdfrepetido'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('pdfrepetido')}}</b>
 </div>     
 @endif
 
    @if(Session::has('exito'))
 <div class="alert alert-success alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('exito')}}</b>
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
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Telefono</th>
                      <th>Dirección</th>
                      <th>Cedula</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                       <th>Identificación</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Telefono</th>
                      <th>Dirección</th>
                      <th>Cedula</th>
                    </tr>
                  </tfoot>
                  <tbody>
                      
                                 @foreach($clientes as $cliente)  
                                 
                                   <tr>
                                       <th scope="row"><a href="ModificarCliente{{$cliente->id}}">{{$cliente->identidad}}</a></th>
                      
                      <td>{{$cliente->primer_nombre}}</td>
                      <td>{{$cliente->primer_apellido}}</td>
                      <td>{{$cliente->telefono}}</td>
                      <td>{{$cliente->direccion}}</td>
                   
                    
                      <td><a href="PDFClientes/{{$cliente->pdf}}" target="_blank"><img src="images/eyes.png" style="width: 60px; height: 50px; margin-left: 10px;"></td>
                      
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

