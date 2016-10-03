<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
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
    ];

    public static $required_files_folders = [
        self::FILE_FOLDER,
        self::FILE_STASH,
    ];

    public function url()
    {
        return self::FILE_STASH.'/'.$this->filename;
    }

    public function deleteUrl()
    {
        return '/files/delete/'.$this->id;
    }
}
