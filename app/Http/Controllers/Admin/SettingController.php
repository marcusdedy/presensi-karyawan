<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use App\Models\Motivation;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->settings as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    // Holidays
    public function holidays()
    {
        $holidays = Holiday::orderBy('tanggal')->paginate(20);
        return view('admin.settings.holidays', compact('holidays'));
    }

    public function holidayStore(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:nasional,cuti_bersama,perusahaan',
        ]);

        Holiday::create([
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'tahun' => date('Y', strtotime($request->tanggal)),
        ]);

        return redirect()->back()->with('success', 'Hari libur berhasil ditambahkan.');
    }

    public function holidayDestroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->back()->with('success', 'Hari libur berhasil dihapus.');
    }

    // Motivations
    public function motivations()
    {
        $motivations = Motivation::orderBy('tipe')->orderBy('kategori')->paginate(20);
        return view('admin.settings.motivations', compact('motivations'));
    }

    public function motivationStore(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:masuk,pulang',
            'kategori' => 'required|string',
            'pesan' => 'required|string',
            'gif_url' => 'nullable|url',
        ]);

        Motivation::create($request->only(['tipe', 'kategori', 'pesan', 'gif_url']));
        return redirect()->back()->with('success', 'Motivasi berhasil ditambahkan.');
    }

    public function motivationDestroy(Motivation $motivation)
    {
        $motivation->delete();
        return redirect()->back()->with('success', 'Motivasi berhasil dihapus.');
    }
}
