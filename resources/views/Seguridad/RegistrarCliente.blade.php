@include('layouts.config1')
<title>Registrar Cliente</title>
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
              <a class="collapse-item active" href="RegistrarCliente" onclick = "location = 'RegistrarCliente'">Registrar cliente</a>
            <a class="collapse-item" href="ModificarCliente" onclick = "location = 'ModificarCliente'">Modificar cliente</a>
         <a class="collapse-item" href="ModificarSaldo" onclick = "location = 'ModificarSaldo'">Modificar saldo</a>
          
          </div>
        </div>
      </li>
      
    @include('layouts.prestamos')    
    @include('layouts.logout')   
    @include('layouts.middleconfig1')
    
       @include('layouts.saldo')
       
    @include('layouts.middleconfig2')
    
    
        <div class="col-lg-4" style="margin: 0 auto;">
            
          @if(count($errors)>0)
    <div class="alert alert-danger">
        <ul>
    @foreach($errors->all() as $error)
     <?php echo "corrige los siguientes errores: "?><li>{{$error}}</li>
    @endforeach
        </ul>
    </div>
    @endif
    
      @if(Session::has('message-success'))
 <div class="alert alert-success alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('message-success')}}</b>
 </div>
     
 @endif
    
            <form method="post" enctype="multipart/form-data" action="RegistrarCliente"> {{csrf_field()}}                
                 <div class="form-group">
                     <input type="text" class="form-control form-control-user" name ='cedula' placeholder="Cedula" value="{{ Request::old('cedula') }}">
                </div>
                 
                  
                 <div class="form-group">
                     <input type="text" class="form-control form-control-user" name='nombres' placeholder="Nombres" value="{{ Request::old('nombres') }}">
                </div>
 
       
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" name='apellidos' placeholder="Apellidos" value="{{ Request::old('apellidos') }}">
                </div>
           
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" name ='direccion' placeholder="Dirección" value="{{ Request::old('direccion') }}">
                </div>
                
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" name ='telefono' placeholder="Telefono" value="{{ Request::old('telefono') }}">
                </div>
       
                <div class="form-group">
               
                    <input type="file"  name ='pdf' value="{{ Request::old('pdf') }}">
                  
                </div>          
                <button class="btn btn-success btn-user btn-block" data-toggle="modal" data-target="#RegisterModal" type="button">Registrar</a>               
                  <button class="btn btn-secondary btn-user btn-block" href="RegistrarCliente" onclick = "location = 'RegistrarCliente'" type="button">Limpiar</button>
                  
                  
                              <div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿Seguro?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Selecciona "Registrar" si estas seguro de querer registrar este nuevo cliente</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          
          
          <button type="submit" class="btn btn-success">Registrar</button>
          
        </div>
      </div>
    </div>
  </div>
                  
                <hr>
                
                </form>
            
        </div>
    
    @include('layouts.finalconfig')