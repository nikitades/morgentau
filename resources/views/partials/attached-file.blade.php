<div class="form-group">
    <p class="col-sm-12"><b>{{ $files['name'] }}</b></p>
    <div class="col-sm-12 attached-files-list">
        @foreach($files['list'] as $file)
            <div class="attached-file <?= $file->ext ?>">
                <a href="{{ $file->url() }}">{{ $file->filename }}</a>
                <div class="attached-file--control">
                    <a href="{{ $file->deleteUrl() }}" class="attached-file--delete red" onclick="return confirm('Вы уверены?')">
                        @include('partials.fa', ['code' => 'fa-trash-o'])
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="upload-image col-sm-12">
        @include('partials.file-input', [
            'name' => 'file_' . $files['entity'],
            'annotation' => 'Выберите файл'
        ])
    </div>
</div>
<hr>