<?php

namespace App\Http\Controllers\WEB;

use Exception;
use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PersonalEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'script' => 'components.scripts.personalEvent.events'
        ];
        return view('pages.personalEvent.index', $data);
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
        if ($request->title == NULL) {
            $json = [
                'msg'       => 'Mohon berikan judul event',
                'status'    => false
            ];
        } elseif ($request->body == NULL) {
            $json = [
                'msg'       => 'Mohon berikan body event',
                'status'    => false
            ];
        } elseif ($request->image == NULL) {
            $json = [
                'msg'       => 'Mohon berikan gambar',
                'status'    => false
            ];
        } elseif ($request->date == NULL) {
            $json = [
                'msg'       => 'Mohon berikan tanggal acara',
                'status'    => false
            ];
        } else {
            try {
                DB::transaction(function () use ($request) {
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
                    $destination = '/home/scoffema/public_html/images/events/';
                    $request->file('image')->move($destination, $image);

                    if (Auth::user()->hasRole('SuperAdmin')) {
                        $status = 1;
                    } else {
                        $status = 0;
                    }

                    Event::create([
                        'title' => $request->title,
                        'slug' => Str::slug($request->title),
                        'date' => $request->date,
                        'body' => $request->body,
                        'image' => $image,
                        'user_id' => Auth::user()->id,
                        'status_publish' => $status,
                    ]);
                });

                $json = [
                    'msg' => 'Event berhasil ditambahkan',
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
            $data = DB::table('events')
                ->where('id', $id)
                ->first();
            return Response::json($data);
        }
        $id = Auth::user()->id;
        $data = Event::orderBy('id', 'desc')
            ->where('events.user_id', $id)
            ->join('users', 'events.user_id', '=', 'users.id')
            ->select(['events.*', 'users.name as author'])
            ->get();
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function ($date) {
                return $date->created_at ? with(new Carbon($date->updated_at))->diffForHumans() : '';
            })
            ->addColumn('status_publish', function ($row) {
                if ($row->status_publish == 0) {
                    return '<span class="badge bg-danger">Belum Dipublikasi</span>';
                } else {
                    return '<span class="badge bg-success">Terpublikasi</span>';
                }
            })
            ->addColumn('image', function ($row) {
                return '<image class="img-thumbnail" src="https://scoffe.masuk.web.id/images/events/' . $row->image . '">';
            })
            ->addColumn('action', function ($row) {
                $data = [
                    'id' => $row->id
                ];

                return view('components.buttons.events', $data);
            })
            ->rawColumns(['status_publish', 'action', 'image'])
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
        if ($request->title == NULL) {
            $json = [
                'msg'       => 'Mohon berikan judul event',
                'status'    => false
            ];
        } elseif ($request->body == NULL) {
            $json = [
                'msg'       => 'Mohon berikan body event',
                'status'    => false
            ];
        } elseif ($request->date == NULL) {
            $json = [
                'msg'       => 'Mohon berikan tanggal acara',
                'status'    => false
            ];
        } else {
            try {
                DB::transaction(function () use ($request, $id) {;
                    DB::table('events')->where('id', $id)->update([
                        'title' => $request->title,
                        'slug' => Str::slug($request->title),
                        'date' => $request->date,
                        'body' => $request->body,
                    ]);

                    if ($request->has('image')) {
                        $oldImage = $request->image;

                        if ($oldImage) {
                            $pleaseRemove = '/home/scoffema/public_html/images/events/' . $oldImage;

                            if (file_exists($pleaseRemove)) {
                                unlink($pleaseRemove);
                            }
                        }

                        $extension = $request->file('image')->getClientOriginalExtension();
                        $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
                        $destination = '/home/scoffema/public_html/images/events/';
                        $request->file('image')->move($destination, $image);

                        Event::where('id', $id)->update([
                            'image' => $image,
                        ]);
                    };
                });

                $json = [
                    'msg' => 'Event berhasil disunting',
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
            $data = Event::find($id);
            if (!$data) {
                $json = [
                    'msg' => 'Data Tidak Ditemukan',
                    'status' => false,
                ];
            }
            $oldImage = $data->image;
            if ($oldImage) {
                $pleaseRemove = '/home/scoffema/public_html/images/events/' . $oldImage;

                if (file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }
            }

            DB::transaction(function () use ($id) {
                DB::table('events')->where('id', $id)->delete();
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