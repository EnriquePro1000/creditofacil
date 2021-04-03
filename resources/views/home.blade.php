@include('layouts.config1')
<title>Dashboard</title>
@include('layouts.config2')
    @include('layouts.seguridad')
    @include('layouts.prestamos')
    @include('layouts.logout')    
    @include('layouts.middleconfig1')
        @include('layouts.saldo')
    
    
     
    @include('layouts.middleconfig2')
    
     @if(Session::has('clientenocreado'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('clientenocreado')}}</b>
 </div>
 @endif
     @if(Session::has('usuarionoautorizado'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('usuarionoautorizado')}}</b>
 </div>
 @endif
 
     @if(Session::has('saldoerror'))
 <div class="alert alert-danger alert-dismissible" role="success">
 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</button>
   <b>{{Session::get('saldoerror')}}</b>
 </div>
 @endif
    
       <div class="row">
     <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Dinero Prestado</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($dinpres)." $" ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
     <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Dinero por Cobrar</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($dinrec)." $" ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
           <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Ganancias Totales</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($intgan)." $" ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
<!--     <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Dinero Liquidado</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($dinliq)." $" ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>-->
    
    <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Intereses por Cobrar</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($intporco)." $" ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    
    

    
          
            
             <!-- Pending Requests Card Example -->
          
       </div>
    
 
  <form method="post" enctype="multipart/form-data" action="home"> {{csrf_field()}}                
    
     <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Balance de Ganancias</h6>
                  <div class="dropdown no-arrow">
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                      
<div class="form-group row">
    <div class="col-sm-6 mb-3 mb-sm-0">
        <?php echo "desde:"?>
        <input type="date" class="form-control form-control-user" name='inicio' required value="{{$ayer}}" >
        </div>
    
    <div class="col-sm-6">
        <?php echo "hasta:"?>
        <input type="date" class="form-control form-control-user" name='fin' required value="{{ $hoy }}" >
    </div>
</div>
                      <div class="form-group">
                     <button class="btn btn-info btn-user btn-block" type="submit">consultar</button>
                  </div>
                      
 </form>
                      
<div class="form-group row">
    <div class="col-sm-6 mb-3 mb-sm-0">
        
        
        <?php echo "Dinero prestado"?>
        <input type="text" readonly="readonly" class="form-control form-control-user" name='dinpres2' value="{{number_format($dinpres2)}} COP" >
        </div>
    
    <div class="col-sm-6">
        <?php echo "Dinero recuperado"?>
        <input type="text" readonly="readonly" class="form-control form-control-user" name='dinrec2' value="{{number_format($dinrec2)}} COP" >
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-6 mb-3 mb-sm-0">
        <?php echo "Prestamos realizados"?>
        <input type="text" readonly="readonly" class="form-control form-control-user" name='presrea' value="{{$presrea}} prestamo(s)" >
        </div>
    
    <div class="col-sm-6">
        <?php echo "Ganancias en intereses"?>
        <input type="text" readonly="readonly" class="form-control form-control-user" name='ganancias' value="{{number_format($ganancias)}} COP" >
    </div>
</div>
                      
                      
                      
                      
                      
                      
          
                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
         <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Nuestro Logo</h6>
                  <div class="dropdown no-arrow">                    
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  
                    <img src="images/logo2.png" style="width: 300px; height: 320px; ">
       
                  
              </div>
          
                  
                  
                  
                  
               
              </div>
            </div>
          </div>
         
    @include('layouts.finalconfig')
    
    
    
    
    
    
    
    

  