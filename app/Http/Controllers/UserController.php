<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['dataUser'] = Pelanggan::all();
        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $data['first_name'] = $request->first_name;
        $data['last_name']  = $request->last_name;
        $data['birthday']   = $request->birthday;
        $data['gender']     = $request->gender;
        $data['email']      = $request->email;
        $data['phone']      = $request->phone;

        Pelanggan::create($data);

        return redirect()->route('user.index')->with('create', 'Penambahan Data Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['dataUser'] = Pelanggan::findOrFail($id);
        return view('admin.user.edit', $data);
    }

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    $pelanggan_id = $id;
    $pelanggan = Pelanggan::findOrFail($pelanggan_id);

    $pelanggan->first_name = $request->first_name;
    $pelanggan->last_name = $request->last_name;
    $pelanggan->birthday = $request->birthday;
    $pelanggan->gender = $request->gender;
    $pelanggan->email = $request->email;
    $pelanggan->phone = $request->phone;

    $pelanggan->save();
    return redirect()->route('user.index')->with('update', 'Perubahan Data Berhasil!');
}

/**
 * Remove the specified resource from storage.
 */
public function destroy(string $id)
{
    $pelanggan = Pelanggan::findOrFail($id);

    return redirect()->route('user.index')->with('Delete', 'Data berhasil di hapus!');
}
};
