@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="health-card p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-file-medical-alt text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Detail Resep</h1>
                    <p class="text-gray-600">Informasi lengkap resep obat</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('resep.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
                <a href="{{ route('resep.print', $resep) }}"
                   class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <i class="fas fa-print"></i>
                    <span>Cetak Resep</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Resep Info -->
    <div class="health-card p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
            Informasi Resep
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 p-2 rounded-full">
                        <i class="fas fa-calendar-alt text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal</p>
                        <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($resep->tanggal)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 p-4 rounded-xl border border-green-200">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-100 p-2 rounded-full">
                        @if($resep->isRacikan())
                            <i class="fas fa-flask text-green-600"></i>
                        @else
                            <i class="fas fa-pills text-green-600"></i>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Jenis</p>
                        <p class="font-semibold text-gray-800">{{ $resep->isRacikan() ? 'Racikan' : 'Non Racikan' }}</p>
                    </div>
                </div>
            </div>

            @if($resep->isRacikan())
            <div class="bg-purple-50 p-4 rounded-xl border border-purple-200">
                <div class="flex items-center space-x-3">
                    <div class="bg-purple-100 p-2 rounded-full">
                        <i class="fas fa-tag text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nama Racikan</p>
                        <p class="font-semibold text-gray-800">{{ $resep->nama_racikan }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Daftar Obat -->
    <div class="health-card overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-capsules text-orange-600 mr-2"></i>
                Daftar Obat
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Signa</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($resep->details as $detail)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full w-fit">
                                {{ $loop->iteration }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="bg-orange-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-pills text-orange-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $detail->obat->obatalkes_nama }}</p>
                                    <p class="text-sm text-gray-500">{{ $detail->obat->obatalkes_kode }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $detail->jumlah }} unit
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="bg-purple-50 p-2 rounded-lg">
                                <p class="text-sm font-medium text-purple-800">{{ $detail->signa->signa_kode }}</p>
                                <p class="text-xs text-purple-600">{{ $detail->signa->signa_nama }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
