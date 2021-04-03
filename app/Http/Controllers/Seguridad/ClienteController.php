<?php

namespace App\Http\Controllers\Seguridad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Seguridad\Cliente;
use Session;


class ClienteController extends Controller
{
     public function __construct() {
        $this->middleware('auth');
    }
    
     
    
    
      
    public function create(Request $request) { 

         $this->validate($request, ['identidad' => 'max:20']);
         $this->validate($request, ['nombres' => 'required|string']);
         $this->validate($request, ['apellidos' => 'required|string']);
         $this->validate($request, ['direccion' => 'required|string']);
         $this->validate($request, ['telefono' => 'required|string']);
         $this->validate($request, ['pdf' => 'mimes:pdf|max:5120']);   

        $cliente['identidad'] = $request->cedula;         
        $cliente['primer_nombre'] = $request->nombres;
        $cliente['primer_apellido'] = $request->apellidos;
        $cliente['direccion'] = $request->direccion;
        $cliente['telefono'] = $request->telefono;
        
        if($request->hasFile("pdf")){
            $coincidencia1 = Cliente::where("identidad",$request->cedula)->count();
        
        $pdf1 = $request->file('pdf');
        $nombre1 = $pdf1->getClientOriginalName();
        
         $coincidencia2 = Cliente::where("pdf",$nombre1)->count();
        
        
        if($coincidencia1 === 0 && $coincidencia2===0){
            if ($pdf = $request->file('pdf')) {
            $nombre = $pdf->getClientOriginalName();
            $pdf->move('PDFClientes', $nombre);         

        }

  
        $cliente['pdf'] = $nombre;
        $cliente['prestamoactivo'] = false;          
        $cliente['usuario_id'] = auth()->id();          
        Cliente::create($cliente);
        
        $clientes = Cliente::all();
        Session::flash('message-success','El cliente fue registrado correctamente');
          return view("Seguridad.RegistrarCliente", compact("clientes"));
            
        }else{
             Session::flash('clientenocreado','No pudo registrar el cliente, cedula y/o pdf repetido');
            return redirect("home");
        }     
            
        }else{
            
            $coincidencia1 = Cliente::where("identidad",$request->cedula)->count();
        if($coincidencia1 === 0){

  
        $cliente['pdf'] = "NoFound.jpg";
        $cliente['prestamoactivo'] = false;          
        $cliente['usuario_id'] = auth()->id();          
        Cliente::create($cliente);
        
        $clientes = Cliente::all();
        Session::flash('message-success','El cliente fue registrado correctamente');
          return view("Seguridad.RegistrarCliente", compact("clientes"));
            
        }else{
             Session::flash('clientenocreado','No pudo registrar el cliente, cedula y/o pdf repetido');
            return redirect("home");
        }     
            
            
            
            
        }
        
            
    }
 
    public function RegistrarCliente() {
        return view('Seguridad/RegistrarCliente');
    }
    
       public function ModificarClientes($id) { 
           
           $cliente = Cliente::findOrFail($id);
        return view("Seguridad/MddificarCliente", compact("cliente"));
    }
       public function ModificarClient(Request $request, $id) { 
       
          $this->validate($request, ['identidad' => 'max:20']);
         $this->validate($request, ['nombres' => 'string']);
         $this->validate($request, ['apellidos' => 'string']);
         $this->validate($request, ['direccion' => 'string']);
         $this->validate($request, ['telefono' => 'string']);
         $this->validate($request, ['pdf' => 'mimes:pdf|max:5120']);
         
         $cliente = Cliente::findOrFail($id);
         
          $coincidencia1 = Cliente::where("identidad",$request->identidad)->count();
              if($coincidencia1 > 0){
                  echo $coincidencia1;
                     if($request->identidad === $cliente["identidad"]){
                         $new["identidad"] = $request->identidad;
                     }
                     if($request->identidad !== $cliente["identidad"]){
                         Session::flash('cedularepetida','Un usuario con esa cedula ya existe');
                         return redirect("ModificarCliente");
                     }
                     }else{
                         $new["identidad"] = $request->identidad;
                     }
             
             $new["primer_nombre"]   = $request->nombres;
             $new["primer_apellido"] = $request->apellidos;
             $new["direccion"]       = $request->direccion;
             $new["telefono"]        = $request->telefono;
             
             if($request->pdf === null){
                  $cliente->update($new);
                  Session::flash('exito','El usuario ha sido actualizado');
                  return redirect("ModificarCliente");
             }else{
                 $pdf1 = $request->file('pdf');
                 $nombre1 = $pdf1->getClientOriginalName();
                 $coincidencia2 = Cliente::where("pdf",$nombre1)->count();
                 
                 if($cliente["pdf"] === "NoFound.jpg"){
                     
                     $pdf1->move('PDFClientes', $nombre1);
                          $new["pdf"] = $nombre1;
                          $cliente->update($new);
                          Session::flash('exito','El usuario ha sido actualizado');
                          return redirect("ModificarCliente");                         
                     
                     
  
                 }else{
                     if($coincidencia2 > 0){
                     if($nombre1 === $cliente["pdf"]){
                         $oldpdf = public_path().'/PDFClientes/'.$cliente["pdf"];
                         unlink($oldpdf);
                         
                         $pdf1->move('PDFClientes', $nombre1);
                          $new["pdf"] = $nombre1;
                          $cliente->update($new);
                          Session::flash('exito','El usuario ha sido actualizado');
                          return redirect("ModificarCliente");                         
                     }else{
                         Session::flash('pdfrepetido','Un usuario ya tiene un archivo con este nombre');
                          return redirect("ModificarCliente");
                     }
                 }else{
                     $oldpdf = public_path().'/PDFClientes/'.$cliente["pdf"];
                         unlink($oldpdf);
                     $pdf1->move('PDFClientes', $nombre1);
                          $new["pdf"] = $nombre1;
                          $cliente->update($new);
                          Session::flash('exito','El usuario ha sido actualizado');
                          return redirect("ModificarCliente");   
                     
                 }
                 }
                 
                 
             }          
}
    
    
    public function ObtenerClientes() {         
        
       $clientes = Cliente::all()->where("usuario_id", auth()->id());
        return view("Seguridad.ModdificarCliente", compact("clientes"));
    }
  
}
