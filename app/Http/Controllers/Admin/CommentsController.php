<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCommentRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Video;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('comment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $comments = Comment::with(['video', 'answer'])->get();

        return view('admin.comments.index', compact('comments'));
    }

    public function create()
    {
        abort_if(Gate::denies('comment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videos = Video::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $answers = Comment::all()->pluck('text', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.comments.create', compact('videos', 'answers'));
    }

    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->all());

        return redirect()->route('admin.comments.index');
    }

    public function edit(Comment $comment)
    {
        abort_if(Gate::denies('comment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videos = Video::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $answers = Comment::all()->pluck('text', 'id')->prepend(trans('global.pleaseSelect'), '');

        $comment->load('video', 'answer');

        return view('admin.comments.edit', compact('videos', 'answers', 'comment'));
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->all());

        return redirect()->route('admin.comments.index');
    }

    public function show(Comment $comment)
    {
        abort_if(Gate::denies('comment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $comment->load('video', 'answer', 'answerComments');

        return view('admin.comments.show', compact('comment'));
    }

    public function destroy(Comment $comment)
    {
        abort_if(Gate::denies('comment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $comment->delete();

        return back();
    }

    public function massDestroy(MassDestroyCommentRequest $request)
    {
        Comment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
