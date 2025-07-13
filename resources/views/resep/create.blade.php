@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="health-card p-6">
        <div class="flex items-center space-x-4">
            <div class="bg-green-100 p-3 rounded-full">
                <i class="fas fa-prescription-bottle-alt text-green-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Buat Resep Baru</h1>
                <p class="text-gray-600">Buat resep obat untuk pasien</p>
            </div>
        </div>
    </div>

    <form id="resepForm" action="{{ route('resep.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Jenis Resep -->
        <div class="health-card p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-clipboard-check text-blue-600 mr-2"></i>
                Jenis Resep
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="relative cursor-pointer">
                    <input type="radio" name="jenis" value="non_racikan" class="sr-only peer" checked>
                    <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="bg-blue-100 p-2 rounded-full">
                                <i class="fas fa-pills text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Non Racikan</p>
                                <p class="text-sm text-gray-600">Obat jadi dari pabrik</p>
                            </div>
                        </div>
                    </div>
                </label>
                <label class="relative cursor-pointer">
                    <input type="radio" name="jenis" value="racikan" class="sr-only peer">
                    <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 transition-all duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="bg-green-100 p-2 rounded-full">
                                <i class="fas fa-flask text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Racikan</p>
                                <p class="text-sm text-gray-600">Obat campuran khusus</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        <!-- Nama Racikan -->
        <div id="racikanField" class="health-card p-6 hidden">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-tag text-green-600 mr-2"></i>
                Nama Racikan
            </h3>
            <input type="text" name="nama_racikan"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                   placeholder="Masukkan nama racikan...">
        </div>

        <!-- Signa -->
        <div class="health-card p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-instructions text-purple-600 mr-2"></i>
                Signa / Aturan Pakai
            </h3>
            <select name="signa_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                    required>
                <option value="">Pilih Signa</option>
                @foreach($signas as $signa)
                <option value="{{ $signa->signa_id }}">{{ $signa->signa_kode }} - {{ $signa->signa_nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- Obat -->
        <div class="health-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-capsules text-orange-600 mr-2"></i>
                    Daftar Obat
                </h3>
                <button type="button" id="tambahObat"
    class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center space-x-2">
    <i class="fas fa-plus"></i>
    <span>Tambah Obat</span>
</button>

            </div>

            <div id="obatContainer" class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Obat</label>
                            <select name="obat[0][id]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent obat-select" required>
                                <option value="">Pilih Obat</option>
                                @foreach($obats as $obat)
                                <option value="{{ $obat->obatalkes_id }}" data-stok="{{ $obat->stok }}">
                                    {{ $obat->obatalkes_kode }} - {{ $obat->obatalkes_nama }} (Stok: {{ $obat->stok }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                            <input type="number" name="obat[0][qty]" min="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent qty-input"
                                   required>
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                            <span class="stok-info text-gray-600 text-sm bg-white px-3 py-2 rounded-lg border border-gray-200 block"></span>
                        </div>
                        <div class="md:col-span-1">
                            <button type="button" class="w-full bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-colors duration-200 remove-obat">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Draft Resep -->
        <div class="health-card p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-file-medical text-indigo-600 mr-2"></i>
                Preview Resep
            </h3>
            <div id="draftResep" class="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 rounded-xl border border-indigo-200">
                <p class="text-gray-500 text-center">Belum ada obat yang ditambahkan</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="health-card p-6">
            <div class="flex items-center justify-between">
                <a href="{{ route('resep.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
                <button type="submit"
                        class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-3 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <i class="fas fa-save"></i>
                    <span>Simpan Resep</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisRadios = document.querySelectorAll('input[name="jenis"]');
    const racikanField = document.getElementById('racikanField');

    jenisRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            racikanField.classList.toggle('hidden', this.value !== 'racikan');
            if (this.value === 'racikan') {
                document.querySelector('input[name="nama_racikan"]').required = true;
            } else {
                document.querySelector('input[name="nama_racikan"]').required = false;
            }
        });
    });

    // Tambah obat
    let obatCounter = 1;
    document.getElementById('tambahObat').addEventListener('click', function() {
        const newObat = document.createElement('div');
        newObat.className = 'bg-gray-50 p-4 rounded-xl border border-gray-200';
        newObat.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Obat</label>
                    <select name="obat[${obatCounter}][id]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent obat-select" required>
                        <option value="">Pilih Obat</option>
                        @foreach($obats as $obat)
                        <option value="{{ $obat->obatalkes_id }}" data-stok="{{ $obat->stok }}">
                            {{ $obat->obatalkes_kode }} - {{ $obat->obatalkes_nama }} (Stok: {{ $obat->stok }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" name="obat[${obatCounter}][qty]" min="1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent qty-input"
                           required>
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                    <span class="stok-info text-gray-600 text-sm bg-white px-3 py-2 rounded-lg border border-gray-200 block"></span>
                </div>
                <div class="md:col-span-1">
                    <button type="button" class="w-full bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-colors duration-200 remove-obat">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        document.getElementById('obatContainer').appendChild(newObat);
        obatCounter++;
        addObatEventListeners(newObat);
        updateDraftResep();
    });

    // Hapus obat
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-obat') || e.target.closest('.remove-obat')) {
            if (document.querySelectorAll('.remove-obat').length > 1) {
                e.target.closest('.bg-gray-50').remove();
                updateDraftResep();
            } else {
                alert('Minimal harus ada satu obat');
            }
        }
    });

    // Update stok info and draft
    function addObatEventListeners(container) {
        const select = container.querySelector('.obat-select');
        const qtyInput = container.querySelector('.qty-input');
        const stokInfo = container.querySelector('.stok-info');

        select.addEventListener('change', function() {
            const stok = this.options[this.selectedIndex]?.dataset.stok || 0;
            stokInfo.textContent = `Tersedia: ${stok}`;
            qtyInput.max = stok;
            updateDraftResep();
        });

        qtyInput.addEventListener('input', updateDraftResep);
    }

    // Update draft resep
    function updateDraftResep() {
        const draftResep = document.getElementById('draftResep');
        const obatSelects = document.querySelectorAll('.obat-select');
        const qtyInputs = document.querySelectorAll('.qty-input');
        const jenisResep = document.querySelector('input[name="jenis"]:checked').value;

        let html = '<div class="overflow-x-auto"><table class="min-w-full"><thead><tr class="border-b border-indigo-200"><th class="text-left py-2 px-4 font-medium text-gray-700">Obat</th><th class="text-left py-2 px-4 font-medium text-gray-700">Qty</th><th class="text-left py-2 px-4 font-medium text-gray-700">Stok Tersisa</th></tr></thead><tbody>';

        let hasObat = false;
        obatSelects.forEach((select, index) => {
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption && selectedOption.value) {
                hasObat = true;
                const obatName = selectedOption.text.split(' - ')[1].split(' (Stok:')[0];
                const stok = selectedOption.dataset.stok;
                const qty = qtyInputs[index].value || 0;
                html += `
                    <tr class="border-b border-indigo-100">
                        <td class="py-2 px-4">${obatName}</td>
                        <td class="py-2 px-4"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">${qty}</span></td>
                        <td class="py-2 px-4"><span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">${stok - qty} dari ${stok}</span></td>
                    </tr>
                `;
            }
        });
        html += '</tbody></table></div>';

        if (jenisResep === 'racikan') {
            const namaRacikan = document.querySelector('input[name="nama_racikan"]').value || 'Belum diberi nama';
            html = `<div class="mb-4 p-3 bg-green-100 rounded-lg"><p class="font-semibold text-green-800"><i class="fas fa-flask mr-2"></i>Racikan: ${namaRacikan}</p></div>` + html;
        }

        draftResep.innerHTML = hasObat ? html : '<p class="text-gray-500 text-center"><i class="fas fa-info-circle mr-2"></i>Belum ada obat yang ditambahkan</p>';
    }

    document.querySelectorAll('.obat-select').forEach(select => {
        addObatEventListeners(select.closest('.bg-gray-50'));
    });
});
</script>
@endsection
