<?php

namespace App\Http\Controllers\API;


use Exception;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        try {
            $rules = [
                'comment' => 'required|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return errorResponse(422, 'error', $validator->errors());
            }
            $comment = Comment::create([
                'forum_id' => $request->forum_id,
                'content' => $request->comment,
                'user_id' => auth()->user()->id
            ]);
            return successResponse(200, 'success', 'Comment', $comment);
        } catch (Exception $e) {
            return errorResponse(400, 'error', $e);
            // dd($asik);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        // dd('masuk');
        $forum = $request->forum;
        $comment = $request->comment;
        // $id = auth()->user()->id;
        DB::table('forums')
            ->join('comments', 'forums.id', '=', 'comments.forum_id')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where('forums.id', $forum)
            ->where('comments.id', '=', $comment)
            ->update(
                [
                    'forums.id as forum_id' = 2,
                ]
            )
            ->first();
        // dd($id);

        Comment::where('');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
