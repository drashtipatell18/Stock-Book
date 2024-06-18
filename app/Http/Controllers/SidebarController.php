<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleSiderBarJoin;
use App\Models\SideBarMenu;
use Illuminate\Http\Request;

class SidebarController extends Controller
{
    private function getSideMenu()
    {
        return SideBarMenu::all();
    }
    public function index()
    {
        $siderbars = $this->getSideMenu();
        return view('sidebar.index', compact('siderbars'));
    }
    public function create()
    {
        return view('sidebar.create');
    }
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'class' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'route' => 'required|string|max:255'
        ]);
        
        $sidebarMenu = SideBarMenu::create([
            'name' => $request->input('class'),
            'display_name' => $request->input('display_name'),
            'route' => $request->input('route'),
        ]);

        $sidebarId = $sidebarMenu->id;

        RoleSiderBarJoin::create([
            'role_id' => 1,
            'siderbar_id' => $sidebarId,
            'permission' => true
        ]);

        $siderbars = $this->getSideMenu();
        session()->flash('success', 'Sidebar inserted successfully');
        return view('sidebar.index', compact('siderbars'));
    }
    public function delete($id)
    {
        $join = RoleSiderBarJoin::where('sidebar_id', $id)->get();
        foreach ($join as $j) {
            $j->delete();
        }
        $sidebar = SideBarMenu::find($id);
        $sidebar->delete();

        $siderbars = $this->getSideMenu();
        session()->flash('success', 'Sidebar Deleted successfully');
        return view('sidebar.index', compact('siderbars'));
    }
    public function edit($id)
    {
        $sidebar = SideBarMenu::find($id);
        return view('sidebar.create', compact('sidebar'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'class' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'route' => 'required|string|max:255'
        ]);

        $sidebar = SideBarMenu::find($id);
        $sidebar->name = $request->input('class');
        $sidebar->display_name = $request->input('display_name');
        $sidebar->route = $request->input('route');

        $sidebar->save();

        $siderbars = $this->getSideMenu();
        session()->flash('success', 'Sidebar Updated successfully');
        return view('sidebar.index', compact('siderbars'));
    }

    public function role_for_sidebar()
    {
        $sidemenus = SideBarMenu::all();
        $roles = Role::all();

        $returnData = ["roles" => $roles, "sidemenus" => $sidemenus];

        return view('sidebar.rolemanagement', compact('returnData'));
    }

    public function getPermission($id)
    {
        $permission = RoleSiderBarJoin::where('role_id', $id)->get();
        return response()->json($permission, 200);
    }

    public function roleUpdate(Request $request)
    {
        $temp = RoleSiderBarJoin::where('role_id', $request->role_id)->get();
        foreach ($temp as $role) {
            $role->delete();
        }

        foreach ($request->data as $value) {
            RoleSiderBarJoin::create([
                'role_id' => $request->role_id,
                'siderbar_id' => $value['sidebar_id'],
                'permission' => (($value['permission'] == "true")?1:0)
            ]);
        }
        return response()->json(["success" => true]);
    }
}
