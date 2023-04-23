<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\ValidationCategory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $treeData = [];

       foreach ($categories as $item) {
            if(is_null($item->id_parent_category)) {
                    $object = new \stdClass();
                    $object->data['name'] = $item->title; // nombre del objeto
                    $object->data['id'] = $item->id; // nombre del objeto
                    $object->data['code'] = $item->code; // nombre del objeto
                    $object->data['desc'] = $item->description;
                    $object->children = []; // array vacío para los hijos

                    // Comprobar si el objeto tiene hijos
                    $childTest = Category::where('id_parent_category', $item->id)->get();
                    if (count($childTest)) {
                        foreach ($childTest as $child) {
                            $hijos = $this->children($child, $child->id);
                            if($hijos) $object->children[] = $hijos;
                        }

                }
                $treeData[] = $object;
            }

    }

        return response()->json([
            'data' => $treeData,
            'list' => $categories,
            'message' => 'Categorías obtenidas correctamente.',
        ]);
    }

    public function children($child1, $id){

        $childObject = new \stdClass();
            $childObject->data['name'] = $child1->title; // nombre del objeto
            $childObject->data['id'] = $child1->id; // nombre del objeto
            $childObject->children = []; // array vacío para los hijos

            $childTest = Category::where('id_parent_category', $id)->get();
            if (count($childTest)) {
                foreach ($childTest as $child) {
                    $hijos = $this->children($child, $child->id);
                    if($hijos) $childObject->children[] = $hijos;
                 }
            }

       return $childObject;

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ValidationCategory $request)
    {

            $peticion = $request->all();

            $category = Category::create($peticion);

            return response()->json([
                'data' => $category,
                'message' => 'Category saved successfully.'
            ], Response::HTTP_CREATED);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $Category = Category::findOrFail($id);

        return response()->json([
            'data' => $Category,
            'message' => 'Categoría obtenida correctamente.',
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $Category = Category::findOrFail($id);
        $Category->update($request->all());

        return response()->json([
            'data' => $Category,
            'message' => 'Categoría actualizada correctamente.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $Category = Category::findOrFail($id);
        $Category->delete();

        return response()->json([
            'message' => 'Categoría eliminada correctamente.',
        ]);
    }
}
