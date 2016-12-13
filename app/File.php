<?php

namespace App;

class File extends CustomModel
{
    protected $fillable = [
        'parent_id',
        'ext',
        'mime',
        'size',
        'content',
        'name',
        'original_name',
        'pos',
    ];

    const FILE_MAX_FILESIZE = 16384;
    const FILE_PREFIX = 'file';
    const FILE_FOLDER = '/files';
    const FILE_STASH = '/files/stash';
    const FILENAME_FIELD = 'filename';

    public static $allowed_types = [
        'zip',
        'pdf',
        'doc',
        'docx',
        'xls',
        'xlsx',
        '7z',
        'rar',
        'torrent',
        'fb2',
        'epub',
        'webm',
        'gif',
        'jpg',
        'jpeg',
        'png'
    ];

    public static $required_files_folders = [
        self::FILE_FOLDER,
        self::FILE_STASH,
    ];

    public function url()
    {
        return self::FILE_STASH.'/'.$this->filename;
    }

    public function sourceFile()
    {
        return $this->hasOne('App\File', 'id', 'file_id');
    }

    public function deleteUrl()
    {
        return '/files/delete/'.$this->id;
    }
}
