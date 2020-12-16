<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Services\ImageCropService;
use App\Services\ImageProcessingService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $model = null;
    protected $categories = null;
    protected $imageProcessingService = null;
    protected $imageCropService = null;

    public function __construct(Post $model, Category $categories, ImageProcessingService $imageProcessingService, ImageCropService $imageCropService)
    {
        $this->model = $model;
        $this->categories = $categories;
        $this->imageProcessingService = $imageProcessingService;
        $this->imageCropService = $imageCropService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas['details'] = $this->model->latest()->get();
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
            // 'title' => 'required',
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
        $oldRecord = $this->model->findOrFail($id);
        if ($oldRecord->image) {
            $this->imageProcessingService->unlinkImage($oldRecord->image);
        }
        $oldRecord->delete();
        return redirect()->back()->with('message', 'post deleted successfully');
    }

    public function imageProcess(Request $request)
    {
        $message = ['filename.dimensions' => 'image must be less than 2900*2000'];
        $validator = \Validator::make($request->all(), [
            'filename' => 'dimensions:max_width=2500,max_height=1800',
        ], $message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $detail = $this->imageCropService->imageProcess($request->filename);
        return response()->json($detail);
    }

    public function imageCropModal(Request $request)
    {
        return view('admin.post.jcrop')->with('image', $request->name);
    }
    public function imageCropProcess(Request $request)
    {
        $coordinates =  [$request->x, $request->y, $request->w, $request->h];
        $finalImage = $this->imageCropService->cropProcess($request->image, $coordinates);
        return $finalImage;
    }
    public function updatePostWithImage(Request $request, $id)
    {
        $oldRecord = $this->model->findOrFail($id);
        if ($oldRecord->image) {
            $this->imageProcessingService->unlinkImage($oldRecord->image);
        }
        $formData = $request->except(['is_published']);
        $formData['is_published']  = is_null($request->is_published) ? 0 : 1;
        $oldRecord->update($formData);
        return redirect()->route('post.index')->with('message', 'post updated successFully');
    }
}
