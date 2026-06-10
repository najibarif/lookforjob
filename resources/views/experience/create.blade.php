<x-app-layout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-lg font-bold mb-4">Tambah Pengalaman</h2>

        <form method="POST" action="{{ url('/pengalaman') }}">
            @csrf

            <div class="mb-4">
                <label for="position" class="block font-medium mb-1">Posisi</label>
                <input type="text" name="position" id="position" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="company" class="block font-medium mb-1">Perusahaan</label>
                <input type="text" name="company" id="company" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="start_year" class="block font-medium mb-1">Tahun Mulai</label>
                <input type="number" name="start_year" id="start_year" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="end_year" class="block font-medium mb-1">Tahun Selesai</label>
                <input type="number" name="end_year" id="end_year" class="w-full border rounded px-3 py-2">
                <small class="text-gray-500">Boleh dikosongkan jika masih aktif</small>
            </div>

            <div class="mb-4">
                <label for="description" class="block font-medium mb-1">Deskripsi</label>
                <textarea name="description" id="description" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Simpan</button>
            <a href="{{ url('/pengalaman') }}" class="ml-2 text-gray-700">Batal</a>
        </form>
    </div>
</x-app-layout>