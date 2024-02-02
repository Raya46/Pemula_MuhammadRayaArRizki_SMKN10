<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();

        return view('admin.role', compact('roles'));
    }

    public function store(Request $request){
        Role::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function putRole(Request $request, $id){
        $role = Role::find($id);

        $role->update([
            'name' => $request->name 
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function destroy($id){
        $role = Role::find($id);

        $role->delete();

        return redirect()->back()->with('status', 'success');
    }

}
