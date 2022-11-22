<?php

namespace App\Http\Controllers\API;


use Exception;
use App\Models\Forum;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Termwind\Components\Dd;

class ForumController extends Controller
{
    /**
     * Dispalay forum with comment
     *
     * @param  mixed $request
     * @return void
     */
    // public function groupCategory($category)
    public function forumComment($id)
    {
        $forum = DB::table('forums')
            ->join('categories', 'forums.category_id', '=', 'categories.id')
            ->join('contexts', 'forums.context_id', '=', 'contexts.id')
            ->join('users', 'forums.user_id', '=', 'users.id')
            ->select(
                'forums.id',
                'users.name as user',
                'categories.name as category',
                'contexts.name as context',
                'forums.description',
                'forums.image as image',
            )
            ->where('forums.id', '=', $id)
            ->first();
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->join('forums', 'comments.forum_id', '=', 'forums.id')
            ->select(
                'users.id',
                'users.name as user',
                'comments.content',
                'comments.created_at'
            )
            ->where('forums.id', '=', $id)
            ->latest('comments.id')->paginate(5,);

        $data = [
            'forums' => $forum,
            'comments' => $comments,
        ];
        return successResponse(200, 'success', 'Forum with comment', $data);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('category')) {
            $category = $request->category;
            $forum = DB::table('forums')
                ->join('categories', 'forums.category_id', '=', 'categories.id')
                ->join('contexts', 'forums.context_id', '=', 'contexts.id')
                ->join('users', 'forums.user_id', '=', 'users.id')
                ->select(
                    'forums.id',
                    'users.name as user',
                    'categories.name as category',
                    'contexts.name as context',
                    'forums.description',
                    'forums.image as image',
                )
                ->where('categories.name', '=', $category)
                ->latest('id')->paginate(5);
            if ($forum->total() == 0) {
                return errorResponse(404, 'Error', 'Belum ada data');
            }
            return successResponse(200, 'success', 'Forum by category ' . $category, $forum);
        }
        $comments = Forum::join('users', 'forums.user_id', '=', 'users.id')
            ->join('contexts', 'forums.context_id', '=', 'contexts.id')
            ->join('categories', 'forums.category_id', '=', 'categories.id')
            ->select(
                'forums.id as forum_id',
                'categories.name as category',
                'contexts.name as context',
                'users.name',
                'forums.description',
                'forums.image'
            )
            ->withCount('comments as total_comment')
            ->paginate(5);
        return successResponse(200, 'success', 'Forums', $comments);
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
            'category_id' => 'required',
            'context_id' => 'required',
            'description' => 'required',
            'image' => 'image',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse(422, 'error', $validator->errors());
        }

        try {
            $image = null;
            if ($request->file('image')) {
                $extension = $request->file('image')->getClientOriginalExtension();
                $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
                $destination = '/home/scoffema/public_html/images/posting/';
                $request->file('image')->move($destination, $image);
            }
            // dd('masuk');
            $event = Forum::create([
                'user_id' => auth()->user()->id,
                'category_id' => $request->category_id,
                'context_id' => $request->context_id,
                'description' => $request->description,
                'image' => $image,
            ]);
        } catch (Exception $e) {
            return errorResponse(400, 'Error', $e);
        }
        return successResponse(201, 'success', 'Postingan Berhasil', $event);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $forum = DB::table('forums')
            ->join('categories', 'forums.category_id', '=', 'categories.id')
            ->join('contexts', 'forums.context_id', '=', 'contexts.id')
            ->join('users', 'forums.user_id', '=', 'users.id')
            ->where('forums.id', '=', $id)
            ->select(
                'forums.id',
                'categories.name as category',
                'contexts.name as context',
                'forums.description',
                'forums.image as image',
                'users.name as user'
            )
            ->first();

        $image = asset('images/posting/' . $forum->image);

        $data = [
            $forum,
            $image
        ];

        if ($forum) {
            return successResponse(200, 'success', 'tampilan postingan ' .  $forum->user, $data);
        }
        return errorResponse(404, 'error', 'Not Found');
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
        $rules = [
            'category_id' => 'required',
            'context_id' => 'required',
            'description' => 'required',
            'image' => 'image',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse(422, 'error', $validator->errors());
        }

        try {
            $postingan = Forum::findOrFail($id);
            $oldImage = $postingan->image;
            // dd($request->image);
            if ($request->hasFile('image')) {
                if ($postingan->image) {
                    $pleaseRemove = '/home/scoffema/public_html/images/posting/' . $oldImage;
                    if (file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }

                $extension = $request->file('image')->getClientOriginalExtension();
                $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
                $destination = '/home/scoffema/public_html/images/posting/';
                $request->file('image')->move($destination, $image);
            } else {
                $pleaseRemove = '/home/scoffema/public_html/images/posting/' . $oldImage;
                if (file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }
                $image = null;
            }
            Forum::where('id', '=', $id)->update([
                'category_id' => $request->category_id,
                'context_id' => $request->context_id,
                'description' => $request->description,
                'image' => $image,
            ]);
            $postingan = Forum::findOrFail($id);
            return successResponse(200, 'success', 'Tampil Category ', $postingan);
        } catch (Exception $e) {
            return errorResponse(404, 'error', 'Data Not Found' . $e);
        }
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
            Forum::findOrFail($id);
            DB::transaction(function () use ($id) {
                Forum::where('id', $id)->delete();
            });
            return successResponse(202, 'success', 'Berhasil Hapus Postingan', null);
        } catch (Exception $e) {
            return errorResponse(400, 'error', $e);
        }
    }
}
