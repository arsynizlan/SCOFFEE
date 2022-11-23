<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Coffee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
        $coffees = DB::table('coffees')
            ->select(
                'coffees.id',
                'coffees.name',
                'coffees.slug',
                'coffees.type',
                'coffees.image',
                'coffees.origin',
                'coffees.description',
                'coffees.created_at',
                'coffees.updated_at'
            )
            ->latest()->paginate(5);
        return successResponse(200, 'success', 'List Kopi', $coffees);
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
            'name' => 'required|max:255',
            'origin' => 'required',
            'type' => 'required',
            'description' => 'required',
            'story' => 'required',
            'image' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse(422, 'error', $validator->errors());
        }

        try {
            $extension = $request->file('image')->getClientOriginalExtension();
            $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
            $destination = '/home/scoffema/public_html/images/coffee/';
            $request->file('image')->move($destination, $image);

            $coffee = Coffee::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'origin' => $request->origin,
                'type' => $request->type,
                'description' => $request->description,
                'story' => $request->story,
                'image' => $image,
            ]);
        } catch (Exception $e) {
            return errorResponse(400, 'Error', $e);
        }
        return successResponse(201, 'success', 'Kopi Berhasil Dibuat', $coffee);
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

            $coffees = Coffee::where('coffees.id', $id)
                ->select(
                    'coffees.id',
                    'coffees.name',
                    'coffees.slug',
                    'coffees.origin',
                    'coffees.type',
                    'coffees.image',
                    'coffees.description',
                    'coffees.created_at',
                    'coffees.updated_at'
                )->first();

            if (!$coffees) {
                return errorResponse(404, 'error', 'Not Found');
            }
            return successResponse(200, 'success', 'Detail Kopi', $coffees);
        }
        $coffees = Coffee::where('coffees.slug', $id)
            ->select(
                'coffees.id',
                'coffees.name',
                'coffees.slug',
                'coffees.origin',
                'coffees.type',
                'coffees.image',
                'coffees.description',
                'coffees.created_at',
                'coffees.updated_at'
            )->first();

        if (!$coffees) {
            return errorResponse(404, 'error', 'Not Found');
        }
        return successResponse(200, 'success', 'Detail Kopi', $coffees);
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
        $coffees = Coffee::find($id);
        if (!$coffees) {
            return errorResponse(404, 'error', 'Not Found');
        }
        $rules = [
            'name' => 'required|max:255',
            'origin' => 'required',
            'type' => 'required',
            'description' => 'required',
            'story' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse(422, 'error', $validator->errors());
        }

        if ($request->hasFile('image')) {
            $oldImage = $coffees->image;
            if ($oldImage) {
                $pleaseRemove = '/home/scoffema/public_html/images/coffee/' .  $oldImage;

                if (file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }
            }

            $extension = $request->file('image')->getClientOriginalExtension();
            $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
            $destination = '/home/scoffema/public_html/images/coffee/';
            $request->file('image')->move($destination, $image);

            $coffees->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'origin' => $request->origin,
                'type' => $request->type,
                'description' => $request->description,
                'story' => $request->story,
                'image' => $image,
            ]);
        } else {
            $coffees->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'origin' => $request->origin,
                'type' => $request->type,
                'description' => $request->description,
                'story' => $request->story,
            ]);
        }
        return successResponse('200', 'success', 'Kopi Berhasil disunting', $coffees);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coffees = Coffee::find($id);
        if (!$coffees) {
            return errorResponse(404, 'error', 'Not Found');
        }
        $oldImage = $coffees->image;
        if ($oldImage) {
            $pleaseRemove = '/home/scoffema/public_html/images/coffee/' . $oldImage;

            if (file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }

        Coffee::destroy($id);

        return successResponse(200, 'success', 'Kopi Berhasil Dihapus', null);
    }
}