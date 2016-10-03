<?php

namespace App\Http\Controllers;

use App\Backup;
use App\Http\Requests;
use Illuminate\Http\Request;
use PhpSpec\Exception\Exception;

class BackupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Makes the backup of the whole site - either base and site files.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function makeBackup($base = true, $files = true)
    {
        if (!file_exists('../' . Backup::FOLDER . '')) {
            mkdir('../' . Backup::FOLDER . '');
        }

        $currentDayName = date('d.m.Y_H-i-s') . '--1';

        if (file_exists('../' . Backup::FOLDER . '/' . $currentDayName)) {
            $currentDayName = $currentDayName . '--' . rand(0, 100000);
        }

        mkdir('../' . Backup::FOLDER . '/' . $currentDayName);

        $totalSize = 0;

        $backup = new Backup;

        if ($files) {
            $output = [];
            $archivename = $_ENV['PROJECT_NAME'] . '.' . date('d.m.Y_H-i-s') . '.tar.bz2';
            exec('tar -cjf ../' . Backup::FOLDER . '/' . $currentDayName . '/' . $archivename . ' ../ --exclude=' . Backup::FOLDER, $output);
            $totalSize += filesize('../' . Backup::FOLDER . '/' . $currentDayName . '/' . $archivename);
            $backup->tar = $archivename;
        }

        if ($base) {
            $output = [];
            $sqlName = $_ENV['PROJECT_NAME'] . '.' . date('d.m.Y_H-i-s') . '.full.sql';
            $str = 'mysqldump -h' . $_ENV['DB_HOST'] . ' -u' . $_ENV['DB_USERNAME'] . ' -p' . $_ENV['DB_PASSWORD'] . ' ' . $_ENV['DB_DATABASE'] . ' > ../' . Backup::FOLDER . '/' . $currentDayName . '/' . $_ENV['PROJECT_NAME'] . '.' . date('d.m.Y_H-i-s') . '.full.sql';
            exec($str, $output);
            $totalSize += filesize('../' . Backup::FOLDER . '/' . $currentDayName . '/' . $sqlName);
            $backup->sql = $sqlName;
        }

        $backup->type = $base ? ($files ? 1 : 2) : 3;
        $backup->size = $totalSize;
        $backup->folder = $currentDayName;
        $backup->save();

        return redirect('/admin/backups');
    }

    /**
     * Makes the backup of the whole site - either base and site files.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function all()
    {
        $this->makeBackup(true, true);
        return redirect('/admin/backups');
    }

    /**
     * Makes the backup of the site database.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function base()
    {
        $this->makeBackup(true, false);
        return redirect('/admin/backups');
    }

    /**
     * Makes the backup of the site files.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function files()
    {
        $this->makeBackup(false, true);
        return redirect('/admin/backups');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Backup::findOrFail($id);
        $folder = $item->folder;
        delTree('../'.Backup::FOLDER.'/'.$folder);
        $item->delete();
        return redirect('/admin/backups');
    }

    public function restore($id)
    {
        $item = Backup::findOrFail($id);

        $folders = array_flip(array_diff(scandir('../'.Backup::FOLDER.'/'), ['.', '..']));

        if (isset($folders[$item->folder])) {
            $folder = '../'.Backup::FOLDER.'/'.$item->folder;
            $files = array_diff(scandir($folder), ['.', '..']);
            foreach ($files as $file) {
                if ($file == $item->tar && ($item->type == 1 || $item->type == 3)) {
                    de('mkdir /tmp/'.Backup::FOLDER);
                    de('cp -R ../'.Backup::FOLDER.' /tmp');
                    de('rm -rf ../*');
                    de('cp -R /tmp/'.Backup::FOLDER.' ../');
                    de('rm -rf /tmp/'.Backup::FOLDER);
                    de('tar -xf '.$folder.'/'.$item->tar.' -C ../');
                }
                if ($file == $item->sql && ($item->type == 1 || $item->type == 2)) {
                    de('mysqldump -h' . $_ENV['DB_HOST'] . ' -u' . $_ENV['DB_USERNAME'] . ' -p' . $_ENV['DB_PASSWORD'] . ' ' . $_ENV['DB_DATABASE'] . ' backups > ' . $folder .  '/' . 'backups.sql');
                    de('mysql -h' . $_ENV['DB_HOST'] . ' -u' . $_ENV['DB_USERNAME'] . ' -p' . $_ENV['DB_PASSWORD'] . ' ' . $_ENV['DB_DATABASE'] . ' < ' . $folder .  '/' . $item->sql);
                    de('mysql -h' . $_ENV['DB_HOST'] . ' -u' . $_ENV['DB_USERNAME'] . ' -p' . $_ENV['DB_PASSWORD'] . ' ' . $_ENV['DB_DATABASE'] . ' < ' . $folder .  '/' . 'backups.sql');
                    de('rm -rf '.$folder.'/backups.sql');
                }
            }
        } else {
            throw new Exception('Не найдена папка!');
        }

        return redirect('/admin/backups');
    }
}
