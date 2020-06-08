<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Session;

class PermissionController extends Controller
{
    public function index()
    {

        $permissions = Permission::all();

        return view('permissions.index')->with('permissions', $permissions);
    }

    public function create()
    {
        $roles = Role::get();

        return view('permissions.create')->with('roles', $roles);
    }

    public function getName()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:40',
        ]);
        $name = $request['name'];
        if (Permission::where('name', '=', $name)->first()) {
            return redirect()->route('permissions.index')
                ->with('flash_message',
                    '权限 ' . $name . ' 已经存在，请先删除再添加！');
        }
        $permission       = new Permission();
        $permission->name = $name;
        $roles            = $request['roles'];

        $permission->save();

        if (!empty($request['roles'])) { //If one or more role is selected
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record

                $permission = Permission::where('name', '=', $name)->first(); //Match input //permission to db record
                $r->givePermissionTo($permission);
            }
        }

        return redirect()->route('permissions.index')
            ->with('flash_message',
                '新增权限 ' . $name . ' 成功！');


    }

    public function show($id)
    {
        return redirect('permissions');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:40',
        ]);
        $input = $request->all();
        $permission->fill($input)->save();

        return redirect()->route('permissions.index')
            ->with('flash_message',
                'Permission' . $permission->name . ' updated!');

    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        //Make it impossible to delete this specific permission
        if ($permission->name == "Administer roles & permissions") {
            return redirect()->route('permissions.index')
                ->with('flash_message',
                    'Cannot delete this Permission!');
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('flash_message',
                'Permission deleted!');

    }
}