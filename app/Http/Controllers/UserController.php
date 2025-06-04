<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function exportExcel() 
     {
         return Excel::download(new UserExport, 'rekap-akun.xlsx');
     }
 

    public function index(Request $request)
    {
        //
        $sortingmantep = $request->sorting_stock ? 'stock' : 'name';
        $user = User::where ('name', 'LIKE' , '%' . $request->search_name . '%')->orderBy($sortingmantep , 'ASC')->orderBy('name' , 'ASC')->SimplePaginate(8);
        return view('User.show', compact('user'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('User.usercreate');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required',
        ],[
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
            'role.required' => 'Role is required',
        ]
        );


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
            'role' => $request->role,
        ]);

        return redirect()->route('user.index')->with('success','User ' .  $request->name .  ' successfull being added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = User::all();

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::where('id', $id)->first();
        return view('User.edit', compact('user'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);

        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->route('user.index')->with('success','User ' .  ' succesfull being update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $deleteData = User::where('id', $id)->delete();
        if($deleteData){
            return redirect()->back()->with('success', 'User' . ' Already be deleted');
        } else {
            return redirect()->back()->with('error', 'User ' . ' Eror deleting');
        }
    }

public function ShowLogin()
{
    return view('pages.login');
}

public function loginAuth(Request $request)
{
    $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);

    $users = $request->only('email', 'password');
    if (Auth::attempt($users)) {
        return redirect()->route('landing_page');
    } else {
        return redirect()->route('login')->with('error', 'Invalid username or password');
    }

}
public function logout()
{
    Auth::logout();
    return redirect()->route('login')->with('logout', 'Logout successfully');
}
}
