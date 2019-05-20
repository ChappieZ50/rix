<select class="form-control p-0" name="categories" id="select_picker" multiple="multiple" data-live-search="true" title='Seçin'>
    @include('rix.layouts.components.posts.categories.parents')
</select>

@section('js')
    <script src="/rix/assets/js/bootstrap-select.min.js"></script>
    <script>
        $('#select_picker').selectpicker();
        let picker = $('button[data-id=select_picker]');
        picker.addClass('form-control bootstrap-select-custom');
        picker.removeClass('btn-light');
    </script>
@append

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/bootstrap-select.css">
@append
