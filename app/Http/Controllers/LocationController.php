<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::latest()->paginate(10);
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_lokasi' => 'required|unique:locations',
            'nama_lokasi' => 'required',
            'deskripsi'   => 'nullable',
        ]);

        Location::create($request->all());

        return redirect()->route('locations.index')
                         ->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'kode_lokasi' => 'required|unique:locations,kode_lokasi,' . $location->id,
            'nama_lokasi' => 'required',
            'deskripsi'   => 'nullable',
        ]);

        $location->update($request->all());

        return redirect()->route('locations.index')
                         ->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('locations.index')
                         ->with('success', 'Lokasi berhasil dihapus.');
    }
}