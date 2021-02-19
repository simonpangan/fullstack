<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\UserService;
use Auth;
use Illuminate\Support\Facades\Gate;
class UserController extends Controller
{
    
    private $user; 
  
    public function __construct()
    {
        $this->user = new UserService();
        $this->middleware('admin');
    }

    public function index()
    {
        return User::latest()->paginate(10);
    }
    public function search()
    {
        if ($search = \Request::get('q')) {
            $users = User::where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            })->paginate(10);
        } else {
            return User::latest()->paginate(2);
        };
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            // 'type' => $request['type'],
            // 'bio' => $request['bio'],
            // 'photo' => $request['photo'],
            'password' => 'required|string|min:6',
        ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['name']),
        ]);

    }

    public function profile()
    {
        return Auth::user();
    }

    // public function updateProfile(Request $request)]
 
    public function updateProfile(UpdateProfileRequest $request)
    {     
        $this->user->update($request);
    }   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
            //user with user id is fine to not change the email
            'password' => 'sometimes|min:6',
        ]);

        $user->update($request->all());
        return ['messages' => 'Updated user info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (!Gate::allows('isAdmin')) {
        //     abort(403);
        // }
        $user = User::findOrFail($id);
        $user->delete();
        return ['message' => 'User Deleted'];
    }
}
