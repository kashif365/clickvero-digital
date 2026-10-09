<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RobotRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RobotRuleController extends Controller
{
    private const UPLOAD_FILENAME = 'robots-upload.txt';

    public function index()
    {
        $disk = Storage::disk('public');
        $uploadExists = $disk->exists(self::UPLOAD_FILENAME);

        return view('admin.robots.index', [
            'rules' => RobotRule::orderBy('user_agent')->get(),
            'preview' => RobotRule::renderTxt(),
            'uploadExists' => $uploadExists,
            'uploadUpdatedAt' => $uploadExists ? $disk->lastModified(self::UPLOAD_FILENAME) : null,
            'uploadContent' => $uploadExists ? $disk->get(self::UPLOAD_FILENAME) : null,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_agent' => ['required', 'string', 'max:100'],
            'disallow' => ['required', 'string', 'max:255'],
        ]);

        RobotRule::create($data);

        return redirect()->route('admin.robots.index')->with('success', 'Rule added.');
    }

    public function destroy(RobotRule $robot)
    {
        $robot->delete();

        return redirect()->route('admin.robots.index')->with('success', 'Rule deleted.');
    }

    public function download()
    {
        return response(RobotRule::renderTxt(), 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="robots.txt"',
        ]);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'robots_file' => ['required', 'file', 'mimetypes:text/plain', 'extensions:txt', 'max:1024'],
        ]);

        Storage::disk('public')->putFileAs('', $request->file('robots_file'), self::UPLOAD_FILENAME);

        return redirect()->route('admin.robots.index')->with('success', 'robots.txt file uploaded — it will be served instead of the rules above.');
    }

    public function destroyFile()
    {
        Storage::disk('public')->delete(self::UPLOAD_FILENAME);

        return redirect()->route('admin.robots.index')->with('success', 'Uploaded file removed — the rules above will be served again.');
    }

    public function downloadFile()
    {
        return Storage::disk('public')->download(self::UPLOAD_FILENAME, 'robots.txt');
    }
}
