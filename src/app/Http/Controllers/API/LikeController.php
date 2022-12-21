<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Like;
use App\Models\Forum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;

class LikeController extends Controller
{
    public function likeOrUnlike($id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return errorResponse(404, 'error', 'Not Found');
        }

        $like = $forum->likes()->where('user_id', Auth::user()->id)->first();

        if (!$like) {
            $user_like = Like::create([
                'forum_id' => $id,
                'user_id' => Auth::user()->id
            ]);
            return successResponse(201, 'success', 'Postingan berhasil disukai!', $user_like);
        }

        $like->delete();
        return successResponse(200, 'success', 'Berhasil Unliked', null);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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