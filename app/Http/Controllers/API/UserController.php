<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAdmin()
    {

        $admin = User::role('Admin')->get();
        if ($admin) {
            return successResponse(200, 'success', 'All Admin', $admin);
        }
        return errorResponse(404, 'error', 'Not Found');
    }

    public function getUser()
    {

        $admin = User::role('Admin')->get();
        return successResponse(200, 'success', 'All Admin', $admin);
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
        // ADD ADMIN
        $rules = [
            'name'     => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse(400, 'error', $validator->errors());
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ])->assignRole('Admin')->user_detail()->create();

            $data = User::where('id', $user->id)->first();

            return successResponse(201, 'success', 'Berhasil Tambah Admin', $data);
        } catch (Exception $e) {
            return errorResponse(400, 'error', $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::select('id', 'name', 'email')->find($id);
        if ($user) {
            $user->user_detail->image = $user->user_detail->imagePathProfile;
            $user->roles = User::find($user->id)->getRoleNames()[0];
            $data = [
                'user' => $user,
            ];
            return successResponse(200, 'success', 'User Detail', $data);
        } else {
            return errorResponse(404, 'error', 'User Tidak Ditemukan');
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

        $rules = [
            'name' => 'required',
            'email' => ['required', Rule::unique('users', 'email')->ignore($id)]
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse(400, 'error', $validator->errors());
        }
        try {
            if (Auth::user()->id == $id) {
                $user = User::with('user_detail')->find($id);
                User::where('id', $id)->update([
                    'name' => $request->name ? $request->name : $user->name,
                    'email' => $request->email ? $request->email : $user->email,
                ]);
                $userDetail = UserDetail::find($id);


                if ($request->hasFile('image')) {
                    $oldImage = $userDetail->image;
                    if ($oldImage == null) {

                        $extension = $request->file('image')->getClientOriginalExtension();
                        $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
                        $destination = base_path('public/images/profile/');
                        $request->file('image')->move($destination, $image);

                        UserDetail::where('id', $id)->update([
                            'description' => $request->description ? $request->description : $userDetail->description,
                            'born' => $request->born ? $request->born : $userDetail->born,
                            'academic' => $request->academic ? $request->academic : $userDetail->academic,
                            'work' => $request->work ? $request->work : $userDetail->work,
                            'image' => $image ? $image : $userDetail->image,
                        ]);
                    } elseif ($oldImage) {
                        $pleaseRemove = base_path('public/images/profile/') . $oldImage;
                        if (file_exists($pleaseRemove)) {
                            unlink($pleaseRemove);
                        }

                        $extension = $request->file('image')->getClientOriginalExtension();
                        $image = strtotime(date('Y-m-d H:i:s')) . '.' . $extension;
                        $destination = base_path('public/images/profile/');
                        $request->file('image')->move($destination, $image);

                        UserDetail::where('id', $id)->update([
                            'description' => $request->description ? $request->description : $userDetail->description,
                            'born' => $request->born ? $request->born : $userDetail->born,
                            'academic' => $request->academic ? $request->academic : $userDetail->academic,
                            'work' => $request->work ? $request->work : $userDetail->work,
                            'image' => $image ? $image : $userDetail->image,
                        ]);
                    }
                } else {
                    UserDetail::where('id', $id)->update([
                        'description' => $request->description ? $request->description : $userDetail->description,
                        'born' => $request->born ? $request->born : $userDetail->born,
                        'academic' => $request->academic ? $request->academic : $userDetail->academic,
                        'work' => $request->work ? $request->work : $userDetail->work,
                    ]);
                }

                $user = User::with('user_detail')->find($id);
                return successResponse(200, 'success', 'Berhasil Diupdate', $user);
            } else {
                return errorResponse(403, 'error', 'Unauthorized');
            }
        } catch (Exception $e) {
            return errorResponse(400, 'error', $e);
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
        //
    }
}