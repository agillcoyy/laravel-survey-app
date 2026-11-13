<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $survey->title }}
            </h2>
            <a href="{{ route('surveys.index') }}" class="text-sm text-gray-600 hover:underline">&larr; Kembali ke Daftar</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-600">{{ $survey->description ?? 'Tidak ada deskripsi.' }}</p>
                <div class="mt-4 text-sm text-gray-500">
                    Link Publik: <span class="font-mono text-indigo-600">{{ url('/s/' . $survey->slug) }}</span>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-2">Daftar Pertanyaan ({{ $survey->questions->count() }})</h3>
                <p class="text-sm text-gray-500">Fitur tambah pertanyaan & opsi akan dikerjakan pada TICKET-04.</p>
            </div>
        </div>
    </div>
</x-app-layout>