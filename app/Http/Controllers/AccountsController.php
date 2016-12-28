<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

use App\Permission;
use App\PermissionRole;
use App\User;
use App\Role;
use App\RoleUser;

class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	\MetaTag::set('title', 'ACCOUNTS &lsaquo; CATALOG Web App');
       	\MetaTag::set('description', 'User Accounts page');

    	return view('accounts');
    }

    // USERS TAB
    public function getUsers(){
        $users = User::select('id as user_id','name','username');
        return \Datatables::of($users)
            ->editColumn('username', '{{$username}} <span style="right: 13px;position: absolute;"><kbd data-id="{{$user_id}}" class="kbd-danger hover delete-user cpointer">DELETE</kbd> <kbd data-id="{{$user_id}}" class="kbd-primary hover edit-user cpointer">EDIT</kbd></span>')
            ->setRowId('user_id')
            ->make(true);
    }

    public function getRoleUser($id){
    	$id = Hashids::decode($id)[0];
        $roleUser = User::find($id)->roles()->orderBy('display_name');
        return \Datatables::of($roleUser)
        	->editColumn('display_name', '{{$display_name}} <span style="right: 13px;position: absolute;"><kbd data-id="{{$role_id}}" class="kbd-danger hover delete-role cpointer">DELETE</kbd></span>')
            ->setRowId('role_id')
        	->make(true);
    }

    public function getNotMyRole($id){
    	$id = Hashids::decode($id)[0];
    	$myRole = RoleUser::select('role_id')
    		->where('user_id', $id)->distinct()->get()->toArray();
        return Role::select('id as role_id', 'display_name')
        	->whereNotIn('id', $myRole)->orderBy('display_name')->get();
    }

    public function submitRoleUser(Request $request){
    	$user_id = Hashids::decode($request->user_id)[0]; 
    	$role_id = $request->role_id;
		$dataSet = [];
		foreach ($role_id as $value) {
			$dataSet[] = [
				'user_id' => $user_id,
				'role_id' => Hashids::decode($value)[0]
			];
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               RoleUser::insert($data);
	            }
        	});
            return \Response::json(true);
		}else{
			RoleUser::insert($dataSet);
			return \Response::json(true);
		}
    }

    // ROLES TAB
    public function getRoles(){
        $roles = Role::select('id as role_id','name','description');
        return \Datatables::of($roles)
            ->editColumn('description', '{{$description}} <span style="right: 13px;position: absolute;"><kbd data-id="{{$role_id}}" class="kbd-danger hover delete-role cpointer">DELETE</kbd> <kbd data-id="{{$role_id}}" class="kbd-primary hover edit-role cpointer">EDIT</kbd></span>')
            ->setRowId('role_id')
            ->make(true);
    }

    public function getPermissionRole($id){
    	$id = Hashids::decode($id)[0];
        $permissionRole = Role::find($id)->permissions()->orderBy('name');
        return \Datatables::of($permissionRole)
        	->editColumn('display_name', '{{$display_name}} <span style="right: 13px;position: absolute;"><kbd data-id="{{$permission_id}}" class="kbd-danger hover delete-role cpointer">DELETE</kbd></span>')
            ->setRowId('permission_id')
        	->make(true);
    }

    public function getNotMyPermission($id){
    	$id = Hashids::decode($id)[0];
    	$myPermission = PermissionRole::select('permission_id')
    		->where('role_id', $id)->distinct()->get()->toArray();
        return Permission::select('id as permission_id', 'display_name')
        	->whereNotIn('id', $myPermission)->orderBy('name')->get();
    }

    public function submitPermissionRole(Request $request){
    	$role_id = Hashids::decode($request->role_id)[0]; 
    	$permission_id = $request->permission_id;
		$dataSet = [];
		foreach ($permission_id as $value) {
			$dataSet[] = [
				'role_id' => $role_id,
				'permission_id' => Hashids::decode($value)[0]
			];
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               PermissionRole::insert($data);
	            }
        	});
            return \Response::json(true);
		}else{
			PermissionRole::insert($dataSet);
			return \Response::json(true);
		}
    }
}
