<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    <label for="image" class="control-label col-md-3 col-sm-3 col-xs-12">
        {{ __('general.upload_image') }}
    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
    <div class="col-md-6 col-sm-6 col-xs-12">
        <label class="btn btn-default">
            {{ __('button.upload') }}
            <input type="file" name="image" id="uploadFile" data-maxsize="{{ \App\Helpers\Helper::file_upload_max_size() }}" accept="image/gif, image/jpeg, image/png, image/svg" style="display: none;">
        </label>
        <span class='label label-default' id="upload-file-info"></span>

        <p class="help-block" id="upload-file-status">{{ __('general.image_filetypes_help', ['size' => \App\Helpers\Helper::file_upload_max_size_readable()]) }}</p>
        {!! $errors->first('image', '<span class="alert-msg">:message</span>') !!}
    </div><!-- .col-md-6 .col-sm-6 .col-xs-12 -->
    <div class="col-md-4 col-md-offset-3">
        <img id="imagePreview" style="max-width: 200px;">
    </div>
</div><!-- form-group -->
