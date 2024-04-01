<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Requests\Products\StoreProductsRequest;
use App\Http\Resources\Product\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //trae todos los registros
        // $products = Product::all();

        // return response()->json([
        //     "products" => $products
        // ]);
        return new ProductCollection( Product::all() );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request)
    {
     
        //Crear
        
        $product = $request->validated();
        $product['slug'] = $this->createSlug($product['name']);

        $product = Product::create($product);

        return response() -> json([
            "message" => "Se guardo el producto", 
            "product" => $product
        ],201);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $term)
    {
        //
        //BUSQUEDA CON DOBLE CONDICION
        $product = Product::where('id',$term)
            ->orWhere('slug',$term)
            ->get();

        // VALIDAR DE QUEE XISTA LA CATEGORIA
        if(count($product)==0)
        {
            return response()->json([               
               "message" => "No se encontro el product",                              
            ],404);             
        }
        return new ProductResource($product[0]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $product = Product::find($id);
        if(!$product)
        {
            return response()->json([
                "message"=>"No se encontro el producto",
            ],404);
        }

        if($request['name'])
        {
            $request['slug']=$this->createSlug($request['name']);
        }
        
        $product ->update($request->all());

        return response()->json([          
           "message" => "El producto fue actualizado",
           "product"=>new ProductResource($product)
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $product = Product::find($id);
        if(!$product)
        {
            return response()->json([
                "message"=>"No se encontro el producto",
            ],404);
        }

        $product->delete();

        return response()->json([          
            "message" => "El Producto fue eliminado",
            "product"=> new ProductResource($product),          
         ],200);
    }

    private function createSlug($text)
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/','-',$text);
        $text = trim($text,'-');
        $text = preg_replace('/-+/','-',$text);
        return $text;
    }
}
