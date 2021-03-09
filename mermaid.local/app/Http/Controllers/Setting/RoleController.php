<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Mysql\Permission;
use App\Models\Mysql\PermissionRole;
use App\Models\Mysql\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $model = new Role;
        $searchData = $request->searchData;
        if (isset($searchData['name']) && $searchData['name']) {
            $model = $model->where(function($q) use ($searchData) {
                $q->where('name', 'LIKE', '%' . $searchData['name'] . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchData['name'] . '%');
            });
        }

        if (isset($searchData['id']) && intval($searchData['id'])) {
            $model = $model->where('id', intval($searchData['id']));
        }

        $limit = config('constants.item_per_page');
        $itemList = $model->orderBy('id', 'DESC')->paginate($limit);

        $userIds = [];
        foreach ($itemList as $key => $item) {
            $userIds[] = $item->created_by;
        }

        $user2Id = [];
        if ($userIds) {
            $userList = User::whereIn('id', $userIds)->get();
            foreach ($userList as $key => $user) {
                $user2Id[$user->id] = $user;
            }
        }

        $permissionList = Permission::orderBy('slug', 'ASC')->orderBy('id', 'ASC')->get();

        return view('modules.setting.role.index', [
            'searchData' => $searchData,
            'itemList' => $itemList,
            'user2Id' => $user2Id,
            'permissionList' => $permissionList
        ]);
    }

    public function detail($id)
    {
        if (!intval($id)) {
            return response()->json([
                'message' => 'Phân quyền không xác định!'
            ], 400);
        }

        $model = Role::find(intval($id));
        if (!$model) {
            return response()->json([
                'message' => 'Phân quyền không tồn tại!'
            ], 404);
        }

        return response()->json([
            'item' => $model
        ], 200);
    }

    public function create(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'name' => 'required',
            'slug' => [
                'required',
                Rule::unique('roles'),
            ],
        ], [
            'name.required' => 'Tên phân quyền không xác định!',
            'slug.required' => 'Khóa chỉ mục không xác định!',
            'slug.unique' => 'Khóa chỉ mục đã tồn tại!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 406);
        }

        $requestData['created_by'] = auth()->user()->id;
        dd($requestData);
        DB::beginTransaction();
        try {
            $model = Role::create($requestData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Lỗi server. Vui lòng thử lại sau!'
            ], 500);
        }

        $request->session()->put('success', 'Thêm mới phân quyền thành công!');
        return response()->json([
            'message' => 'Thêm mới phân quyền thành công!'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $model = Role::find(intval($id));
        if (!$model) {
            return response()->json([
                'message' => 'Phân quyền không tồn tại!'
            ], 404);
        }

        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'name' => 'required',
            'slug' => [
                'required',
                Rule::unique('roles')->ignore($model->id),
            ],
        ], [
            'name.required' => 'Tên phân quyền không xác định!',
            'slug.required' => 'Khóa chỉ mục không xác định!',
            'slug.unique' => 'Khóa chỉ mục đã tồn tại!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 406);
        }

        $requestData['updated_by'] = auth()->user()->id;
        DB::beginTransaction();
        try {
            $model->update($requestData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Lỗi server. Vui lòng thử lại sau!'
            ], 500);
        }

        $request->session()->put('success', 'Cập nhật phân quyền thành công!');
        return response()->json([
            'message' => 'Cập nhật phân quyền thành công!'
        ], 200);
    }

    public function permission($id)
    {
        if (!intval($id)) {
            return response()->json([
                'message' => 'Phân quyền không xác định!'
            ], 400);
        }

        $model = Role::find(intval($id));
        if (!$model) {
            return response()->json([
                'message' => 'Phân quyền không tồn tại!'
            ], 404);
        }

        $permissionRole = PermissionRole::where('role_id', $model->id)->pluck('permission_id');

        return response()->json([
            'item' => $model,
            'permissions' => $permissionRole
        ], 200);
    }

    public function syncPermission(Request $request, $id)
    {
        if (!intval($id)) {
            return response()->json([
                'message' => 'Phân quyền không xác định!'
            ], 400);
        }

        $model = Role::find(intval($id));
        if (!$model) {
            return response()->json([
                'message' => 'Phân quyền không tồn tại!'
            ], 404);
        }

        $permissionSync = [];
        if ($request->permissions && is_array($request->permissions)) {
            $permissionSync = Permission::whereIn('id', $request->permissions)->pluck('id');
        }

        $model->permissions()->sync($permissionSync);

        return response()->json([
            'item' => $model,
            'message' => 'Cập nhật tính năng cho phân quyền thành công.'
        ], 200);
    }
}
