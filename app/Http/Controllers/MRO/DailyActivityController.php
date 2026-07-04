<?php

namespace App\Http\Controllers\MRO;

use App\Http\Controllers\Controller;
use App\Models\DailyActivity;
use App\Models\DailyActivityAttachment;
use App\Models\MasterPersonil;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class DailyActivityController extends Controller
{
    public function index()
    {
        $data = DailyActivity::with(['monitoring', 'attachments'])->latest()->get();
        return view('mro.daily_activity.index', compact('data'));
    }

    public function create()
    {
        $monitoring = Monitoring::orderBy('po_nota_dinas')->get();

        $personils = MasterPersonil::orderBy('nama')->get();

        return view(
            'mro.daily_activity.create',
            compact(
                'monitoring',
                'personils'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'monitoring_id' => 'required|exists:monitorings,id',
            'kegiatan' => 'required|string',
            'status' => 'required|in:Open,Closed',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'personil' => 'required|array|min:1',
            'personil.*' => 'required|string|max:100',
            'lampiran.*' => 'nullable|file|max:50120',
        ]);

        $keterangan = null;

        if ($request->filled('keterangan')) {
            $baris = preg_split("/\r\n|\n|\r/", trim($request->keterangan));

            $keterangan = collect($baris)
                ->map(fn($item) => trim($item))
                ->filter()
                ->implode(PHP_EOL);
        }

        $daily = DailyActivity::create([
            'monitoring_id' => $request->monitoring_id,
            'kegiatan' => $request->kegiatan,
            'status' => $request->status,
            'tanggal' => $request->tanggal,
            'keterangan' => $keterangan,
            'personil' => $request->personil,
        ]);
        if ($request->hasFile('lampiran')) {
            if (!file_exists(public_path('uploads/daily_activity'))) {
                mkdir(public_path('uploads/daily_activity'), 0777, true);
            }
            foreach ($request->file('lampiran') as $file) {
                $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/daily_activity'), $namaFile);
                DailyActivityAttachment::create([
                    'daily_activity_id' => $daily->id,
                    'file' => $namaFile,
                ]);
            }
        }
        return redirect()->route('mro.daily-activity.index')->with('success', 'Daily Activity berhasil disimpan.');
    }

    public function edit($id)
    {
        $daily = DailyActivity::with('attachments')->findOrFail($id);

        $monitoring = Monitoring::orderBy('po_nota_dinas')->get();

        $personils = MasterPersonil::orderBy('nama')->get();

        return view(
            'mro.daily_activity.edit',
            compact(
                'daily',
                'monitoring',
                'personils'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'monitoring_id' => 'required',
            'kegiatan' => 'required',
            'status' => 'required',
            'tanggal' => 'required',
            'personil' => 'required|array',
        ]);

        $daily = DailyActivity::findOrFail($id);

        $keterangan = null;

        if ($request->filled('keterangan')) {
            $baris = preg_split("/\r\n|\n|\r/", trim($request->keterangan));

            $keterangan = collect($baris)
                ->map(fn($item) => trim($item))
                ->filter()
                ->implode(PHP_EOL);
        }

        $daily->update([
            'monitoring_id' => $request->monitoring_id,
            'kegiatan' => $request->kegiatan,
            'status' => $request->status,
            'tanggal' => $request->tanggal,
            'keterangan' => $keterangan,
            'personil' => $request->personil,
        ]);

        if ($request->hasFile('lampiran')) {
            if (!file_exists(public_path('uploads/daily_activity'))) {
                mkdir(public_path('uploads/daily_activity'), 0777, true);
            }

            foreach ($request->file('lampiran') as $file) {
                if (!$file) {
                    continue;
                }

                $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $file->move(
                    public_path('uploads/daily_activity'),
                    $namaFile
                );

                DailyActivityAttachment::create([
                    'daily_activity_id' => $daily->id,
                    'file' => $namaFile
                ]);
            }
        }

        return redirect()
            ->route('mro.daily-activity.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $daily = DailyActivity::findOrFail($id);

        foreach ($daily->attachments as $lampiran) {
            $path = public_path('uploads/daily_activity/' . $lampiran->file);

            if (file_exists($path)) {
                unlink($path);
            }

            $lampiran->delete();
        }

        $daily->delete();

        return redirect()
            ->route('mro.daily-activity.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function destroyLampiran($id)
    {
        $lampiran = DailyActivityAttachment::findOrFail($id);

        $path = public_path('uploads/daily_activity/' . $lampiran->file);

        if (file_exists($path)) {
            unlink($path);
        }

        $lampiran->delete();

        return back()->with('success', 'Lampiran berhasil dihapus.');
    }
}
