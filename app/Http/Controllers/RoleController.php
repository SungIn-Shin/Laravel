<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Permission;
use Entrust;
use Illuminate\Http\Request;
use App\Http\Requests\RoleFormRequest;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

 
    public function create()
    {
        //
    }


    public function store(RoleFormRequest $request)
    {
        //       
        $role = new Role;
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();
        return redirect()->route('role.list');
    }

    public function attachRole($user_id)
    {
        dump($user_id);
        //
        $user = User::where('name', '=', '신성인')->first();
        dump($user);        
        $user->attachRole(13); // parameter can be an Role object, array, or id        

        // or eloquent's original technique
        // $user->roles()->attach($admin->id); // id only
    }

    public function createPermission() {
        $createPost = new Permission();
        $createPost->name         = 'create-post';
        $createPost->display_name = 'Create Posts'; // optional
        // Allow a user to...
        $createPost->description  = 'create new blog posts'; // optional
        $createPost->save();

        $editUser = new Permission();
        $editUser->name         = 'edit-user';
        $editUser->display_name = 'Edit Users'; // optional
        // Allow a user to...
        $editUser->description  = 'edit existing users'; // optional
        $editUser->save();
    }

    public function attachPermission($user_id) {

    }

   
    public function showList(Role $role)
    {
        //        
        // dump(Auth::user()->hasRole('admin'));
        dump(Entrust::hasRole('admin'));
        if(!Entrust::hasRole('admin')) {
            abort(403, '권한없음');            
        }
        $roles = Role::paginate(10);
        return view('role.role_list')->with('roles', $roles);
    }
 
    public function edit(Role $role)
    {
        //
    }

  
    public function update(Request $request, Role $role)
    {
        //
    }

 
    public function destroy(Role $role)
    {
        //
    }
}
