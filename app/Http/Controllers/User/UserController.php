<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MultiSections;
use App\Models\Sections;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    function __construct()
    {

        $this->middleware('permission:قائمة المستخدمين', ['only' => ['index']]);
        $this->middleware('permission:إضافة مستخدم', ['only' => ['create','store']]);
        $this->middleware('permission:قائمة المستخدمين', ['only' => ['edit','update']]);
        $this->middleware('permission:قائمة المستخدمين', ['only' => ['destroy']]);

    }

    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->get();
        return view('users.show_users',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $section = Sections::all();
        return view('users.Add_user',compact('roles', 'section'));

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles_name' => 'required',
            'section_name' => 'required'
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user_id = $user->id;
        $user->assignRole($request->input('roles_name'));
        $selectedSections = $request->input('section_name');
        foreach ($selectedSections as $selectedSection) {
            MultiSections::insert([
                'user_id' => $user_id,
                'section_name' => $selectedSection
            ]);
        }
        return redirect()->route('users.index')
            ->with('success','تم اضافة المستخدم بنجاح');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('users.edit',compact('user','roles','userRole'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
            ->with('success','تم تحديث معلومات المستخدم بنجاح');
    }

    public function destroy(Request $request)
    {
        User::find($request->user_id)->delete();
        return redirect()->route('users.index')->with('success','تم حذف المستخدم بنجاح');
    }

}

