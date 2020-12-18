<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Services\ImageProcessingService;
use App\Services\MultipleImageCropService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    protected $model = null;
    protected $galleryImage = null;
    protected $multipleImageCropService = null;
    protected $imageProcessingService = null;

    public function __construct(Gallery $model, GalleryImage $galleryImage, ImageProcessingService $imageProcessingService, MultipleImageCropService $multipleImageCropService)
    {
        $this->model = $model;
        $this->galleryImage = $galleryImage;
        $this->imageProcessingService = $imageProcessingService;
        $this->multipleImageCropService = $multipleImageCropService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas['details'] = $this->model->latest()->get();
        return view('admin.gallery.list', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());
        $formData = $request->except(['is_published']);

        $this->validate($request, $this->rules());
        $formData = $request->except(['publish', 'filename', 'caption', 'list_image', 'image']);

        if (isset($request->list_image)) {
            $formData['list_image'] = $this->imageProcessingService->imageProcessing($request->file('list_image'), 615, 403, 'yes');
        }

        $formData['is_published']  = is_null($request->is_published) ? 0 : 1;
        $detail = $this->model->create($formData);
        if ($request->has('filename')) {
            $this->saveImage($detail->id, $request->filename, $request->caption);
        }
        return redirect()->route('gallery.index')->with('message', 'gallery added successfully');
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
        return view('admin.gallery.edit', $datas);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $galleryImages = $this->galleryImage->where('gallery_id', $id)->get();
        foreach ($galleryImages as $value) {
            if ($value['filename']) {
                $this->imageProcessingService->unlinkImage($value['filename']);
            }
        }
        $oldRecord = $this->model->find($id);
        if ($oldRecord->list_image) {
            $this->imageProcessingService->unlinkImage($oldRecord->list_image);
        }
        $oldRecord->delete();

        return redirect()->route('gallery.index')->with('message', 'gallery deleted successfully');
    }

    public function galleryImage(Request $request)
    {
        $details = $this->multipleImageCropService->galleryImage($request->file('image'));
        return response()->json([
            'html' => view('admin.gallery.card-with-photo', compact('details'))->render(),
        ]);
    }
    public function crop(Request $request)
    {
        return view('admin.gallery.jcrop')->with('image', $request->name)->with('index', $request->index);
    }
    public function jcropProcess(Request $request)
    {
        $coordinates =  [$request->x, $request->y, $request->w, $request->h];
        $finalImage = $this->multipleImageCropService->jcropProcess($request->image, $coordinates);
        return $finalImage;
    }

    public function saveImage($galleryId, $filename, $caption)
    {
        for ($i = 0; $i < count($filename); $i++) {
            $formData = [
                'gallery_id' => $galleryId,
                'filename' => $filename[$i],
                'caption' => $caption[$i],
            ];
            $this->galleryImage->create($formData);
        }
    }

    public function updateImage($id, $filename, $caption)
    {
        $this->galleryImage->where('gallery_id', $id)->delete();

        for ($i = 0; $i < count($filename); $i++) {
            $formData = [
                'gallery_id' => $id,
                'filename' => $filename[$i],
                'caption' => $caption[$i]
            ];
            $this->galleryImage->create($formData);
        }
    }

    public function galleryUpdateWithImage(Request $request, $id)
    {
        $oldRecord = $this->model->findOrFail($id);

        $sameSlugVal = $oldRecord->slug == $request->slug ? true : false;
        $request->validate($this->rules($oldRecord->id, $sameSlugVal));

        $formData = $request->except(['is_published', 'filename', 'caption', 'list_image']);

        $formData['is_published'] = is_null($request->is_published) ? 0 : 1;

        if ($request->has('list_image')) {
            if ($oldRecord->list_image) {
                $this->imageProcessingService->unlinkImage($oldRecord->list_image);
            }
            $formData['list_image'] = $this->imageProcessingService->imageProcessing($request->file('list_image'), 615, 403, 'yes');
        }

        $oldRecord->update($formData);

        if ($request->filename) {
            $this->updateImage($id, $request->filename, $request->caption);
        }

        return redirect()->route('gallery.index')->with('message', 'gallery updated successfully');
    }

    public function removeImage(Request $request)
    {
        $name = $request->name;
        $this->multipleImageCropService->removeImage($name);
        $this->galleryImage->where('filename', $name)->delete();
        return;
    }

    public function rules($oldId = null, $sameSlugVal = false)
    {
        $rules =  [
            'title' => 'required',
            'slug' => 'unique:galleries|max:255',
        ];
        if ($sameSlugVal) {
            $rules['slug'] = 'unique:galleries,slug,' . $oldId . '|max:255';
        }
        return $rules;
    }
}
