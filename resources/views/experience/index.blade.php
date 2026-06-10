<x-app-layout>
    <div class="max-w-3xl mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-6">Pengalaman Kerja</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded p-6 mb-8">
            <h2 class="text-lg font-semibold mb-4">Tambah Pengalaman</h2>
            <form method="POST" action="{{ url('/pengalaman') }}">
                @csrf
                <div class="mb-4">
                    <label for="institusi" class="block font-medium mb-1">Institusi</label>
                    <input type="text" name="institusi" id="institusi" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="posisi" class="block font-medium mb-1">Posisi</label>
                    <input type="text" name="posisi" id="posisi" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="lokasi" class="block font-medium mb-1">Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" class="w-full border rounded px-3 py-2">
                </div>
                <div class="mb-4 flex gap-4">
                    <div class="w-1/2">
                        <label for="tanggal_mulai" class="block font-medium mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="w-1/2">
                        <label for="tanggal_akhir" class="block font-medium mb-1">Tanggal Selesai</label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="w-full border rounded px-3 py-2">
                        <small class="text-gray-500">Boleh dikosongkan jika masih aktif</small>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="deskripsi" class="block font-medium mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="w-full border rounded px-3 py-2"></textarea>
                </div>
                <button type="submit" style="background-color: #007bff; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Simpan</button>
            </form>
        </div>

        <h2 class="text-xl font-semibold mb-3">Daftar Pengalaman</h2>
        @if(count($experiences))
            <div class="space-y-4">
                @foreach($experiences as $exp)
                    <div class="bg-white shadow rounded p-4">
                        <div class="font-semibold text-lg">{{ $exp->posisi }}</div>
                        <div class="text-sm text-gray-500 mb-1">{{ $exp->institusi }} @if($exp->lokasi) - {{ $exp->lokasi }} @endif</div>
                        <div class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($exp->tanggal_mulai)->format('d M Y') }} -
                            {{ $exp->tanggal_akhir ? \Carbon\Carbon::parse($exp->tanggal_akhir)->format('d M Y') : 'Sekarang' }}
                        </div>
                        @if($exp->deskripsi)
                            <div class="text-sm mt-2">{{ $exp->deskripsi }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500">Belum ada pengalaman.</div>
        @endif
    </div>
</x-app-layout>