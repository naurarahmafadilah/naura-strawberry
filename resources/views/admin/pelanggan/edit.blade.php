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
            <li class="breadcrumb-item"><a href="#">Pelanggan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Pelanggan</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Edit Pelanggan</h1>
            <p class="mb-0">Form untuk edit data pelanggan dan upload file.</p>
        </div>
        <div>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow components-section">
            <div class="card-body">

                {{-- FORM EDIT --}}
                <form action="{{ route('pelanggan.update', $dataPelanggan->pelanggan_id) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- LEFT SIDE --}}
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name"
                                       value="{{ $dataPelanggan->first_name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name"
                                       value="{{ $dataPelanggan->last_name }}" required>
                            </div>
                        </div>

                        {{-- MIDDLE SIDE --}}
                        <div class="col-lg-4 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Birthday</label>
                                <input type="date" class="form-control" name="birthday"
                                       value="{{ $dataPelanggan->birthday }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="Male" {{ $dataPelanggan->gender=='Male'?'selected':'' }}>Male</option>
                                    <option value="Female" {{ $dataPelanggan->gender=='Female'?'selected':'' }}>Female</option>
                                    <option value="Other" {{ $dataPelanggan->gender=='Other'?'selected':'' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        {{-- RIGHT SIDE --}}
                        <div class="col-lg-4 col-sm-12">

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control"
                                       name="email" value="{{ $dataPelanggan->email }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control"
                                       name="phone" value="{{ $dataPelanggan->phone }}" required>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- MULTIPLE FILE UPLOAD --}}
                    <div class="mb-3">
                        <label class="form-label">Upload Multiple Files</label>
                        <input type="file" class="form-control" name="files[]" multiple>
                    </div>

                    {{-- FILE PREVIEW --}}
                    <h5 class="mt-4 mb-3">File Yang Sudah Diupload:</h5>

                    <div class="row">
                        @foreach($dataPelanggan->files as $file)
                        <div class="col-md-3 mb-4">

                            @if(Str::endsWith($file->file_path, ['jpg','jpeg','png']))
                                <img src="{{ asset('storage/'.$file->file_path) }}"
                                     class="img-fluid rounded border">
                            @else
                                <a href="{{ asset('storage/'.$file->file_path) }}"
                                   target="_blank" class="btn btn-outline-primary w-100">
                                   Lihat File
                                </a>
                            @endif

                            <form action="{{ route('pelanggan.file.delete', $file->id) }}"
                                  method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm w-100">Hapus</button>
                            </form>

                        </div>
                        @endforeach
                    </div>

                    {{-- BUTTONS --}}
                    <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                    <a href="{{ route('pelanggan.index') }}"
                       class="btn btn-outline-secondary mt-3 ms-2">Batal</a>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection
