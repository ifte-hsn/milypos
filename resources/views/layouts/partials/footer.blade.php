<footer class="main-footer hidden-print">

    <strong>Copyright &copy {{ date('Y') }} {{ $milyPosSettings->site_name }} </strong> All rights
    reserved.


    @if ($milyPosSettings->additional_footer_text!='')
        <div class="pull-right">
            {!!  Parsedown::instance()->text(e($milyPosSettings->additional_footer_text))  !!}
        </div>
    @endif

</footer>