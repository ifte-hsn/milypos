@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        <i class="fa fa-exclamation-circle faa-pulse animated"></i>
        <strong>{{ __('general.error') }}: </strong>
        {{ __('general.check_form') }}
    </div>
@endif


@if ($message = Session::get('status'))
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        <i class="fa fa-exclamation-circle faa-pulse animated"></i>
        <strong>{{ __('general.success') }}: </strong>
        {{ $message }}
    </div>
@endif


@if ($message = Session::get('success'))

    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        <i class="fa fa-exclamation-circle faa-pulse animated"></i>
        <strong>{{ __('general.success') }}: </strong>
        {{ $message }}
    </div>

@endif

@if ($message = Session::get('error'))

    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        <i class="fa fa-exclamation-circle faa-pulse animated"></i>
        <strong>{{ __('general.error') }}: </strong>
        {{ $message }}
    </div>

@endif

@if ($message = Session::get('warning'))

    <div class="alert alert-warning alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        <i class="fa fa-exclamation-circle faa-pulse animated"></i>
        <strong>{{ __('general.warning') }}: </strong>
        {{ $message }}
    </div>

@endif

@if ($message = Session::get('info'))

    <div class="alert alert-info alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        <i class="fa fa-exclamation-circle faa-pulse animated"></i>
        <strong>{{ __('general.info') }}: </strong>
        {{ $message }}
    </div>
@endif
