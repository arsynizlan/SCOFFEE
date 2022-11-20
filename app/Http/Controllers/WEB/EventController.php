<?php

namespace App\Http\Controllers\WEB;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            'script' => 'components.scripts.events'
        ];
        return view('pages.event.index', $data);
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
        if (is_numeric($id)) {

            // $event = Event::where('events.id', $id)
            //     ->join('users', 'events.user_id', '=', 'users.id')
            //     ->select(
            //         'events.id',
            //         'users.name as author',
            //         'events.image',
            //         'events.title',
            //         'events.slug',
            //         'events.body',
            //         'events.date',
            //         'events.status_publish',
            //         'events.created_at',
            //         'events.updated_at'
            //     )->first();
            // if (!$event) {
            //     return errorResponse(404, 'error', 'Not Found');
            // }
            // // $event->image = $event->imagePathEvent;
            // if ($event->status_publish == 1) {
            //     return successResponse(200, 'success', 'Detail Event', $event);
            // } else {
            //     return errorResponse(404, 'error', 'Not Found');
            // }
        }

        $data = Event::orderBy('id', 'desc')
            ->join('users', 'events.user_id', '=', 'users.id')
            ->select(['events.*', 'users.name as author'])
            ->get();
        return datatables()
            ->of($data)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}