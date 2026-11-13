<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Survei Saya') }}
            </h2>
            <a href="{{ route('surveys.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                + Buat Survei Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Pesan notifikasi sukses --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($surveys->isEmpty())
                    <p class="text-gray-500 text-center py-8">Belum ada survei yang dibuat. Klik tombol di kanan atas untuk memulai.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Survei</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pertanyaan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Responden</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($surveys as $survey)
                                <tr>
                                    <td class="px-4 py-4">
                                        <a href="{{ route('surveys.show', $survey) }}" class="font-semibold text-indigo-600 hover:underline">
                                            {{ $survey->title }}
                                        </a>
                                        <p class="text-xs text-gray-400 mt-1">/s/{{ $survey->slug }}</p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $survey->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $survey->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">{{ $survey->questions_count }} soal</td>
                                    <td class="px-4 py-4 text-sm text-gray-600">{{ $survey->responses_count }} orang</td>
                                    <td class="px-4 py-4 text-right text-sm space-x-2">
                                        <a href="{{ route('surveys.show', $survey) }}" class="text-blue-600 hover:underline">Kelola</a>
                                        <a href="{{ route('surveys.edit', $survey) }}" class="text-amber-600 hover:underline">Edit</a>
                                        <form action="{{ route('surveys.destroy', $survey) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus survei ini beserta seluruh jawabannya?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $surveys->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>