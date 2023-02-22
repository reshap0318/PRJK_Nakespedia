<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.user.index');
    }

    public function datatable()
    {
        $query = User::query();
        return DataTables::eloquent($query)
            ->editColumn('last_login', function ($d) {
                return $d->last_login ? $d->last_login->diffForHumans() : "-";
            })
            ->addColumn('avatar_url', function ($d) {
                return $d->avatar_url;
            })
            ->addColumn('role_text', function ($d) {
                return $d->role_text;
            })
            ->addColumn('action', function ($d)
            {
                return [
                    'edit' => [
                        'isCan' => Auth::user()->is_su_admin,
                        'link'  => route('user.edit', ['user' => $d])
                    ],
                    'delete' => [
                        'isCan' => Auth::user()->is_su_admin && $d->id != Auth::id(),
                        'link'  => route('user.destroy', ['user' => $d])
                    ]
                ];
            })
            ->make(true);
    }

    public function create()
    {
        return view('pages.user.create', [
            'role' => User::ROLE_TEXT,
            'img'  => asset('template/assets/media/svg/files/blank-image.svg')
        ]);
    }

    public function store(UserRequest $request)
    {
        try {
            $user = User::create($request->all());
            if($request->avatar){
                $avatar = $request->avatar->storeAs('avatar', uniqid('user-id-')."-".$user->id);
                $user->avatar_path = $avatar;
                $user->update();
            }
        } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('error', 'failed created data');    
        }

        return redirect()->route('user.index')->with('success', 'successfully created data');   
    }

    public function edit(User $user)
    {
        return view('pages.user.edit', [
            'user' => $user,
            'role' => User::ROLE_TEXT,
            'img'  => $user->avatar_path ? $user->avatar_url : asset('template/assets/media/svg/files/blank-image.svg')
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $data = $request->all();
            if(!$request->password) $data = $request->except(['password']);
            $user->update($data);
            if($request->avatar){
                if($user->avatar_path) Storage::delete($user->avatar_path);
                $fileName = uniqid('user-id-')."-".$user->id.".".$request->avatar->getClientOriginalExtension();
                $avatar = $request->avatar->storeAs('avatar', $fileName);
                $user->avatar_path = $avatar;
                $user->update();
            }
            return redirect()->route('user.index')->with('success', 'successfully changed data');   
        } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('error', 'failed changed data');   
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            if($user->avatar_path) Storage::delete($user->avatar_path);
            return redirect()->route('user.index')->with('success', 'successfully deleted data'); 
        } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('error', 'tidak bisa deleted data'); 
        }
    }
}
