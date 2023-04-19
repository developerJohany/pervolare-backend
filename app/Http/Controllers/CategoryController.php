<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $treeData = [];

       foreach ($categories as $item) {
            if(is_null($item->id_parent_category)) {
                    $object = new \stdClass();
                    $object->data['title'] = $item->title; // nombre del objeto
                    $object->data['size'] = $item->title; // nombre del objeto
                    $object->data['type'] = $item->title; // nombre del objeto
                    $object->children = []; // array vacío para los hijos

                    // Comprobar si el objeto tiene hijos
                    $childTest = Category::where('id_parent_category', $item->id)->get();
                    if (count($childTest)) {
                        foreach ($childTest as $child) {
                            $hijos = $this->children($child, $child->id);
                            if($hijos) $object->children[] = $hijos;
                        }
                    $treeData[] = $object;
                }
            }

    }


        return response()->json([
            'data' => $treeData,
            'message' => 'Categorías obtenidas correctamente.',
        ]);
    }

    public function children($child1, $id){

        $childObject = new \stdClass();

            $childObject->data['title'] = $child1->title; // nombre del objeto
            $childObject->data['size'] = $child1->title; // nombre del objeto
            $childObject->data['type'] = $child1->title; // nombre del objeto
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
    public function store(Request $request)
    {
        $category = Category::create($request->all());

        return response()->json([
            'data' => $category,
            'message' => 'Categoría creada correctamente.',
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
