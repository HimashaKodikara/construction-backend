<?php

namespace App\Http\Controllers\admin;

use App\Models\Service;
use App\Models\TempImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::orderBy('created_at','DESC')->get();
        return response()->json([
            'status' => true,
            'data'=>$services
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(),[
        'title' => 'required',
        'slug'=> 'required|unique:services,slug'
      ]);
      if($validator->fails()){
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
      }
     $model = new Service();
        $model->title = $request->title;
        $model->short_desc = $request->short_desc;
        $model->slug = Str::slug($request->slug);
        $model->content = $request->content;
        $model->status = $request->status;
        $model->save();


         //Save Temp Image
         if($request->imageId >0){
            $tempImage = TempImage::find($request->imageId);

            if($tempImage != null){
              $extArray = explode('.',$tempImage->name);
              $ext = last($extArray);

              $fileName = strtotime('now').$model->id.'.'.$ext;

               //Create small thumbnail here
                $sourcePath = public_path('uploads/temp/'.$tempImage->name);
                $destPath = public_path('uploads/services/small/'.$fileName);
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($sourcePath);
                $image->coverDown(500,600);
                $image->save($destPath);

                 //Create large thumbnail here
                 $destPath = public_path('uploads/services/large/'.$fileName);
                 $manager = new ImageManager(Driver::class);
                 $image = $manager->read($sourcePath);
                 $image->scaleDown(1200);
                 $image->save($destPath);

                 $model->image = $fileName;
                 $model->save();




            }
        }

      return response()->json([
        'status' => true,
        'message' => 'Service added successfully'
    ]);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

       $service = Service:: find($id);

       if($service == null){
        return response()->json([
            'status' => false,
            'message' => 'Service not found'
        ]);
       }

       return response()->json([
       'status' => true,
       'data' => $service,
       ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        if ($service == null) {
            return response()->json([
                'status' => false,
                'message' => 'Service not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:services,slug,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $service->title = $request->title;
        $service->short_desc = $request->short_desc;
        $service->slug = Str::slug($request->slug);
        $service->content = $request->content;
        $service->status = $request->status;
        $service->save();


        //Save Temp Image
        if($request->imageId >0){

            $oldImage = $service->image;
            $tempImage = TempImage::find($request->imageId);

            if($tempImage != null){
              $extArray = explode('.',$tempImage->name);
              $ext = last($extArray);

              $fileName = strtotime('now').$service->id.'.'.$ext;

               //Create small thumbnail here
                $sourcePath = public_path('uploads/temp/'.$tempImage->name);
                $destPath = public_path('uploads/services/small/'.$fileName);
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($sourcePath);
                $image->coverDown(500,600);
                $image->save($destPath);

                 //Create large thumbnail here
                 $destPath = public_path('uploads/services/large/'.$fileName);
                 $manager = new ImageManager(Driver::class);
                 $image = $manager->read($sourcePath);
                 $image->scaleDown(1200);
                 $image->save($destPath);

                 $service->image = $fileName;
                 $service->save();

                 if($oldImage != ''){
                    File::delete(public_path('uploads/services/large/'.$oldImage));
                    File::delete(public_path('uploads/services/small/'.$oldImage));
                 }


            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Service updated successfully'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Service::find($id);

        if ($service == null) {
            return response()->json([
                'status' => false,
                'message' => 'Service not found'
            ]);
        }


        File::delete(public_path('uploads/services/large/'.$service->image));
        File::delete(public_path('uploads/services/small/'.$service->image));

        $service->delete();

        return response()->json([
            'status' => true,
            'message' => 'Service deleted successfully'
        ]);
    }
}
