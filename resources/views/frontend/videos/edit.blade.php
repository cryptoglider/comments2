@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.video.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.videos.update", [$video->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="title">{{ trans('cruds.video.fields.title') }}</label>
                            <input class="form-control" type="text" name="title" id="title" value="{{ old('title', $video->title) }}" required>
                            @if($errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.video.fields.title_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="link">{{ trans('cruds.video.fields.link') }}</label>
                            <input class="form-control" type="text" name="link" id="link" value="{{ old('link', $video->link) }}" required>
                            @if($errors->has('link'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('link') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.video.fields.link_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.video.fields.status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Video::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', $video->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.video.fields.status_helper') }}</span>
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