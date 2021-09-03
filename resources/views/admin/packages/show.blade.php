@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.package.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.packages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.package.fields.id') }}
                        </th>
                        <td>
                            {{ $package->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.package.fields.title') }}
                        </th>
                        <td>
                            {{ $package->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.package.fields.videos') }}
                        </th>
                        <td>
                            @foreach($package->videos as $key => $videos)
                                <span class="label label-info">{{ $videos->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.packages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection