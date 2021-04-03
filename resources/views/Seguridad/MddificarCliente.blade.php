@include('layouts.config1')
<title>Modificar Cliente</title>
@include('layouts.config2')    
    
  <li class="nav-item active">
        <a class="nav-link collapsed"  data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
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

          <!-- Page Heading -->
        
          <!-- DataTales Example -->
        
             <div class="col-lg-4" style="margin: 0 auto;">
            
         
              
        <form method="post" enctype="multipart/form-data" action="ModificarCliente{{$cliente->id}}"> {{csrf_field()}}                
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
                        <?php echo "Cedula"; ?> 
                     <input type="text"  class="form-control form-control-user" name ='identidad' value="{{$cliente->identidad}}">
                </div>
               <div class="form-group">
                        <?php echo "Nombres"; ?> 
                     <input type="text"  class="form-control form-control-user" name ='nombres' value="{{$cliente->primer_nombre}}">
                </div>
    
               <div class="form-group">
                        <?php echo "Apellidos"; ?> 
                     <input type="text"  class="form-control form-control-user" name ='apellidos' value="{{$cliente->primer_apellido}}">
                </div>
    
               <div class="form-group">
                        <?php echo "Telefono"; ?> 
                     <input type="text"  class="form-control form-control-user" name ='telefono' value="{{$cliente->telefono}}">
                </div>
    
               <div class="form-group">
                        <?php echo "Dirección"; ?> 
                     <input type="text"  class="form-control form-control-user" name ='direccion' value="{{$cliente->direccion}}">
                </div>
    
    <div class="form-group">
               
                    <input type="file"  name ='pdf' value="{{ Request::old('pdf') }}">
                  
                </div> 

                    <button class="btn btn-success btn-user btn-block"  type="submit">Modificar Cliente</button>
                    <button class="btn btn-secondary btn-user btn-block" href="ModificarCliente" onclick = "location = 'ModificarCliente'" type="button">Buscar Otro Cliente</button>
                    
                     
        
        </form> 
                 <br>
                
 
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
