<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPackageRequest;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Models\Package;
use App\Models\Video;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PackagesController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('package_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packages = Package::with(['videos'])->get();

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        abort_if(Gate::denies('package_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videos = Video::pluck('title', 'id');

        return view('admin.packages.create', compact('videos'));
    }

    public function store(StorePackageRequest $request)
    {
        $package = Package::create($request->all());
        $package->videos()->sync($request->input('videos', []));

        return redirect()->route('admin.packages.index');
    }

    public function edit(Package $package)
    {
        abort_if(Gate::denies('package_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videos = Video::pluck('title', 'id');

        $package->load('videos');

        return view('admin.packages.edit', compact('videos', 'package'));
    }

    public function update(UpdatePackageRequest $request, Package $package)
    {
        $package->update($request->all());
        $package->videos()->sync($request->input('videos', []));

        return redirect()->route('admin.packages.index');
    }

    public function show(Package $package)
    {
        abort_if(Gate::denies('package_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $package->load('videos');

        return view('admin.packages.show', compact('package'));
    }

    public function destroy(Package $package)
    {
        abort_if(Gate::denies('package_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $package->delete();

        return back();
    }

    public function massDestroy(MassDestroyPackageRequest $request)
    {
        Package::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
