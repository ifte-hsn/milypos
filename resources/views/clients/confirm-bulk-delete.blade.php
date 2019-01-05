@extends('layouts.default')
@section('title')
    {{ __('general.bulk_checkin_and_delete') }}
    @parent
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li><a href="{{ route('clients.index') }}"><i class="fa fa-th"></i> {{ __('general.clients') }}</a></li>
    <li class="active">{{ __('general.bulk_checkin_and_delete') }}</li>
@endsection

@section('content')
    <div class="box box-danger">
        <form action="{{ route('clients.bulkSave') }}" class="form-horizontal" method="POST" id="bulkForm">
            <div class="box-body">

                @csrf
                <div class="callout callout-danger">
                    <i class="fa fa-exclamation-circle"></i>
                    <strong>{{ __('general.warning') }}: </strong>
                    {{ __('clients/message.bulk_delete_warning', ['count' => count($clients) ]) }}
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>{{ __('general.image') }}</th>
                                    <th>{{ __('general.id') }}</th>
                                    <th>{{ __('general.name') }}</th>
                                    <th>{{ __('general.email_address') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="ids[]" value="{{ $client->id }}" checked>
                                        </td>
                                        <td>
                                            @if($client->image)
                                                <a href="{{ url('/') }}/uploads/avatars/{{ $client->image }}" data-toggle="lightbox" data-type="image">
                                                    <img src="{{ url('/') }}/uploads/avatars/{{ $client->image }}" alt="{{ $client->name }}" style="max-height: 50px; width: auto;" class="img-responsive">
                                                </a>
                                            @else
                                                <a href="{{ url('/').'/images/avatar_placeholder.png' }}" data-toggle="lightbox" data-type="image">
                                                    <img src="{{ url('/').'/images/avatar_placeholder.png' }}" alt="{{ $client->name }}" style="max-height: 50px; width: auto;" class="img-responsive">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $client->id }}
                                        </td>
                                        <td>
                                            {{ $client->fullName }}
                                        </td>
                                        <td>
                                            {{ $client->email }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div><!-- table-responsive -->
                    </div><!-- col-md-12 -->
                </div><!-- .row -->
            </div><!-- box-body -->
            <div class="box-footer text-right">
                <a class="btn btn-link" href="{{ URL::previous() }}">{{ __('general.cancel') }}</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.submit') }}</button>
            </div><!-- box-footer text-right -->
        </form>
    </div><!-- .box -->
@endsection
