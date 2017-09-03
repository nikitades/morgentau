<div class="form-group">
    <p class="col-sm-12"><b>{{ $attached_image_type['name'] }}</b></p>
    <div class="col-sm-12 attached-images-list">
        @foreach($attached_image_type['list'] as $image)
            <div class="attached-image">
                <a href="{{ $image->url() }}" target="_blank"><img src="{{ $image->url('h', 100) }}" alt=""></a>
                <p class="attached-image--label">
                    {{ $image->name }}
                </p>
                <div class="attached-image--control">
                    {{--<select name="reposition_{{ $image->name }}" onchange="this.form.submit()">--}}
                    <select name="reposition:{{ get_class($image) }}:{{ $image->id }}"
                            onchange="$('.btn-stay').trigger('click');">
                        @foreach($attached_image_type['list'] as $option)
                            <option value="{{ $option->pos == $image->pos ? '' : $option->pos }}" {{ $option->pos == $image->pos ? 'selected="selected"' : '' }}>{{ $option->pos }}</option>
                        @endforeach
                    </select>
                    <a href="{{ $image->deleteUrl() }}" class="attached-image--delete red"
                       onclick="return confirm('Вы уверены?')">
                        @include('partials.fa', ['code' => 'fa-trash-o'])
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="upload-image col-sm-12">
        @include('partials.file-input', [
            'name' => 'image_' . $attached_image_type['entity'],
            'annotation' => 'Выберите изображение'
        ])
    </div>
</div>
<hr>