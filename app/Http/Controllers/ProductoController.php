<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function index(){
        $productos = Producto::all();
        if($productos->isEmpty()){
            $data = [
                'message' => 'No se encontraron productos',
                'status' => '404'
            ];
            return response()->json($data,404);
        }else
            return response()->json($productos,200);
    }

    public function indexFilter(Request $request){
        $query = Producto::query();
        
        if ($request->has('nombre')) {
            $query->where('nombre', 'like', '%' . $request->input('nombre') . '%');
        }

        if ($request->has('categoria')) {
            $query->where('categoria', $request->input('categoria'));
        }

        if ($request->has('precio_min')) {
            $query->where('precio', '>=', $request->input('precio_min'));
        }

        if ($request->has('precio_max')) {
            $query->where('precio', '<=', $request->input('precio_max'));
        }

        $productos = $query->get();
    
        if ($productos->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron productos',
                'status' => 404
            ], 404);
        }
    
        return response()->json([
            'message' => $productos,
            'status' => 200
        ], 200);
    }
    

    public function show($id){
        $producto = Producto::find($id);
        if(!$producto){
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'message' => $producto,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'nombre' => 'required',
            'descripcion',
            'oferta' => 'required',
            'precio' => 'required',
            'precio_oferta'

        ]);
        if($validator->fails()){
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $productoExistente = Producto::where('nombre', $request->nombre)->first();

        if ($productoExistente) {
            return response()->json([
                'message' => 'Producto ya existente',
                'producto' => $productoExistente,
                'status' => 200
            ], 200);
        }

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'oferta' => $request->oferta,
            'precio' => $request->precio,
            'precio_oferta' => $request->precio_oferta

        ]);
        if(!$producto){
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $data = [
            'producto' => $producto,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function destroy($id){
        $producto = Producto::find($id);
        if(!$producto){
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $producto->delete();
        $data = [
            'message' => 'Producto eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function update(Request $request, $id){
        $producto = Producto::find($id);
        if(!$producto){
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(),[
            'nombre' => 'required',
            'descripcion',
            'oferta' => 'required',
            'precio' => 'required',
            'precio_oferta'

        ]);
        if($validator->fails()){
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->oferta = $request->oferta;
        $producto->precio = $request->precio;
        $producto->precio_oferta = $request->precio_oferta;

        $producto->save();

        $data = [
            'message' => 'Producto actualizado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id){
        $producto = Producto::find($id);
        if(!$producto){
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(),[
            'nombre',
            'descripcion',
            'oferta',
            'precio',
            'precio_oferta'
        ]);
        if($validator->fails()){
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if($request->has('nombre')){
            $producto->nombre = $request->nombre;
        }

        if($request->has('descripcion')){
            $producto->descripcion = $request->descripcion;
        }

        if($request->has('precio')){
            $producto->precio = $request->precio;
        }

        if($request->has('oferta')){
            $producto->oferta = $request->oferta;
        }

        $producto->save();

        $data = [
            'message' => 'Producto actualizado',
            'student' => $producto,
            'status' => 200
        ];

        return response()->json($data,200);
        
    }
}

