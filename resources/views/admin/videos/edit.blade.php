@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.video.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.videos.update", [$video->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.video.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $video->title) }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.video.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="link">{{ trans('cruds.video.fields.link') }}</label>
                <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" type="text" name="link" id="link" value="{{ old('link', $video->link) }}">
                @if($errors->has('link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.video.fields.link_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.video.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
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
                <label for="doc">{{ trans('cruds.video.fields.doc') }}</label>
                <div class="needsclick dropzone {{ $errors->has('doc') ? 'is-invalid' : '' }}" id="doc-dropzone">
                </div>
                @if($errors->has('doc'))
                    <div class="invalid-feedback">
                        {{ $errors->first('doc') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.video.fields.doc_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="start_comments">{{ trans('cruds.video.fields.start_comments') }}</label>
                <input class="form-control {{ $errors->has('start_comments') ? 'is-invalid' : '' }}" type="number" name="start_comments" id="start_comments" value="{{ old('start_comments', $video->start_comments) }}" step="1">
                @if($errors->has('start_comments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_comments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.video.fields.start_comments_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.docDropzone = {
    url: '{{ route('admin.videos.storeMedia') }}',
    maxFilesize: 10, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10
    },
    success: function (file, response) {
      $('form').find('input[name="doc"]').remove()
      $('form').append('<input type="hidden" name="doc" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="doc"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($video) && $video->doc)
      var file = {!! json_encode($video->doc) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="doc" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection