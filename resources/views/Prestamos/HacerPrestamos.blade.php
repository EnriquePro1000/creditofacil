@include('layouts.config1')
<title>Hacer Prestamo</title>
@include('layouts.config2')
    
        @include('layouts.seguridad') 
        
         <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i> </i>
          <span>Prestamos</span>
        </a>
        <div id="collapseUtilities" class="collapse show" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item active" href="HacerPrestamo" onclick = "location = 'HacerPrestamo'" href="utilities-color.html">Hacer Prestamo</a>
            <a class="collapse-item" href="EditarPrestamo" onclick = "location = 'EditarPrestamo'" href="utilities-color.html">Editar Prestamo</a>
            <a class="collapse-item" href="RegistrarPago" onclick = "location = 'RegistrarPago'" href="utilities-border.html">Registrar Pago</a>            
          <a class="collapse-item" href="HistorialPago" onclick = "location = 'HistorialPago'" href="utilities-border.html">Historial de Pago</a>
          </div>
        </div>
      </li>
      
   
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
         @if(Session::has('message-successs'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('message-successs')}}</b>
 </div> 
 @endif
 @if(Session::has('sobrecupos'))
 <div class="alert alert-danger alert-dismissible" role="alert">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session('sobrecupos')}}</b>
 </div> 
 @endif
        
        
   <form method="post" action="HacerPrestamo"> {{csrf_field()}}
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
                     
                     <?php echo "Identificaci??n"; ?>                     
                     
                   <select name="cliente" class="form-control" id="inputSeccion_id">
                           @foreach ($clientes as $cliente)
                        <option value ="{{$cliente['id']}}">{{$cliente['primer_nombre']}} {{$cliente['primer_apellido']}} ({{$cliente['identidad']}})</option>
                        @endforeach
                     
                         
                    </select>    
                 
                 </div>
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
                 <div class="form-group">
                     
                      <?php echo "Cantidad solicitada en prestamo (COP)"; ?>    
                     
                     <input type="text" class="form-control form-control-user" onkeyup="format(this)" onchange="format(this)" name='monto' value="{{ Request::old('monto') }}" placeholder="Monto prestado">
                </div>
    
    <div class="form-group">
                      
                      <?php echo "Intereses (%)"; ?> 
                    <input type="number" class="form-control form-control-user" name='intereses' value="{{ Request::old('intereses') }}" placeholder="10">
              
                  </div>
    
    <div class="form-group">
                      
                      <?php echo "Fecha del prestamo"; ?> 
        <input type="date" class="form-control form-control-user" name='fechaprestamo' id="dt" value="{{ Request::old('fechaprestamo') }}" >    
                  </div>
               <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
             
                  </div>     
                <div class="col-sm-6 mb-3 mb-sm-0">

                  </div>
                </div> 

     @if(Session::has('faltadinero'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('faltadinero')}}</b>
 </div> 
 @endif
  
                <div class="form-group">
                   
                </div>
       
                
       
                  
 <button class="btn btn-success btn-user btn-block" data-toggle="modal" data-target="#RegisterModal" type="button">registrar</button>
                  <button class="btn btn-secondary btn-user btn-block" type="reset">Limpiar</button>
                  
                  <div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">??Seguro?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">??</span>
          </button>
        </div>
        <div class="modal-body">Selecciona "Registrar" si estas seguro de querer registrar este nuevo prestamo</div>
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