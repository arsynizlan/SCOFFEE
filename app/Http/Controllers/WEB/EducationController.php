<?php

namespace App\Http\Controllers\WEB;

use Exception;
use Carbon\Carbon;
use App\Models\Education;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'script' => 'components.scripts.education'
        ];
        return view('pages.education.index', $data);
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
            'title' => 'unique:educations',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $json = [
                'msg'       => 'Judul sudah digunakan!',
                'status'    => false
            ];
            return Response::json($json);
        } elseif ($request->title == NULL) {
            $json = [
                'msg'       => 'Mohon berikan judul',
                'status'    => false
            ];
        } elseif ($request->category == NULL) {
            $json = [
                'msg'       => 'Mohon berikan asal kopi',
                'status'    => false
            ];
        } elseif ($request->body == NULL) {
            $json = [
                'msg'       => 'Mohon berikan deskripsi',
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
                    $destination = base_path('public/images/education/');
                    $request->file('image')->move($destination, $image);

                    Education::create([
                        'title' => $request->title,
                        'slug' => Str::slug($request->title),
                        'category' => $request->category,
                        'body' => $request->body,
                        'image' => $image,
                        'user_id' => Auth::user()->id,
                    ]);
                });

                $json = [
                    'msg' => 'Edukasi berhasil ditambahkan',
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
            $data = DB::table('educations')
                ->where('educations.id', $id)
                ->first();
            return Response::json($data);
        }
        $data = Education::orderBy('id', 'desc')
            ->join('users', 'educations.user_id', '=', 'users.id')
            ->where('educations.user_id', '=', auth()->user()->id)
            ->select('educations.*')
            ->get();
        return datatables()
            ->of($data)
            ->editColumn('updated_at', function ($date) {
                return $date->updated_at ? with(new Carbon($date->updated_at))->diffForHumans() : '';
            })
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                return '<image class="img-thumbnail" src="' . asset('images/education/' . $row->image) . '">';
            })
            ->addColumn('action', function ($row) {
                $data = [
                    'id' => $row->id
                ];
                return view('components.buttons.admin.educations', $data);
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
            'title' => 'unique:educations',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $json = [
                'msg'       => 'Judul sudah digunakan!',
                'status'    => false
            ];
            return Response::json($json);
        } elseif ($request->title == NULL) {
            $json = [
                'msg'       => 'Mohon berikan judul',
                'status'    => false
            ];
        } elseif ($request->category == NULL) {
            $json = [
                'msg'       => 'Mohon berikan asal kopi',
                'status'    => false
            ];
        } elseif ($request->body == NULL) {
            $json = [
                'msg'       => 'Mohon berikan deskripsi',
                'status'    => false
            ];
        } else {
            try {
                DB::transaction(function () use ($request, $id) {
                    DB::table('educations')->where('id', $id)->update([
                        'title' => $request->title,
                        'slug' => Str::slug($request->title),
                        'category' => $request->category,
                        'body' => $request->body,
                        'user_id' => Auth::user()->id,
                    ]);
                    if ($request->has('image')) {
                        $education = Education::find($id);
                        $oldImage = $education->image;
                        if ($oldImage) {
                            $pleaseRemove = base_path('public/images/education/')  . $oldImage;

                            if (file_exists($pleaseRemove)) {
                                unlink($pleaseRemove);
                            }
                        }

                        $extension = $request->file('image')->getClientOriginalExtension();
                        $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
                        $destination = base_path('public/images/education/');
                        $request->file('image')->move($destination, $image);

                        Education::where('id', $id)->update([
                            'image' => $image,
                        ]);
                    };
                });

                $json = [
                    'msg' => 'Edukasi berhasil disunting',
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
            $event = Education::find($id);
            if (!$event) {
                $json = [
                    'msg' => 'Data Tidak Ditemukan',
                    'status' => false,
                ];
            }
            $oldImage = $event->image;
            if ($oldImage) {
                $pleaseRemove = base_path('public/images/education/') . $oldImage;

                if (file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }
            }

            DB::transaction(function () use ($id) {
                DB::table('educations')->where('id', $id)->delete();
            });

            $json = [
                'msg' => 'Edukasi berhasil dihapus',
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

    /** SuperAdmin Only */
    public function indexForSuperAdmin()
    {
        $data = [
            'script' => 'components.scripts.superadmin.education'
        ];
        return view('pages.superadminEducation.index', $data);
    }


    public function showForSuperAdmin($id)
    {
        if (is_numeric($id)) {
            $data = DB::table('educations')
                ->join('users', 'educations.user_id', '=', 'users.id')
                ->select(['educations.*', 'users.name as author'])
                ->where('educations.id', $id)
                ->first();
            return Response::json($data);
        }

        $data = Education::orderBy('id', 'desc')
            ->join('users', 'educations.user_id', '=', 'users.id')
            ->select(['educations.*', 'users.name as author'])
            ->get();
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                return '<image class="img-thumbnail" src="' . asset('images/education/' . $row->image) . '">';
            })
            ->addColumn('action', function ($row) {
                $data = [
                    'id' => $row->id
                ];

                return view('components.buttons.superadmin.educations', $data);
            })
            ->rawColumns(['action', 'image'])
            ->make(true);
    }

    public function destroyForSuperAdmin($id)
    {
        try {
            $event = Education::find($id);
            if (!$event) {
                $json = [
                    'msg' => 'Data Tidak Ditemukan',
                    'status' => false,
                ];
            }
            $oldImage = $event->image;
            if ($oldImage) {
                $pleaseRemove = base_path('public/images/education/') . $oldImage;

                if (file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }
            }

            DB::transaction(function () use ($id) {
                DB::table('educations')->where('id', $id)->delete();
            });

            $json = [
                'msg' => 'Edukasi berhasil dihapus',
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