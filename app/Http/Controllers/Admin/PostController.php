<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $model = null;
    protected $categories = null;
    public function __construct(Post $model, Category $categories)
    {
        $this->model = $model;
        $this->categories = $categories;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas['details'] = $this->model->get();
        return view('admin.post.list', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['categories'] = $this->categories->get();
        return view('admin.post.create', $datas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $formData = $request->except(['is_published']);
        $formData['is_published']  = is_null($request->is_published) ? 0 : 1;
        $this->model->create($formData);
        return redirect()->route('post.index')->with('message', 'post added successfully');
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
        $datas['detail'] = $this->model->findOrFail($id);
        $datas['categories'] = $this->categories->get();
        return view('admin.post.edit', $datas);
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
        $oldRecord = $this->model->findOrFail($id);
        $formData = $request->except(['is_published']);
        $formData['is_published']  = is_null($request->is_published) ? 0 : 1;
        $oldRecord->update($formData);
        return redirect()->route('post.index')->with('message', 'post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
