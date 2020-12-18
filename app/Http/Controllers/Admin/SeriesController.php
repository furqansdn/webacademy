<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course\Series;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Resources\SeriesResource;
use App\Http\Requests\Admin\SeriesRequest;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Series::latest()->get();
        return view('admin.series.index',compact('series'));
    }

    public function create()
    {
        $series = new Series();
        return view('admin.series.form',compact('series'));
    }

    public function store(SeriesRequest $request)
    {
        $bannerName = '';

        // Jika request ada banner
        if ($request->hasFile('banner')) {
            $bannerFileName = time().".".$request->banner->getClientOriginalExtension();
            $request->banner->move(public_path("banner"), $bannerFileName);
            $bannerName = '/banner'.'/'. $bannerFileName;
        }
        
        $series = Series::create([
            'title' => $request->title,
            'description' => $request->description,
            'banner' => $bannerName,
        ]);

        return redirect()->back();
    }

    public function edit(Series $series)
    {
        return view('admin.series.form',compact('series'));
    }

    public function update(SeriesRequest $request,Series $series)
    {
        if ($request->hasFile('banner')) {
            if ($series->banner) {
                $file = public_path($series->banner);
                File::delete($file);
            }
            $bannerFileName = time().".".$request->banner->getClientOriginalExtension();
            $request->banner->move(public_path("banner"), $bannerFileName);
            $bannerName = '/banner'.'/'. $bannerFileName;
            $series->banner = $bannerName;
        }

        $series->title = $request->title;
        $series->description = $request->description;
        $series->save();
        return $series;
    }

    public function show(Series $series)
    {
        $series = new SeriesResource($series);
        return view('admin.series.show',compact('series'));
    }

    public function destroy(Series $series)
    {
        $series->delete();
        return $series;
    }
}
