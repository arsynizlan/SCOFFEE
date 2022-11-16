<?php

namespace App\Http\Controllers\API;


use Exception;
use App\Models\Forum;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class ForumController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'categories_id' => 'required',
            'context_id' => 'required',
            'title' => 'required',
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
                $destination = base_path('public/images/posting/');
                $request->file('image')->move($destination, $image);
            }
            // dd('masuk');
            $event = Forum::create([
                'user_id' => auth()->user()->id,
                'category_id' => $request->categories_id,
                'context_id' => $request->context_id,
                'title' => $request->title,
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
                'forums.title',
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
            'title' => 'required',
            'description' => 'required',
            'image' => 'image',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse(422, 'error', $validator->errors());
        }

        try {
            $postingan = Forum::findOrFail($id);
            if ($request->hasFile('image')) {
                $oldImage = $postingan->image;
                if ($oldImage == null) {

                    $extension = $request->file('image')->getClientOriginalExtension();
                    $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
                    $destination = base_path('public/images/posting/');
                    $request->file('image')->move($destination, $image);

                    Category::where('id', $id)->update([
                        'category_id' => $request->categories_id,
                        'context_id' => $request->context_id,
                        'title' => $request->title,
                        'description' => $request->description,
                        'image' => $image,
                    ]);
                } elseif ($oldImage) {
                    $pleaseRemove = base_path('public/images/posting/') . $oldImage;
                    if (file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }

                    $extension = $request->file('image')->getClientOriginalExtension();
                    $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
                    $destination = base_path('public/images/posting/');
                    $request->file('image')->move($destination, $image);
                }
            }
            return successResponse(200, 'success', 'Tampil Category ', $postingan);
        } catch (Exception $e) {
            return errorResponse(404, 'error', 'Data Not Found');
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
