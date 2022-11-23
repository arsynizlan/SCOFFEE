<?php

namespace App\Http\Controllers\WEB\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Education;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


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
        // dd($request->image);
        $slug = Str::slug($request->title);
        try {
            DB::transaction(function () use ($request, $slug) {
                Education::create([
                    'title' => $request->title,
                    'slug' => $slug,
                    'image' => $request->image,
                    'category' => $request->category,
                    'body' => $request->body,
                    'user_id' => Auth::user()->id,
                ]);
            });
            $json = [
                'msg' => 'Success add education',
                'status' => true
            ];
        } catch (Exception $e) {
            $json = [
                'msg'       => 'error',
                'status'    => false,
                'e'         => $e
            ];
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
                return '<image class="img-thumbnail" src="https://scoffe.masuk.web.id/images/education/' . $row->image . '">';
            })
            ->addColumn('action', function ($row) {
                $data = [
                    'id' => $row->id
                ];
                return view('components.buttons.admin.events', $data);
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
        $slug = Str::slug($request->title);
        try {
            DB::transaction(function () use ($request, $id, $slug) {
                Education::where('id', $id)->update([
                    'title' => $request->title,
                    'slug' => $slug,
                    'image' => $request->image,
                    'category' => $request->category,
                    'body' => $request->body,
                ]);
            });
            $json = [
                'msg' => 'Berhasil Update',
                'status' => true
            ];
        } catch (Exception $e) {
            $json = [
                'msg'       => 'error',
                'status'    => false,
                'e'         => $e
            ];
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
                $pleaseRemove = '/home/scoffema/public_html/images/education/' . $oldImage;

                if (file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }
            }

            DB::transaction(function () use ($id) {
                DB::table('educations')->where('id', $id)->delete();
            });

            $json = [
                'msg' => 'Event berhasil dihapus',
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