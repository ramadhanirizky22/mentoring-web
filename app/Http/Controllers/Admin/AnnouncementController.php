<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    // get announcement
    public function index()
    {
        $announcements = Announcement::all();
        return view('admin.announcement', compact('announcements'));
    }

    //Add Announcement
    public function upload(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'announcement' => 'required|mimes:pdf|max:10240',
        ]);

        $file = $request->file('announcement');
        $safeName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $uniqueFileName = time() . '_' . $safeName . '.' . $file->getClientOriginalExtension();

        $storagePath = storage_path('app/public/announcements');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        $file->move($storagePath, $uniqueFileName);

        Announcement::create([
            'title' => $request->input('title'),
            'file_path' => $uniqueFileName,
        ]);

        return redirect()->back()->with('success', 'Announcement uploaded successfully!');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        $safeFileName = basename($announcement->file_path);
        $filePath = storage_path('app/public/announcements/' . $safeFileName);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted successfully!');
    }

    // Method untuk update data announcement
    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $title = $request->input('title');
        if ($title) {
            $announcement->title = $title;
        }

        $announcement->save();

        return redirect()->back()->with('success', 'Announcement updated successfully!');
    }


    public function download($fileName)
    {
        $safeFileName = basename($fileName);
        $filePath = storage_path('app/public/announcements/' . $safeFileName);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return response()->json(['message' => 'File not found.'], 404);
    }
}
