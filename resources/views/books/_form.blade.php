@csrf

@foreach (['judul' => 'Judul', 'penulis' => 'Penulis', 'penerbit' => 'Penerbit', 'tahun_terbit' => 'Tahun Terbit'] as $field => $label)
    <div class="mb-4">
        <x-input-label :for="$field" :value="$label" />
        <x-text-input :id="$field" :name="$field" type="text" class="block mt-1 w-full"
                      :value="old($field, $book->$field ?? '')" />
        <x-input-error :messages="$errors->get($field)" class="mt-2" />
    </div>
@endforeach

<div class="flex items-center gap-4">
    <x-primary-button>Simpan</x-primary-button>
    <a href="{{ route('books.index') }}"
        class="text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
</div>