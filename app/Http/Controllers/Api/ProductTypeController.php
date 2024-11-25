<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Support\Facades\Validator;

class ProductTypeController extends Controller
{
    public function index(){
        $data = [
            'message' => [],
            'status' =>'200',
            'productTypes' => [],
        ];
        $productTypes = ProductType::all();
        $data['productTypes'] =$productTypes;
        return response()->json($data,$data['status']);
    }
    public function show($productType_id){
        $data = [
            'message' => [],
            'status' =>'200',
            'productType' =>[]
        ];
        $productType = ProductType::find($productType_id);
        if($productType==null){
            $data['status'] = 400;
            array_push($data['message'], 'No se encontro un producto registrado con ese id');
        }
        $data['productType'] = $productType;
        return response()->json($data,$data['status']);
    }
    public function store(Request $request){
        $data = [
            'message' => [],
            'status' =>'200',
            'errors' => [],
            'products' =>[]
        ];
        $validator = Validator::make($request->all(),
            ['description' => 'required'
        ]);
        if($validator->fails()){
            array_push($data['message'], "Errores de validacion");
            $data['errors']= $validator->errors();
            $data['status'] = 400;
            return response()->json($data,$data['status']);
        }
        $productType = ProductType::create([
            'description' => $request->description
        ]);
        if($productType==null){
            $data['status'] = 500;
            array_push($data['message'], 'Error al guardar en la base de datos');
        }
        $data['productType'] = $productType;
        return response()->json($data,$data['status']);
    }
    public function update(Request $request){
        $data = [
            'message' => [],
            'status' =>'200',
            'errors' => [],
            'productType' =>[]
        ];
        $validator = Validator::make($request->all(),
        [
            'description'=> 'required']
        );
        if($validator->fails()){
            array_push($data['message'], "Errores de validacion");
            $data['errors']= $validator->errors();
            $data['status'] = 400;
            return response()->json($data,$data['status']);
        }
        $productType = ProductType::find($request->id);
        if($productType!=null){
            $productType->description=$request->description;
            $productType->save();
            $data['productType'] =$productType;

        }else{
            $data['status'] = 500;
            array_push($data['message'], 'No se encontro ningun producto con ese id');
        }
        return response()->json($data,$data['status']);
    }
    public function delete($id){
        $data = [
            'message' => [],
            'status' =>'200',
            'errors' => [],
            'productType' =>[]
        ];
        $productType = ProductType::find($id);
        if ($productType !=null) {
            $productType->delete();
        } else{
            array_push($data,'No se encontro un tipo de producto con ese id');
            $data['status'] = 400;
        }
        return response()->json($data,$data['status']);
    }
}
