<?php

namespace App\Http\Controllers\WEB;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'script' => 'components.scripts.users'
        ];
        return view('pages.users.index', $data);
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

        if ($request->name == NULL) {
            $json = [
                'msg'       => 'Mohon berikan nama',
                'status'    => false
            ];
        } elseif ($request->email == NULL) {
            $json = [
                'msg'       => 'Mohon berikan email',
                'status'    => false
            ];
        } elseif (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $json = [
                'msg'       => 'Email tidak valid!',
                'status'    => false
            ];
        } elseif ($request->password == NULL) {
            $json = [
                'msg'       => 'Mohon berikan password',
                'status'    => false
            ];
        } elseif (strlen($request->password) < 8) {
            $json = [
                'msg'       => 'Password minimal character 8!',
                'status'    => false
            ];
        } elseif ($request->password != $request->password_confirmation) {
            $json = [
                'msg'       => 'Password tidak cocok!',
                'status'    => false
            ];
        } else {
            try {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ])->assignRole('Admin')->user_detail()->create();

                $json = [
                    'msg' => 'Admin ditambahkan',
                    'status' => true
                ];
            } catch (Exception $e) {
                $json = [
                    'msg'       => 'Error',
                    'status'    => false,
                    'e'         => $e
                ];
            }
        }
        return Response::json($json);
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
            $data = DB::table('users')
                ->where('users.id', $id)
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select('users.id', 'users.name', 'email', 'roles.name as roles')
                ->first();
            return Response::json($data);
        }
        $data = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.id', 'users.name', 'email', 'roles.name as roles')
            ->latest('users.id')->get();




        // User::with('roles')->orderBy('id', 'desc')
        //     ->select('id', 'name', 'email', 'roles.name as roles')
        //     ->get();


        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $data = [
                    'id' => $row->id
                ];

                return view('components.buttons.users', $data);
            })

            ->rawColumns(['action'])
            ->make(true);
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