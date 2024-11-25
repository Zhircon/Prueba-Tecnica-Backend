<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductType;

class ProductController extends Controller
{
    public function all(){
        $data = [
            'message' => [],
            'status' =>'200',
            'products' => [],
        ];
        $products = Product::all()->load('productType');
        $data['products'] =$products;
        return response()->json($data,$data['status']);
    }
    public function show($product_id){
        $data = [
            'message' => [],
            'status' =>'200',
            'product' =>[]
        ];
        $product = Product::find($product_id);
        if($product==null){
            $data['status'] = 400;
            array_push($data['message'], 'No se encontro un producto registrado con ese id');
        }
        $data['product'] = $product;
        return response()->json($data,$data['status']);
    }
    public function store(Request $request){
        $data = [
            'message' => [],
            'status' =>'200',
            'errors' => [],
            'product' =>[]
        ];
        $validator = Validator::make($request->all(),
            ['name' => 'required'
        ]);
        if($validator->fails()){
            array_push($data['message'], "Errores de validacion");
            $data['errors']= $validator->errors();
            $data['status'] = 400;
            return response()->json($data,$data['status']);
        }
        $product = Product::create([
            'name' => $request->name
        ]);
        if($product==null){
            $data['status'] = 500;
            array_push($data['message'], 'Error al guardar en la base de datos');
        }
        $this->associate($product->id,$request->product_type_id);
        $data['product'] = $product;
        return response()->json($data,$data['status']);
    }
    public function update(Request $request){
        $data = [
            'message' => [],
            'status' =>'200',
            'errors' => [],
            'product' =>[]
        ];
        $validator = Validator::make($request->all(),
        [
            'name'=> 'required']
        );
        if($validator->fails()){
            array_push($data['message'], "Errores de validacion");
            $data['errors']= $validator->errors();
            $data['status'] = 400;
            return response()->json($data,$data['status']);
        }
        $product = Product::find($request->id);
        if($product!=null){
            $product->name=$request->name;
            $productType = ProductType::find($request->product_type_id);
            $this->associate($product->id,$request->product_type_id);
            $product->product_type_id = $productType !=null ? $productType->id :null;
            $product->save(); 
            $data['product'] = $product;
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
            'product' =>[]
        ];
        $product = Product::find($id);
        if ($product !=null) {
            $product->delete();
        } else{
            array_push($data,'No se encontro un producto con ese id');
            $data['status'] = 400;
        }
        return response()->json($data,$data['status']);
    }
    private function associate($product_id,$product_type_id){
        $product = Product::find($product_id);
        $productType = ProductType::find($product_type_id);
        $product->productType()->associate($productType);
        $product->save();
    }
}
