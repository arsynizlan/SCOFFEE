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
        // dd('masuk');
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
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd('masuk');
        $rules = [
            'comment' => 'required|max:300',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse(422, 'error', $validator->errors());
        }
        try {
            $forum = $request->forum;
            $comments = $request->comment;
            DB::table('comments')
                ->where('forum_id', '=', $forum)
                ->where('id', '=', $comments)
                ->update(
                    [
                        'content' => $request->message
                    ]
                );
            $data = Comment::with(['user' => function ($query) {
                $query->select('id', 'name');
            }])->where([
                ['forum_id', '=', $forum],
                ['id', '=', $comments],
            ])->first();

            return successResponse(200, 'success', 'Update Comment', $data);
        } catch (Exception $e) {
            return errorResponse(400, 'error', $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        Comment::destroy($comment->id);
        return successResponse(200, 'success', 'comment Delete', null);
    }
}
