<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductsRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //trae todos los registros
        $products = Product::all();

        return response()->json([
            "products" => $products
        ]);

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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
