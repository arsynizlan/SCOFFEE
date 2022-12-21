<?php

namespace App\Http\Controllers\WEB;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
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
        $data = [
            'script' => 'components.scripts.categories'
        ];
        return view('pages.categories.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'unique:categories',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $json = [
                'msg'       => 'Nama kategori sudah digunakan!',
                'status'    => false
            ];
            return Response::json($json);
        } elseif ($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon berikan nama kategori',
                'status'    => false
            ];
        } elseif ($request->image == NULL) {
            $json = [
                'msg'       => 'Mohon berikan gambar',
                'status'    => false
            ];
        } else {
            try {
                DB::transaction(function () use ($request) {
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
                    $destination = base_path('public/images/category/');
                    $request->file('image')->move($destination, $image);

                    Category::create([
                        'name' => $request->name,
                        'image' => $image,
                    ]);
                });

                $json = [
                    'msg' => 'Kategori berhasil ditambahkan',
                    'status' => true
                ];
            } catch (Exception $e) {
                $json = [
                    'msg'       => 'Error',
                    'status'    => false,
                    'e'         => $e
                ];
            }
        }
        return Response::json($json);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (is_numeric($id)) {
            $data = Category::where('id', $id)
                ->first();
            return Response::json($data);
        }
        $data = Category::orderBy('id', 'desc')
            ->get();
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                return '<image class="img-thumbnail" src="' . asset('images/category/' . $row->image) . '">';
            })
            ->addColumn('action', function ($row) {
                $data = [
                    'id' => $row->id
                ];

                return view('components.buttons.categories', $data);
            })
            ->rawColumns(['action', 'image'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => ['required', Rule::unique('categories', 'name')->ignore($id)],


        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $json = [
                'msg'       => 'Nama kategori sudah digunakan!',
                'status'    => false
            ];
            return Response::json($json);
        } elseif ($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon berikan nama kategori',
                'status'    => false
            ];
        } else {
            try {
                DB::transaction(function () use ($request, $id) {
                    DB::table('categories')->where('id', $id)->update([
                        'name' => $request->name,
                    ]);

                    if ($request->has('image')) {
                        $category = Category::find($id);
                        $oldImage = $category->image;

                        if ($oldImage) {
                            $pleaseRemove = base_path('public/images/category/') . $oldImage;

                            if (file_exists($pleaseRemove)) {
                                unlink($pleaseRemove);
                            }
                        }

                        $extension = $request->file('image')->getClientOriginalExtension();
                        $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
                        $destination = base_path('public/images/category/');
                        $request->file('image')->move($destination, $image);

                        Category::where('id', $id)->update([
                            'image' => $image,
                        ]);
                    };
                });

                $json = [
                    'msg' => 'Kategori berhasil disunting',
                    'status' => true
                ];
            } catch (Exception $e) {
                $json = [
                    'msg'       => 'Error',
                    'status'    => false,
                    'e'         => $e
                ];
            }
        }
        return Response::json($json);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Category::find($id);
            if (!$data) {
                $json = [
                    'msg' => 'Data Tidak Ditemukan',
                    'status' => false,
                ];
            }
            $oldImage = $data->image;
            if ($oldImage) {
                $pleaseRemove = base_path('public/images/category/') . $oldImage;

                if (file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }
            }

            DB::transaction(function () use ($id) {
                DB::table('categories')->where('id', $id)->delete();
            });

            $json = [
                'msg' => 'Category berhasil dihapus',
                'status' => true
            ];
        } catch (Exception $e) {
            $json = [
                'msg' => 'error',
                'status' => false,
                'e' => $e,
            ];
        };

        return Response::json($json);
    }
}