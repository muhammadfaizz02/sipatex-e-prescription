@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="health-card p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-clipboard-list text-green-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Daftar Resep</h1>
                    <p class="text-gray-600">Kelola dan pantau semua resep obat</p>
                </div>
            </div>
            <a href="{{ route('resep.create') }}"
               class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Buat Resep Baru</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="health-card p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <i class="fas fa-prescription text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Resep</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $reseps->count() }}</p>
                </div>
            </div>
        </div>
        <div class="health-card p-6">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-full mr-4">
                    <i class="fas fa-pills text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Resep Racikan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $reseps->where('jenis', 'racikan')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="health-card p-6">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-full mr-4">
                    <i class="fas fa-capsules text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Non Racikan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $reseps->where('jenis', 'non_racikan')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Hapus Semua Resep -->
    @if($reseps->count() > 0)
    <form action="{{ route('resep.hapusSemua') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua resep?')" class="px-6">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="inline-flex items-center px-4 py-2 mb-4 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
            <i class="fas fa-trash mr-2"></i> Hapus Semua Resep
        </button>
    </form>
    @endif

    <!-- Resep Table -->
    <div class="health-card overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Resep Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Racikan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reseps as $resep)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $loop->iteration }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                {{ \Carbon\Carbon::parse($resep->tanggal)->format('d M Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($resep->jenis === 'racikan')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-flask mr-1"></i>
                                    Racikan
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-pills mr-1"></i>
                                    Non Racikan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $resep->nama_racikan ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('resep.show', $resep) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                                <i class="fas fa-eye mr-1"></i>
                                Lihat
                            </a>
                            <a href="{{ route('resep.print', $resep) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200">
                                <i class="fas fa-print mr-1"></i>
                                Cetak
                            </a>
                            <form action="{{ route('resep.destroy', $resep) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus resep ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200">
                                    <i class="fas fa-trash-alt mr-1"></i>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            <i class="fas fa-info-circle mr-2"></i>Belum ada resep yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
