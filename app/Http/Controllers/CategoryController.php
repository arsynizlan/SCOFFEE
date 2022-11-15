<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        if ($category) {
            return successResponse(200, 'success', 'All Category', $category);
        }
        return errorResponse(404, 'error', 'Not Found');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'     => 'required',
            'image'     => 'required|image',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse(400, 'error', $validator->errors());
        }

        try {
            $extension = $request->file('image')->getClientOriginalExtension();
            $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
            $destination = base_path('public/images/category/');
            $request->file('image')->move($destination, $image);

            $category = Category::create([
                'name' => $request->name,
                'image' => $image
            ]);

            return successResponse(201, 'success', 'Berhasil Tambah Category', $category);
        } catch (Exception $e) {
            return errorResponse(400, 'error', $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = DB::table('categories')
            ->where('id', '=', $id)
            ->select('name', 'image')
            ->first();
        if ($category) {
            return successResponse(200, 'success', 'Tampil Category ' . $category->name, $category);
        }
        return errorResponse(404, 'error', 'Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        dd($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
