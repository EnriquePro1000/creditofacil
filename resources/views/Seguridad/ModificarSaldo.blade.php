  @include('layouts.config1')
<title>Modificar Saldo</title>
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
            <a class="collapse-item" href="ModificarCliente" onclick = "location = 'ModificarCliente'">Modificar cliente</a>
            <a class="collapse-item active" href="ModificarSaldo" onclick = "location = 'ModificarSaldo'">Modificar saldo</a>
          </div>
        </div>
      </li>
    
        @include('layouts.prestamos') 
        
        
      
   
    @include('layouts.logout')   
    @include('layouts.middleconfig1')
    
    
         @include('layouts.saldo')
 
    
    @include('layouts.middleconfig2')
    
    
    <div class="col-lg-4" style="margin: 0 auto;">
        
         @if(Session::has('message-success'))
 <div class="alert alert-success alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('message-success')}}</b>
 </div> 
 @endif
        
        
   <form method="post" action="ModificarSaldo"> {{csrf_field()}}
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
                     
                      <?php echo "Cantidad (COP)"; ?>    
                     
                     <input type="text" class="form-control form-control-user" onkeyup="format(this)" onchange="format(this)" name='ingreso' value="{{ Request::old('ingreso') }}" placeholder="Ingreso agregado al saldo" required>
                </div>
                 <div class="form-group">
                     
                      <?php echo "Tipo de modificación"; ?>    
                     
                 <select name="tipo" class="form-control" id="inputSeccion_id">
                         
                        <option value ="true"> Agregar saldo</option>
                        <option value ="false">Restar saldo</option>
   
                    </select>  
                 </div>
                     
                     
           
    
    
       
       
       
       
       
     @if(Session::has('faltadinero'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('faltadinero')}}</b>
 </div> 
 @endif

                <div class="form-group">
                   
                </div>
       
                
       
                  
                  <button class="btn btn-success btn-user btn-block" data-toggle="modal" data-target="#ModificarModal" type="button">Modificar</button>
                  
                  
                  <div class="modal fade" id="ModificarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿Seguro?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Selecciona "Modificar" si estas seguro de querer hacer esta modificación del saldo</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          
          
          <button type="submit" class="btn btn-success">Modificar</button>
          
        </div>
      </div>
    </div>
  </div>
                  
                <hr>
                
                </form>
        
    </div>
    
    @include('layouts.finalconfig')