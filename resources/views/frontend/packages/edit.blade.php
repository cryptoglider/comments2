@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.package.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.packages.update", [$package->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="title">{{ trans('cruds.package.fields.title') }}</label>
                            <input class="form-control" type="text" name="title" id="title" value="{{ old('title', $package->title) }}" required>
                            @if($errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.package.fields.title_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="videos">{{ trans('cruds.package.fields.videos') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="videos[]" id="videos" multiple>
                                @foreach($videos as $id => $video)
                                    <option value="{{ $id }}" {{ (in_array($id, old('videos', [])) || $package->videos->contains($id)) ? 'selected' : '' }}>{{ $video }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('videos'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('videos') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.package.fields.videos_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection