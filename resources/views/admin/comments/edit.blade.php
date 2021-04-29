@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.comment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.comments.update", [$comment->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="text">{{ trans('cruds.comment.fields.text') }}</label>
                <textarea class="form-control {{ $errors->has('text') ? 'is-invalid' : '' }}" name="text" id="text" required>{{ old('text', $comment->text) }}</textarea>
                @if($errors->has('text'))
                    <div class="invalid-feedback">
                        {{ $errors->first('text') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.comment.fields.text_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="video_id">{{ trans('cruds.comment.fields.video') }}</label>
                <select class="form-control select2 {{ $errors->has('video') ? 'is-invalid' : '' }}" name="video_id" id="video_id" required>
                    @foreach($videos as $id => $entry)
                        <option value="{{ $id }}" {{ (old('video_id') ? old('video_id') : $comment->video->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('video'))
                    <div class="invalid-feedback">
                        {{ $errors->first('video') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.comment.fields.video_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.comment.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Comment::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $comment->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.comment.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_email">{{ trans('cruds.comment.fields.user_email') }}</label>
                <input class="form-control {{ $errors->has('user_email') ? 'is-invalid' : '' }}" type="email" name="user_email" id="user_email" value="{{ old('user_email', $comment->user_email) }}">
                @if($errors->has('user_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.comment.fields.user_email_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection