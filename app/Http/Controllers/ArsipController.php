<?php

namespace App\Http\Controllers;

use App\Models\ArsipDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    public function index($pr_id)
    {
        $arsip = ArsipDokumen::where('pr_id', $pr_id)->get();
        return response()->json($arsip);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'pr_id' => 'required|integer',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:20480',
        ]);

        $file = $request->file('file');
        $path = $file->store('arsip_dokumen', 'public');

        ArsipDokumen::create([
            'pr_id' => $request->pr_id,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
        ]);

        return back()->with('success', 'Dokumen berhasil diupload.');
    }

    public function download($id)
    {
        $arsip = ArsipDokumen::findOrFail($id);
        return Storage::disk('public')->download($arsip->file_path, $arsip->file_name);
    }
}
