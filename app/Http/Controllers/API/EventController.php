<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            $event->image = $event->imagePathEvent;
        }
        // return response()->json([
        //     'code' => 200,
        //     'status' => 'success',
        //     'message' => 'List Events',
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
        return successResponse(200, 'success', 'List Event', $events);
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
            'title' => 'required|max:255',
            'body' => 'required',
            'date' => 'required',
            'image' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse(400, 'error', $validator->errors());
        }

        try {
            $extension = $request->file('image')->getClientOriginalExtension();
            $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
            $destination = base_path('public/images/events/');
            $request->file('image')->move($destination, $image);

            if (Auth::user()->hasRole('SuperAdmin')) {
                $status = 1;
            }
            $event = Event::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'date' => $request->date,
                'body' => $request->body,
                'image' => $image,
                'user_id' => Auth::user()->id,
                'status_publish' => $status,
            ]);
        } catch (Exception $e) {
            return errorResponse(422, 'Error', $e);
        }
        return successResponse(201, 'success', 'Event Berhasil Dibuat', $event);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return errorResponse(404, 'error', 'Not Found');
        }
        $event->image = $event->imagePathEvent;
        if ($event->status_publish == 1) {
            return successResponse(200, 'success', 'Detail Event', $event);
        } else {
            return errorResponse(404, 'error', 'Not Found');
        }
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
        $event = Event::find($id);
        if (!$event) {
            return errorResponse(404, 'error', 'Not Found');
        }
        $rules = [
            'title' => 'required|max:255',
            'body' => 'required',
            'date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse(400, 'error', $validator->errors());
        }

        if ($request->hasFile('image')) {
            $oldImage = $event->image;
            if ($oldImage) {
                $pleaseRemove = base_path('public/images/events/') .  $oldImage;

                if (file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }
            }

            $extension = $request->file('image')->getClientOriginalExtension();
            $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
            $destination = base_path('public/images/events/');
            $request->file('image')->move($destination, $image);

            $event->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'date' => $request->date,
                'body' => $request->body,
                'image' => $image,
                'user_id' => Auth::user()->id,
                'status_publish' => $request->status_publish,
            ]);
        } elseif (!$request->hasFile('image')) {

            $event->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'date' => $request->date,
                'body' => $request->body,
                'status_publish' => $request->status_publish,
                'user_id' => Auth::user()->id,
            ]);
        } else {
            return errorResponse('422', 'error', 'Event gagal disunting');
        }
        return successResponse('200', 'success', 'Event Berhasil disunting', $event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return errorResponse(404, 'error', 'Not Found');
        }
        $oldImage = $event->image;
        if ($oldImage) {
            $pleaseRemove = base_path('public/images/events/') . $oldImage;

            if (file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }

        Event::destroy($id);

        return successResponse(200, 'success', 'Event Berhasil Dihapus', null);
    }
}
