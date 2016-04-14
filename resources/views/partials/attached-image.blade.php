<div class="form-group">
    <p class="col-sm-12"><b>{{ $images['name'] }}</b></p>
    <div class="col-sm-12 attached-images-list">
        @foreach($images['list'] as $image)
            <div class="attached-image">
                <a href="{{ $image->url() }}"><img src="{{ $image->url('lt', 100) }}" alt=""></a>
                <p class="attached-image--label">
                    {{ $image->name }}.{{ $image->ext }}
                </p>
                <div class="attached-image--control">
                    <select name="reposition_{{ $image->name }}" onchange="this.form.submit()">
                        @foreach($images['list'] as $option)
                            <option value="{{ $option->pos == $image->pos ? '' : $option->pos }}" {{ $option->pos == $image->pos ? 'selected="selected"' : '' }}>{{ $option->pos }}</option>
                        @endforeach
                    </select>
                    <a href="{{ $image->deleteUrl() }}" class="attached-image--delete red" onclick="return confirm('Вы уверены?')">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-sm-12 no-padding">
        <div class="upload-image col-sm-12">
                <span class="btn btn-default btn-file col-sm-2">
                    <span class="fileName">Выбрать файл</span>
                    <input type="file" name="image_{{ $images['entity'] }}" id="file_{{ $images['entity'] }}"
                           onchange="$in=$(this); $(this).parent().next().text($in.val().replace('C:\\fakepath\\', ''));">
                </span>
            <label for="file_{{ $images['entity'] }}" class="fileName col-sm-2 btn-link control-label" style="text-align: left; margin-top: 6px;"></label>
        </div>
    </div>
</div>
<hr>