<div class="form-group">
    <p class="col-sm-12"><b>{{ $files['name'] }}</b></p>
    <div class="col-sm-12 attached-files-list">
        @foreach($files['list'] as $file)
            <div class="attached-file <?= $file->ext ?>">
                <a href="{{ $file->url() }}">{{ $file->original_name }}</a>
                <div class="attached-file--control">
                    <a href="{{ $file->deleteUrl() }}" class="attached-file--delete red" onclick="return confirm('Вы уверены?')">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-sm-12 no-padding">
        <div class="upload-file col-sm-12">
                <span class="btn btn-default btn-file col-sm-2">
                    <span class="fileName">Выбрать файл</span>
                    <input type="file" name="file_{{ $files['entity'] }}" id="file_{{ $files['entity'] }}"
                           onchange="$in=$(this); $(this).parent().next().text($in.val().replace('C:\\fakepath\\', ''));">
                </span>
            <label for="file_{{ $files['entity'] }}" class="fileName col-sm-2 btn-link control-label" style="text-align: left; margin-top: 6px;"></label>
        </div>
    </div>
</div>
<hr>