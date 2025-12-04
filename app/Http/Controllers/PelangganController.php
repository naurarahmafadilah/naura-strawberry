<?php
namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\PelangganFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    public function index(Request $request)
    {

        if (! Auth::check()) {
            //Redirect ke halaman login
            return redirect()->route('auth')->withErrors('Silahkan login terlebih dahulu!');
        }

        $filterableColumns     = ['gender'];
        $searchableColumns     = ['first_name'];
        $data['dataPelanggan'] = Pelanggan::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10)
            ->onEachSide(2);
        return view('admin.pelanggan.index', $data);
    }

    public function create()
    {
        if (! Auth::check()) {
            //Redirect ke halaman login
            return redirect()->route('auth')->withErrors('Silahkan login terlebih dahulu!');
        }
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $pelanggan = Pelanggan::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'birthday'   => $request->birthday,
            'gender'     => $request->gender,
            'email'      => $request->email,
            'phone'      => $request->phone,
        ]);

        return redirect()->route('pelanggan.index')->with('create', 'Penambahan Data Berhasil!');
    }

    public function show(string $id)
    {
        $pelanggan = Pelanggan::with('files')->findOrFail($id);
        return view('admin.pelanggan.show', compact('pelanggan'));
    }

    public function edit(string $id)
    {
        $data['dataPelanggan'] = Pelanggan::with('files')->findOrFail($id);
        return view('admin.pelanggan.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'birthday'   => 'nullable|date',
            'gender'     => 'nullable',
            'email'      => 'required|email',
            'phone'      => 'nullable',
            'files.*'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // UPDATE DATA TEXT
        $pelanggan->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'birthday'   => $request->birthday,
            'gender'     => $request->gender,
            'email'      => $request->email,
            'phone'      => $request->phone,
        ]);

        // UPLOAD MULTIPLE FILES
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $path = $file->store('pelanggan_files', 'public');

                PelangganFile::create([
                    'pelanggan_id' => $pelanggan->pelanggan_id,
                    'file_path'    => $path,
                ]);
            }
        }

        return redirect()
            ->route('pelanggan.show', $pelanggan->pelanggan_id)
            ->with('update', 'Perubahan Data Berhasil!');
    }

    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // HAPUS FILE DARI STORAGE
        foreach ($pelanggan->files as $file) {
            Storage::disk('public')->delete($file->file_path);
        }

        // HAPUS DATA FILE
        $pelanggan->files()->delete();

        // HAPUS PELANGGAN
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('Delete', 'Data berhasil dihapus!');
    }

    public function destroyFile($id)
    {
        $file = PelangganFile::findOrFail($id);

        Storage::disk('public')->delete($file->file_path);

        $file->delete();

        return back()->with('success', 'File berhasil dihapus!');
    }
}
