<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            //"message" => "Hola Mundo"
            "categories" => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //VALIDAR DATOS
        $category=$request->validated();    
        $category['slug'] = $this->createSlug($category['name']);

        //GAURDAR EL REQUEST VALDIADO
        Category::create($category);


        //RETORNAR MENSAJE DE GAURDADO
        //
        return response()->json([
            //"request"=>$request->all()
           // "request"=>$request->name,
           //"request" => $request->description
           "message" => "La categoria fue registrada",
           "category"=>$category
           
        ],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $term)
    {
        //BUSQUEDA CON DOBLE CONDICION
        $category = Category::where('id',$term)
            ->orWhere('slug',$term)
            ->get();

        // VALIDAR DE QUEE XISTA LA CATEGORIA
        if(count($category)==0)
        {
            return response()->json([               
               "message" => "No se encontro la categoria",                              
            ],404);             
        }
        return response()->json([
            //"category" => $category
            "category" => $category[0]
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $category = Category::find($id);
        if(!$category)
        {
            return response()->json([
                "message"=>"No se encontro la categoria",
            ],404);
        }

        if($request['name'])
        {
            $request['slug']=$this->createSlug($request['name']);
        }
        
        $category ->update($request->all());

        return response()->json([          
           "message" => "La categoria fue registrada",
           "category"=>$category           
        ],201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = Category::find($id);
        if(!$category)
        {
            return response()->json([
                "message"=>"No se encontro la categoria",
            ],404);
        }

        $category->delete();

        return response()->json([          
            "message" => "La categoria fue eliminada",
            "category"=>$category           
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
