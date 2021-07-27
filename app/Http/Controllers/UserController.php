<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\PaymentRequest;
use App\Models\Receipt;
use App\Models\Category;

class UserController extends Controller
{
    protected $categories;

    public function __construct()
    {
        $this->categories = Category::with('categories')
            ->where('parent_id', '=', config('uploads.category_root'))
            ->get();
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
        $user = User::findOrFail($id);
        $check = false;
        $follow = false;
        $categories = $this->categories;
        if (Auth::check() && Auth::id() == $user->id) {
            $check = true;
        } elseif (Auth::user()->followings->contains($user)) {
            $follow = true;
        }

        return view('user.profile', compact('user', 'check', 'follow', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $categories = $this->categories;
        if ($this->authorize('update', $user)) {
            return view('user.edit-profile', compact('user', 'categories'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if ($this->authorize('update', $user)) {
            $user->update($request->all());
            $avatar = $request->avatar;
            if (isset($avatar)) {
                $url = cloudinary()->upload($avatar->getRealPath())->getSecurePath();
                $user->update([
                    'image' => $url
                ]);
            }

            return redirect()->route('users.show', ['user' => $user->id]);
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

    public function follow($id)
    {
        $user = User::findOrFail($id);
        if ($this->authorize('follow', $user)) {
            $userLogin = Auth::user();
            $userLogin->followings()->attach($user->id);

            return redirect()->route('users.show', ['user' => $user->id]);
        }
    }

    public function unfollow($id)
    {
        $user = User::findOrFail($id);
        if ($this->authorize('follow', $user)) {
            $userLogin = Auth::user();
            $userLogin->followings()->detach($user->id);

            return redirect()->route('users.show', ['user' => $user->id]);
        }
    }

    public function buyCoin()
    {
        $categories = $this->categories;

        return view('user.buy-coin', compact('categories'));
    }

    public function payment(PaymentRequest $request)
    {
        $value = $request->value;
        $quantity = $request->quantity;
        $user = Auth::user();
        $user->update([
            'coin' => $user->coin + $value * $quantity
        ]);
        Receipt::create([
            'value' => $value,
            'quantity' => $quantity,
            'user_id' => $user->id,
        ]);

        return redirect()->route('users.show', ['user' => $user->id]);
    }
}
