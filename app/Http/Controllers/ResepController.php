<?php

namespace App\Http\Controllers;

use App\Models\Obatalkes;
use App\Models\Resep;
use App\Models\ResepDetail;
use App\Models\Signa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ResepController extends Controller
{
    public function index()
    {
        $reseps = Resep::with('details.obat', 'details.signa')->latest()->get();
        return view('resep.index', compact('reseps'));
    }

    public function create()
    {
        $obats = Obatalkes::where('is_active', 1)->where('stok', '>', 0)->get();
        $signas = Signa::where('is_active', 1)->get();
        return view('resep.create', compact('obats', 'signas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:racikan,non_racikan',
            'nama_racikan' => 'required_if:jenis,racikan',
            'obat' => 'required|array',
            'obat.*.id' => 'required|exists:obatalkes_m,obatalkes_id',
            'obat.*.qty' => 'required|integer|min:1',
            'signa_id' => 'required|exists:signa_m,signa_id',
        ]);

        // Cek stok obat
        foreach ($request->obat as $obat) {
            $obatalkes = Obatalkes::find($obat['id']);
            if ($obatalkes->stok < $obat['qty']) {
                return back()->withErrors(['stok' => 'Stok ' . $obatalkes->obatalkes_nama . ' tidak mencukupi']);
            }
        }

        // Buat resep
        $resep = Resep::create([
            'jenis' => $request->jenis,
            'nama_racikan' => $request->nama_racikan,
            'tanggal' => now(),
        ]);

        // Buat detail resep
        foreach ($request->obat as $obat) {
            ResepDetail::create([
                'resep_id' => $resep->id,
                'obatalkes_id' => $obat['id'],
                'signa_id' => $request->signa_id,
                'jumlah' => $obat['qty'],
            ]);

            // Update stok obat
            Obatalkes::where('obatalkes_id', $obat['id'])
                ->decrement('stok', $obat['qty']);
        }

        return redirect()->route('resep.index')->with('success', 'Resep berhasil disimpan');
    }

    public function show(Resep $resep)
    {
        $resep->load('details.obat', 'details.signa');
        return view('resep.show', compact('resep'));
    }

    public function print(Resep $resep)
    {
        $resep->load('details.obat', 'details.signa');

        $resep->nama_racikan = mb_convert_encoding($resep->nama_racikan ?? '', 'UTF-8', 'ISO-8859-1');

        foreach ($resep->details as $detail) {
            $detail->obat->obatalkes_nama = mb_convert_encoding($detail->obat->obatalkes_nama ?? '', 'UTF-8', 'ISO-8859-1');
            $detail->signa->signa_nama = mb_convert_encoding($detail->signa->signa_nama ?? '', 'UTF-8', 'ISO-8859-1');
        }

        PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
        ]);

        $pdf = PDF::loadView('resep.print', compact('resep'));

        return $pdf->stream('resep-' . $resep->id . '.pdf');
    }
    public function destroy(Resep $resep)
    {
        // Hapus dulu semua detail resep
        $resep->details()->delete();

        // Baru hapus resep utama
        $resep->delete();

        return redirect()->route('resep.index')->with('success', 'Resep berhasil dihapus.');
    }
    public function hapusSemua()
    {
        \App\Models\ResepDetail::query()->delete();
        \App\Models\Resep::query()->delete();

        return redirect()->route('resep.index')->with('success', 'Semua resep berhasil dihapus.');
    }
}
