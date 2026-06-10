<x-app-layout>
    <div class="max-w-3xl mx-auto mt-8 space-y-6">
        {{-- Flash message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Tambah Skill --}}
        <div class="bg-white shadow rounded p-6">
            <h2 class="text-lg font-semibold mb-4">Tambah Skill</h2>
            <form method="POST" action="{{ url('/skills') }}">
                @csrf
                <div class="mb-4">
                    <label for="nama_skill" class="block font-medium mb-1">Nama Skill</label>
                    <input type="text" name="nama_skill" id="nama_skill" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="level" class="block font-medium mb-1">Level</label>
                    <input type="text" name="level" id="level" class="w-full border rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label for="sertifikasi" class="block font-medium mb-1">Nama Sertifikasi (Opsional)</label>
                    <input type="text" name="sertifikasi" id="sertifikasi" class="w-full border rounded px-3 py-2">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            </form>
        </div>

        {{-- Daftar Skill --}}
        <div class="bg-white shadow rounded p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Skill</h2>
                <a href="#form-tambah-skill" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Skill</a>
            </div>

            @if(count($skills))
                <div class="space-y-4">
                @foreach($skills as $skill)
                    <div class="bg-white shadow rounded p-4">
                        <div class="font-semibold text-lg">{{ $skill->nama_skill }}</div>
                        <div class="text-sm text-gray-500">{{ $skill->level }}</div>
                    </div>
                @endforeach
                </div>
            @else
                <div class="text-gray-500">Belum ada skill.</div>
            @endif
        </div>
    </div>
</x-app-layout>
