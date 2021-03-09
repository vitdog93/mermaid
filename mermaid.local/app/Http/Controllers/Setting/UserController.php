<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PHPZen\LaravelRbac\Model\Role;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {
        $model = new User;
        $searchData = $request->searchData;
        if(isset($searchData['name']) && $searchData['name']){
            $model = $model->where(function ($q) use ($searchData){
                $q->where('name', 'LIKE', '%' . $searchData['name'] . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchData['name'] . '%');
            });
        }

        if( isset($searchData['id']) && intval($searchData['id'])){
            $model = $model->where('id', intval($searchData['id']));
        }
        if( isset($searchData['state']) && intval($searchData['state'])){
            $model = $model->where('state', intval($searchData['state']));
        }

        $limit = config('constants.item_per_page');
        $itemList = $model->orderBy('id', 'DESC')->paginate($limit);

        $userIds = [];
        foreach ($itemList as $key => $item) {
            $userIds[] = $item->created_by;
        }

        $user2Id = [];
        if ($userIds) {
            $userList =User::whereIn('id', $userIds)->get();
            foreach ($userList as $key => $user) {
                $user2Id[$user->id] = $user;
            }
        }

        $roleList = Role::get();

        return view('modules.setting.user.index', [
            'searchData' => $searchData,
            'itemList' => $itemList,
            'user2Id' => $user2Id,
            'roleList' => $roleList
        ]);
    }


}
