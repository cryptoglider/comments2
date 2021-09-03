@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.comment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.comments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.comment.fields.id') }}
                        </th>
                        <td>
                            {{ $comment->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.comment.fields.text') }}
                        </th>
                        <td>
                            {{ $comment->text }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.comment.fields.video') }}
                        </th>
                        <td>
                            {{ $comment->video->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.comment.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Comment::STATUS_SELECT[$comment->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.comment.fields.user_email') }}
                        </th>
                        <td>
                            {{ $comment->user_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.comment.fields.answer') }}
                        </th>
                        <td>
                            {{ $comment->answer->text ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.comments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#answer_comments" role="tab" data-toggle="tab">
                {{ trans('cruds.comment.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="answer_comments">
            @includeIf('admin.comments.relationships.answerComments', ['comments' => $comment->answerComments])
        </div>
    </div>
</div>

@endsection