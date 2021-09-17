<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::pluck('display_name', 'id')->all();
        return view('user.index', compact('roles'));
    }

    public function dataList(Request $request)
    {
        $users = User::select(['users.id', 'users.name', 'email', 'active', 'role_id', 'display_name as role_name'])
            ->leftJoin('role_user', 'users.id', '=', 'user_id')
            ->leftJoin('roles', 'roles.id', '=', 'role_id');

        return Datatables::of($users)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if ($request->post('name') != '') {
                    $query->whereRaw('LOWER(users.name) like  ?', ["%{$request->post('name')}%"]);
                }
                if ($request->post('role_id') != '') {
                    $query->whereRaw('LOWER(role_id) like  ?', ["%{$request->post('role_id')}%"]);
                }
            })
            ->editColumn('active', function ($user) {
                if ($user->active == 1) {
                    return '<span class="badge badge-light-success"> Aktif </span>';
                } else {
                    return '<span class="badge badge-light-danger"> Tidak Aktif </span>';
                }
            })
            ->addColumn('action', function ($user) {
                $btn = '';
                if (\Laratrust::hasRole('administrator')) {
                    $btn = '<a href="' . route('user.edit', $user->id) . '" class="text-success" title="edit">
                                    <i data-feather="edit-2"></i>
                                </a> ';
                    if ($user->id !== 1) {
                        $btn .= ' <a href="javascript:void(0)" data-url="' . route('user.destroy', $user->id) . '" data-token="' . csrf_token() . '" class="text-danger table-delete">
                                    <i data-feather="trash"></i>
                                </a>';
                    }
                    $btn .= '<a href="' . route('user.change.password', $user->id) . '" class="text-warning" title="ubah password">
                        <i data-feather="key"></i>
                    </a> ';
                }
                return $btn;
            })
            ->rawColumns(['role', 'active', 'action'])
            ->make();
    }

    public function create()
    {
        $roles = Role::whereNotIn('name', ['administrator'])->pluck('display_name', 'id')->all();

        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $roles = [
            'role_id'  => 'required',
            'name'     => 'required',
            'email'    => 'required|unique:users',
            'password' => 'required|same:password-confirm',
            'password-confirm' => 'required',
        ];

        $validator = Validator::make($request->all(), $roles);
        if ($validator->fails()) return response()->json(['success' => false, 'errors'  => $validator->getMessageBag()->toArray(),], 400);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'redirect' => route('user.index')
        ]);
    }

    public function show(User $user)
    {
    }

    public function edit(User $user)
    {
        // $roles = Role::pluck('display_name', 'id')->all();
        $roles = Role::whereNotIn('name', ['administrator'])->pluck('display_name', 'id')->all();

        return view('user.edit', compact('roles', 'user'));
    }

    public function update(Request $request, User $user)
    {
        $roles = [
            'role_id' => 'required',
            'name'    => 'required',
            'email'   => 'required|unique:users,email,' . $user->id,
            'active'  => 'required',
        ];

        $validator = Validator::make($request->all(), $roles);
        if ($validator->fails()) return response()->json(['success' => false, 'errors'  => $validator->getMessageBag()->toArray(),], 400);

        $user->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'redirect' => route('user.index')
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true]);
    }

    public function changePassword(User $user)
    {
        return view('user.change-password', compact('user'));
    }

    public function changePasswordStore(Request $request, User $user)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'new_password' => ['required'],
                'new_confirm_password' => ['same:new_password']
            ],
        );

        if ($validator->fails()) return response()->json(['success' => false, 'errors'  => $validator->getMessageBag()->toArray(),], 400);

        $user->password = Hash::make($request->new_password);
        $user->saveQuietly();

        return response()->json([
            'success'  => true,
            'message'  => 'Password berhasil diperbarui',
            'redirect' => route('user.index')
        ]);
    }
}