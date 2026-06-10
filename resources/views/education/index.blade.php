<x-app-layout>
    <div class="max-w-3xl mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-6">Pendidikan</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded p-6 mb-8">
            <h2 class="text-lg font-semibold mb-4">Tambah Pendidikan</h2>
        <form action="{{ url('/pendidikan') }}" method="POST">
            @csrf
            <input type="hidden" name="id_user" value="{{ auth()->id() }}"> <!-- contoh ambil user id dari auth -->

            <input type="text" name="institusi" placeholder="Institusi" required maxlength="255">
            <input type="text" name="jenjang" placeholder="Jenjang" required maxlength="255">
            <input type="text" name="jurusan" placeholder="Jurusan (optional)" maxlength="255">
            <input type="text" name="lokasi" placeholder="Lokasi (optional)" maxlength="255">

            <label for="tanggal_mulai">Tanggal Mulai:</label>
            <input type="date" name="tanggal_mulai" required>

            <label for="tanggal_selesai">Tanggal Selesai (optional):</label>
            <input type="date" name="tanggal_selesai">

            <label for="ipk">IPK (optional):</label>
            <input type="number" name="ipk" step="0.01" min="0" max="4" placeholder="Contoh: 3.75">

            <textarea name="deskripsi" placeholder="Deskripsi (optional)"></textarea>

            <button type="submit">Simpan</button>
        </form>

        </div>

        <h2 class="text-xl font-semibold mb-3">Riwayat Pendidikan</h2>
        @if(count($educations))
            <div class="space-y-4">
                @foreach($educations as $edu)
                    <div class="bg-white shadow rounded p-4">
                        <div class="font-semibold text-lg">{{ $edu->institusi }}</div>
                        <div class="text-sm text-gray-500">{{ $edu->jenjang }}</div>
                        <div class="text-sm text-gray-500">
                            {{ $edu->tanggal_mulai }} - {{ $edu->tanggal_selesai ?? 'Sekarang' }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500">Belum ada data pendidikan.</div>
        @endif
    </div>
</x-app-layout>
