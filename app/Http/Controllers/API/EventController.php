<?php

namespace App\Http\Controllers\API;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EventStoreRequest;
use Exception;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::where('status_publish', '1')->latest()->paginate(5);
        foreach ($events as $event) {
            $event->image = $event->imagePath;
        }
        // return response()->json([
        //     'status' => true,
        //     'message' => 'List All Events',
        //     'data' => $events->map(function ($event) {
        //         return [
        //             'id' => $event->id,
        //             'user_id' => $event->user_id,
        //             'image' => $event->image,
        //             'title' => $event->title,
        //             'slug' => $event->slug,
        //             'body' => $event->body,
        //             'status_publish' => $event->status_publish,
        //             'created_at' => $event->created_at,
        //             'updated_at' => $event->updated_at,
        //         ];
        //     }),

        // ]);
        return new ApiResource(True, 'List events', $events);
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
    public function store(EventStoreRequest $request)
    {
        $request->validated();
        try {
            $extension = $request->file('image')->getClientOriginalExtension();
            $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
            $destination = base_path('public/images/');
            $request->file('image')->move($destination, $image);

            if (Auth::user()->hasRole('Admin')) {
                $status = 1;
            }

            $event = Event::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'body' => $request->body,
                'image' => $image,
                'user_id' => Auth::user()->id,
                'status_publish' => $status,
            ]);
        } catch (Exception $e) {
            return new ApiResource(false, 'Error', $e);
        }
        return new ApiResource(true, 'Event Berhasil Ditambah', $event);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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