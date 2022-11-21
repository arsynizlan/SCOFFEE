<?php

namespace App\Http\Controllers\WEB\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Termwind\Components\Dd;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'script' => 'components.scripts.admin.events'
        ];
        return view('pages.event.admin.index', $data);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd('masuk');
        if (is_numeric($id)) {
            $data = DB::table('events')
                ->join('users', 'events.user_id', '=', 'users.id')
                ->select(['events.*', 'users.name as author'])
                ->where('events.id', $id)
                ->first();
            return Response::json($data);
        }

        $data = Event::orderBy('id', 'desc')
            ->join('users', 'events.user_id', '=', 'users.id')
            ->where('events.user_id', '=', auth()->user()->id)
            ->select('events.*')
            ->get();
        return datatables()
            ->of($data)
            ->editColumn('created_at', function ($date) {
                return $date->created_at ? with(new Carbon($date->updated_at))->diffForHumans() : '';
            })
            ->addIndexColumn()
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

                return view('components.buttons.admin.events', $data);
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
        try {
            DB::transaction(function () use ($request, $id) {
                DB::table('events')->where('id', $id)->update([
                    'title' => $request->title,
                    'body' => $request->body,
                    'date' => $request->date,
                    'image' => $request->image,
                    'updated_at' => now()
                ]);
            });
            $json = [
                'msg' => 'Status publish event berhasil disunting',
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
            $event = Event::find($id);
            if (!$event) {
                $json = [
                    'msg' => 'Data Tidak Ditemukan',
                    'status' => false,
                ];
            }
            $oldImage = $event->image;
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
