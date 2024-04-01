<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Product\ProductCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public static $wrap = "category";

    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $products = Category::find($this->id)->products;
        return [
            "id"            =>$this->id,
            "name"          =>$this->name,
            "slug"          =>$this->slug,
            "description"   =>$this->description,
            "products"      =>new ProductCollection($products),     
            //"products"      $products,     
            "createdAt"     =>$this->created_At,
            "updatedAt"     =>$this->updated_At,
        ];
    }
}
