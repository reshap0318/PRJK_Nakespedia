<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::getUser();
        return view('pages.profile.index', [
            'user' => $user,
            'img'  => $user->avatar_path ? $user->avatar_url : asset('template/assets/media/svg/files/blank-image.svg')
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
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
            return redirect()->route('home')->with('success', 'berhasil mengubah data');   
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('error', 'gagal mengubah data');   
        }
    }
}
