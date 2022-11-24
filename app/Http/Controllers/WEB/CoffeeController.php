<?php

namespace App\Http\Controllers\WEB;

use Exception;
use App\Models\Coffee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CoffeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'script' => 'components.scripts.coffee'
        ];
        return view('pages.coffee.index', $data);
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
            'name' => 'unique:coffees',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $json = [
                'msg'       => 'Nama Kopi sudah digunakan!',
                'status'    => false
            ];
            return Response::json($json);
        } elseif ($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon berikan nama kopi',
                'status'    => false
            ];
        } elseif ($request->origin == NULL) {
            $json = [
                'msg'       => 'Mohon berikan asal kopi',
                'status'    => false
            ];
        } elseif ($request->image == NULL) {
            $json = [
                'msg'       => 'Mohon berikan gambar',
                'status'    => false
            ];
        } elseif ($request->description == NULL) {
            $json = [
                'msg'       => 'Mohon berikan deskripsi',
                'status'    => false
            ];
        } else {
            try {
                DB::transaction(function () use ($request) {
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
                    $destination = base_path('public/images/coffee/');
                    $request->file('image')->move($destination, $image);

                    Coffee::create([
                        'name' => $request->name,
                        'slug' => Str::slug($request->name),
                        'origin' => $request->origin,
                        'type' => $request->type,
                        'description' => $request->description,
                        'image' => $image,
                    ]);
                });

                $json = [
                    'msg' => 'Kopi berhasil ditambahkan',
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
            $data = Coffee::where('id', $id)
                ->first();
            return Response::json($data);
        }
        $data = Coffee::orderBy('id', 'desc')
            ->get();
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                return '<image class="img-thumbnail" src="' . asset('images/coffee/' . $row->image) . '">';
            })
            ->addColumn('action', function ($row) {
                $data = [
                    'id' => $row->id
                ];

                return view('components.buttons.coffees', $data);
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
            'name' => 'unique:coffees',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $json = [
                'msg'       => 'Nama Kopi sudah digunakan!',
                'status'    => false
            ];
            return Response::json($json);
        } elseif ($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon berikan nama kopi',
                'status'    => false
            ];
        } elseif ($request->origin == NULL) {
            $json = [
                'msg'       => 'Mohon berikan asal kopi',
                'status'    => false
            ];
        } elseif ($request->description == NULL) {
            $json = [
                'msg'       => 'Mohon berikan deskripsi',
                'status'    => false
            ];
        } else {
            try {
                DB::transaction(function () use ($request, $id) {
                    DB::table('coffees')->where('id', $id)->update([
                        'name' => $request->name,
                        'slug' => Str::slug($request->name),
                        'origin' => $request->origin,
                        'type' => $request->type,
                        'description' => $request->description,
                    ]);
                    if ($request->has('image')) {
                        $coffee = Coffee::find($id);
                        $oldImage = $coffee->image;

                        if ($oldImage) {
                            $pleaseRemove = base_path('public/images/coffee/') . $oldImage;

                            if (file_exists($pleaseRemove)) {
                                unlink($pleaseRemove);
                            }
                        }

                        $extension = $request->file('image')->getClientOriginalExtension();
                        $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
                        $destination = base_path('public/images/coffee/');
                        $request->file('image')->move($destination, $image);

                        Coffee::where('id', $id)->update([
                            'image' => $image,
                        ]);
                    };
                });

                $json = [
                    'msg' => 'Kopi berhasil disunting',
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
            $data = Coffee::find($id);
            if (!$data) {
                $json = [
                    'msg' => 'Data Tidak Ditemukan',
                    'status' => false,
                ];
            }
            $oldImage = $data->image;
            if ($oldImage) {
                $pleaseRemove = base_path('public/images/coffee/') . $oldImage;

                if (file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }
            }

            DB::transaction(function () use ($id) {
                DB::table('coffees')->where('id', $id)->delete();
            });

            $json = [
                'msg' => 'Kopi berhasil dihapus',
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