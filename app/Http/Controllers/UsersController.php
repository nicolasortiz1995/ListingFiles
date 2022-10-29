<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dato = User::all();
        return view('users', compact('dato'));
    }

    public function create()
    {
        //
        return view('users.insert');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'password'  => 'required|min:4',
            'repeatPassword'  => 'required|same:password'
        ],[
            'name.required' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.email' => 'Formato de email no valido', 
            'email.unique' => 'El email ya está registrado',
            'password.required' => 'La contraseña es requerido',
            'password.min' => 'La contraseña debe ser mayor a 4 caracteres',
            'repeatPassword.required' => 'Repetir contraseña es requerido',
            'repeatPassword.same' => 'Las contraseñan no son iguales',
        ]);

        $users = new User();
        $users->name = $request->post('name');
        $users->email = $request->post('email');
        $users->password = $request->post('password');
        $users->rol = $request->post('rol');
        $users->save();

        return redirect()->route("users")->with('success','Guardado con exito');
    }
   
    public function show($id)
    {
        //
        $users = User::find($id);
        return view('users.delete', compact('users'));
    }
    
    public function edit($id)
    {
        //
        $users = User::find($id);
        return view('users.update', compact('users'));
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required'
        ],[
            'name.required' => 'El nombre es requerido'
        ]);
        
        $users = User::find($id);
        $users->name = $request->post('name');
        //$users->email = $request->post('email');

        if(!empty($request->post('password')) && !empty($request->post('repeatPassword')) ){

            $request->validate([
                'password'  => 'required|min:4',
                'repeatPassword'  => 'required|same:password'
            ],[
                'password.required' => 'La contraseña es requerido',
                'password.min' => 'La contraseña debe ser mayor a 4 caracteres',
                'repeatPassword.required' => 'Repetir contraseña es requerido',
                'repeatPassword.same' => 'Las contraseñan no son iguales',
            ]);

            $users->password = bcrypt($request->post('password'));
        }

        $users->rol = $request->post('rol');
        $users->save();

        return redirect()->route("users")->with('success','Editado con exito');
    }
  
    public function destroy($id)
    {
        //
        $users = User::find($id);
        $users->delete();
        return redirect()->route("users")->with('success','Eliminado con exito');
    }

    public function orderByFiles($list_files = array()){  
        
        $arrayDir = array();

        for ($i=0; $i <count($list_files) ; $i++) { 
            if(!empty($list_files[$i]['extension'])){
                if ($list_files[$i]['extension'] == 'dir') {
                    array_push($arrayDir,$list_files[$i]);
                }
            }
        }
        for ($i=0; $i <count($list_files) ; $i++) { 
            if(!empty($list_files[$i]['extension'])){
                if ($list_files[$i]['extension'] != 'dir') {
                    array_push($arrayDir,$list_files[$i]);
                }
            }else{
                array_push($arrayDir,$list_files[$i]);
            }
        }

        return $arrayDir;
    }

    public function breadcrumbFiles($dirBreadcrumb = ''){  
        
        $breadcrumb = array();
        $data = explode('/', $dirBreadcrumb);
        $ruta ='';

        for ($i=0; $i <count($data) ; $i++) { 
            $item = $data[$i];
            if($item != ''){
                if($i == 0){
                    $ruta .= '';
                }elseif($i == 1){
                    $ruta .= $item;
                }else{
                    $ruta .= '/'.$item;
                }

                array_push($breadcrumb,array(
                    'ruta' =>  $ruta,
                    'item' =>  $item
                ));
            }

        }

        return $breadcrumb;        
    }


    public function loadingFiles(Request $request)
    {

        $list_files=array();
        $objDatos=array();
        $dir = __DIR__."/../../../public/documentos/";
        $dirBreadcrumb = "documentos/";
        
        $rutafolder='';
        if(!empty($request->datos['dir'])){
            $rutafolder = $request->datos['dir'].'/';
            $dir = $dir.$rutafolder;
            $dirBreadcrumb = $dirBreadcrumb.$rutafolder;
        }

        // Abre un directorio conocido, y procede a leer el contenido
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                  $rutaFile=$dir.$file;
                  //if(is_file($rutaFile)){  
                  if($file !== "." && $file !== ".."){  
                     $list_files[]= $this->infoFile($rutaFile,$rutafolder.$file);
                  }
                }
                closedir($dh);
            }
        }  

        $objDatos = $this->orderByFiles($list_files);
        $breadcrumb = $this->breadcrumbFiles($dirBreadcrumb);

        return array('succes'=>true,'data'=>$objDatos,'breadcrumb'=> $breadcrumb);
    }

    public function searchFiles(Request $request)
    {
        
        $dirName = "documentos/";
        $buscar = '';
        $list_files = [];

        if(!empty($request->datos['buscar'])){
            $buscar = $request->datos['buscar'];
        }

        if($buscar !=''){
            $files = $this->getDirFiles();

            for ($i=0; $i < count($files) ; $i++) { 
                if(is_file($dirName.$files[$i])){ 
                   if(strstr(strtolower($files[$i]),strtolower($buscar)))
                        $list_files[] = $this->infoFile($dirName.$files[$i],$files[$i]);
                }
            }
        }

        return $list_files;
    }

    public function getDirFiles($dirName = null){

        if(empty($dirName)){
           //$dirName = __DIR__."/../../../public/documentos";
            $dirName = "documentos";
        } 

        $result = []; 
        if (file_exists($dirName)) {
            $d = scandir($dirName);
            foreach($d as $file) {
                if (is_dir("$dirName/$file") && $file !== "." && $file !== "..") {
                   $b = scandir("$dirName/$file");
                   foreach($b as $f2) {
                       if (is_file("$dirName/$file/$f2")) {
                           array_push($result, "$file/$f2");
                       } elseif (is_dir("$dirName/$file/$f2")) {
                           if ($f2 !== "." && $f2 !== "..") {
                               $f3 = $this->getDirFiles("$dirName/$file/$f2"); 
                               foreach($f3 as $f4) {
                                    array_push($result, "$file/$f2/$f4");
                               }
                           }
                       }
                   }
                } else {
                    if ($file !== "." && $file !== "..") {
                        array_push($result, "$file");
                    }
                }
            }
            
            return $result;
        } else {
            return "Directorio no existe";
        }
    }

    public function uploadfiles(Request $request)
    {   

        $file = $request->file('inputFile');
        $dirFile = $request->input('dirFile');
 
        $filename = $file->getClientOriginalName();

        // File extension
        $extension = $file->getClientOriginalExtension();

        // File upload location 
        $location = __DIR__."/../../../public/$dirFile/";

        // Upload file
        $file->move($location,$filename);
        
        // File path
        $filepath = url('documentos/'.$filename);

        // Response
        $data['success'] = 1;
        $data['message'] = 'Uploaded Successfully!';
        $data['filepath'] = $filepath;
        $data['extension'] = $extension;

        return array('succes'=>true,'data'=> $data);
    }

    public function deletefiles(Request $request){        

        $rutafile = $request->datos['rutafile'];
        $basename = $request->datos['basename'];

        // File upload location 
        $location = __DIR__."/../../../public/";

        if(is_file($location.$rutafile)){

            // Borro el archivo
            unlink($location.$rutafile);

            return array("success"=>true,"data"=> 'Su archivo ha sido eliminado.');  
        }
        
        return array("success"=>false,"data"=> 'No se pudo eliminar el archivo.');  
    }

    public function infoFile($rutaFile,$file)
    {
        $partes_ruta = pathinfo($rutaFile);
        $partes_ruta['ruta'] = 'documentos/'.$file;
        $partes_ruta['rutaView'] = $file;
        $partes_ruta['dirname'] = '';

        if(is_dir($rutaFile)){
            $partes_ruta['is_dir'] = true;
            $partes_ruta['rutaDir'] = $file;
            $partes_ruta['extension'] = 'dir';
        }else{
            $partes_ruta['is_dir'] = false;
            $partes_ruta['rutaDir'] = '';
            //$partes_ruta['extension'] = '';
        }

        return $partes_ruta;
    }
    
    public function listDirFiles(Request $request){
        
        $result = [];
        $resultFinal = [];

        $result = $this->listDirFilesUpload();

        array_push($resultFinal, "documentos");
        for ($i=0; $i < count($result) ; $i++) { 
            array_push($resultFinal, "documentos/".$result[$i]);
        }
        return $resultFinal;

    }

    public function listDirFilesUpload($dirName = null){

        if(empty($dirName)){
           //$dirName = __DIR__."/../../../public/documentos";
            $dirName = "documentos";
        } 

        $result = []; 
         if (file_exists($dirName)) {
            $d = scandir($dirName);
            foreach($d as $file) {
                if (is_dir("$dirName/$file") && $file !== "." && $file !== "..") {
                    array_push($result, "$file");
                   $b = scandir("$dirName/$file");
                   foreach($b as $f2) {
                       if (is_file("$dirName/$file/$f2")) {
                          // array_push($result, "$file/$f2");
                       } elseif (is_dir("$dirName/$file/$f2")) {
                           if ($f2 !== "." && $f2 !== "..") {
                                array_push($result, "$file/$f2");
                               $f3 = $this->listDirFilesUpload("$dirName/$file/$f2"); 
                               foreach($f3 as $f4) {
                                    array_push($result, "$file/$f2/$f4");
                               }
                           }
                       }
                   }
                }  
            }
            
            return $result;
        } else {
            return "Directorio no existe";
        }
    }
}

