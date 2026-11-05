<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Daftar Buku</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tombol disembunyikan sesuai permission (hanya tampilan, BUKAN pengamanan) --}}
            @can('tambah buku')
                <a href="{{ route('books.create') }}"
                    class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    + Tambah Buku
                </a>
            @endcan

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="w-full text-left text-gray-900 dark:text-gray-100">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                            <th class="p-3">Judul</th>
                            <th class="p-3">Penulis</th>
                            <th class="p-3">Penerbit</th>
                            <th class="p-3">Tahun</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="p-3">{{ $book->judul }}</td>
                                <td class="p-3">{{ $book->penulis }}</td>
                                <td class="p-3">{{ $book->penerbit }}</td>
                                <td class="p-3">{{ $book->tahun_terbit }}</td>
                                <td class="p-3">
                                    <div class="flex gap-3">
                                        @can('edit buku')
                                            <a href="{{ route('books.edit', $book) }}"
                                                class="text-indigo-600 dark:text-indigo-400 hover:underline">Edit</a>
                                        @endcan

                                        @can('hapus buku')
                                            <form method="POST" action="{{ route('books.destroy', $book) }}"
                                                    onsubmit="return confirm('Yakin hapus buku ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 dark:text-red-400 hover:underline">Hapus</button>
                                            </form>
                                        @endcan

                                        @cannot('edit buku')
                                            <span class="text-gray-400 dark:text-gray-500">-</span>
                                        @endcannot
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500 dark:text-gray-400">Belum ada buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $books->links() }}</div>
        </div>
    </div>
</x-app-layout>