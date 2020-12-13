<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $user;
    public $access_options = array(
        'user' => 'Admin User',
        'category' => 'Category',
        'post' => 'Post',
    );
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = $this->user->latest()->where('role', '=', 'admin')->get();
        return view('admin.user.list', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $access_options = $this->access_options;
        return view('admin.user.create', compact('access_options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'unique:users|email',
            'password' => 'required|confirmed|min:7',
            'access' => 'required',
        ];

        $message = ['access.required' => "please select atleast one role",];

        $request->validate($rules, $message);

        $formData = $request->except(['password', 'password_confirmation', 'access', 'is_published',]);

        $formData['password'] = bcrypt($request->password);
        $formData['access_level'] = '';
        $formData['role'] = 'admin';
        $formData['is_published'] = is_null($request->is_published) ? 0 : 1;

        if ($request->access) {
            $accesses = $request->get('access');
            foreach ($accesses as $access) {
                $formData['access_level'] .= ($formData['access_level'] == "" ? "" : ",") . $access;
            }
        }

        $this->user->create($formData);
        return redirect()->route('user.index')->with('message', 'User added successfully.');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $access_options = $this->access_options;

        $detail = $this->user->find($id);
        $oldAccesses = ($detail->access_level) ? explode(",", $detail->access_level) : array();

        return view('admin.user.edit', compact('detail', 'access_options', 'oldAccesses'));
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
        $oldRecord = $this->user->find($id);

        $sameEmailVal = $oldRecord->email == $request->email ? true : false;
        $message = ['access.required' => "please select atleast one role"];

        $request->validate($this->updateRules($oldRecord->id, $sameEmailVal), $message);

        $formData = $request->except(['access', 'password', 'password_confirmation', 'is_published']);

        $formData['access_level'] = '';
        $formData['is_published'] = is_null($request->is_published) ? 0 : 1;
        $formData['role'] = 'admin';
        if ($request->password) {
            $formData['password'] = bcrypt($request->password);
        }

        if ($request->access) {
            $accesses = $request->get('access');
            foreach ($accesses as $access) {
                $formData['access_level'] .= ($formData['access_level'] == "" ? "" : ",") . $access;
            }
        }

        $oldRecord->update($formData);
        return redirect()->route('user.index')->with('message', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->find($id)->delete();
        return redirect()->back()->with('message', 'User Deleted Successfully');
    }
    public function updateRules($oldId = null, $sameEmailVal = false)
    {
        $rules =  [
            'email' => 'unique:users|email',
            'access' => 'required',
            'password' => 'confirmed',
        ];
        if ($sameEmailVal) {
            $rules['email'] = 'unique:users,email,' . $oldId . '|max:255';
        }
        return $rules;
    }
}
