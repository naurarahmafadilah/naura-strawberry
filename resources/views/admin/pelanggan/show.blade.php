@extends('layouts.admin.app')

@section('content')

<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="#">
                    <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pelanggan</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between mb-3">
        <div>
            <h1 class="h4">Detail Pelanggan</h1>
            <p class="mb-0">Informasi lengkap dan file pelanggan.</p>
        </div>

        <a href="{{ route('pelanggan.index') }}" class="btn btn-primary">
            Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">

                {{-- INFORMASI PELANGGAN --}}
                <h5 class="mb-3">Informasi Pelanggan</h5>

                <table class="table table-bordered">
                    <tr>
                        <th width="200">First Name</th>
                        <td>{{ $pelanggan->first_name }}</td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td>{{ $pelanggan->last_name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $pelanggan->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $pelanggan->phone }}</td>
                    </tr>
                    <tr>
                        <th>Birthday</th>
                        <td>{{ $pelanggan->birthday }}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>{{ $pelanggan->gender }}</td>
                    </tr>
                </table>

                <hr>

                {{-- FILE PELANGGAN --}}
                <h5 class="mt-4 mb-3">File Pelanggan</h5>

                <div class="row">
                    @forelse ($pelanggan->files as $file)
                        <div class="col-md-3 mb-4">

                            {{-- Jika file adalah gambar --}}
                            @if(Str::endsWith($file->file_path, ['jpg','jpeg','png']))
                                <img src="{{ asset('storage/' . $file->file_path) }}"
                                     class="img-fluid rounded border mb-2"
                                     alt="File Pelanggan">

                            {{-- Jika file bukan gambar --}}
                            @else
                                <a href="{{ asset('storage/' . $file->file_path) }}"
                                   target="_blank"
                                   class="btn btn-outline-primary w-100 mb-2">
                                   Lihat File
                                </a>
                            @endif

                            <small class="text-muted d-block text-center">
                                {{ basename($file->file_path) }}
                            </small>

                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                Belum ada file yang diupload.
                            </div>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
