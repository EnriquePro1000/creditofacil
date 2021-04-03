@include('layouts.config1')
<title>Registrar Usuario</title>
@include('layouts.config2')  
      <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i> </i>
          <span>Seguridad</span>
        </a>
        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            
              @if (auth()->id() === 1)
              
              <a class="collapse-item active" href="RegistrarUsuario" onclick = "location = 'RegistrarUsuario'">Registrar usuario</a>
            @endif
            
            <a class="collapse-item" href="RegistrarCliente" onclick = "location = 'RegistrarCliente'">Registrar cliente</a>
            <a class="collapse-item" href="ModificarCliente" onclick = "location = 'ModificarCliente'">Modificar cliente</a>
            <a class="collapse-item" href="ModificarSaldo" onclick = "location = 'ModificarSaldo'">Modificar Saldo</a>
          </div>
        </div>
      </li>
    @include('layouts.prestamos')    
    @include('layouts.logout')   
    @include('layouts.middleconfig1')
    
       @include('layouts.saldo')
      
    @include('layouts.middleconfig2')
    
    
    
        <div class="col-lg-4" style="margin: 0 auto;">
               @if(Session::has('usuariocreado'))
 <div class="alert alert-success alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('usuariocreado')}}</b>
 </div>
     
 @endif
    
            <form class="form-horizontal" method="POST" action="RegistrarUsuario">   {{csrf_field()}}           
                 
                
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
            <input id="name" type="text" class="form-control" name="cedula"  value="{{ old('cedula') }}" placeholder="Cedula" required autofocus>

                              
                 </div>
        
        <div class="form-group">
            <input id="name" type="text" class="form-control" name="nombres" value="{{ old('nombres') }}" placeholder="Nombres" required autofocus>

                                
                 </div>
        
        <div class="form-group">
            <input id="name" type="text" class="form-control" name="apellidos" value="{{ old('apellidos') }}" placeholder="Apellidos" required autofocus>

                              
                 </div>
        
        <div class="form-group">
            <input id="name" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>

                               
                 </div>
        
       
                  
               
       
       
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                      <input id="password" type="password" class="form-control" name="password" required placeholder="Contraseña">

                               </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirmar contraseña"></div>
                </div>          
                  
                  <button class="btn btn-success btn-user btn-block" type="submit">registrar</button>
                  <button class="btn btn-secondary btn-user btn-block" type="reset">Limpiar</button>
                  
                <hr>
                
                </form>
            
        </div>
    
    @include('layouts.finalconfig')