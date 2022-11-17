<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Education;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $educations = DB::table('educations')
            ->join('users', 'educations.user_id', '=', 'users.id')
            ->select(
                'educations.id',
                'users.name as author',
                'educations.image',
                'educations.title',
                'educations.slug',
                'educations.body',
                'educations.created_at',
                'educations.updated_at'
            )
            ->latest()->paginate(5);
        return successResponse(200, 'success', 'List Edukasi', $educations);
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
            'title' => 'required|max:255',
            'body' => 'required',
            'category' => 'required',
            'image' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse(400, 'error', $validator->errors());
        }

        try {
            $extension = $request->file('image')->getClientOriginalExtension();
            $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
            $destination = base_path('public/images/education/');
            $request->file('image')->move($destination, $image);

            $education = Education::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'category' => $request->category,
                'body' => $request->body,
                'image' => $image,
                'user_id' => Auth::user()->id,
            ]);
        } catch (Exception $e) {
            return errorResponse(422, 'Error', $e);
        }
        return successResponse(201, 'success', 'Edukasi Berhasil Dibuat', $education);
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

            $educations = Education::where('educations.id', $id)
                ->join('users', 'educations.user_id', '=', 'users.id')
                ->select(
                    'educations.id',
                    'users.name as author',
                    'educations.image',
                    'educations.title',
                    'educations.slug',
                    'educations.body',
                    'educations.created_at',
                    'educations.updated_at'
                )->first();

            if (!$educations) {
                return errorResponse(404, 'error', 'Not Found');
            }
            return successResponse(200, 'success', 'Detail Edukasi', $educations);
        }
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