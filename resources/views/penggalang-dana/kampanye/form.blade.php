<x-shell :title="$kampanye->exists ? 'Edit Kampanye' : 'Buat Kampanye'">
    <div class="mx-auto max-w-4xl space-y-6">
        <div>
            <a href="{{ route('penggalang.kampanye.index') }}"
               class="text-sm font-semibold text-teal-700 hover:text-teal-900">{{ __('← Kembali ke Kampanye Saya') }}</a>

            <h1 class="mt-4 text-2xl font-extrabold text-teal-900">
                {{ __($kampanye->exists ? 'Edit Kampanye' : 'Buat Kampanye Baru') }}
            </h1>

            <p class="mt-1 text-sm text-stone-600">{{ __('Lengkapi informasi kampanye penggalangan dana yang ingin kamu ajukan.') }}</p>
        </div>

        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
            <p class="font-bold">{{ __('Informasi Persetujuan') }}</p>
            <p class="mt-1">{{ __('Kampanye yang kamu ajukan akan diperiksa oleh Admin terlebih dahulu.') }} {{ __('Kampanye baru akan ditampilkan kepada publik setelah disetujui.') }}</p>
        </div>

        <form method="POST"
              action="{{ $kampanye->exists ? route('penggalang.kampanye.update', $kampanye) : route('penggalang.kampanye.store') }}"
              enctype="multipart/form-data"
              class="space-y-6 rounded-2xl border border-stone-200 bg-white p-5 shadow-sm sm:p-8">

            @csrf

            @if ($kampanye->exists)
                @method('PUT')
            @endif

            <div>
                <label for="kategori_id" class="mb-2 block text-sm font-bold text-stone-700">{{ __('Kategori Kampanye') }}<span class="text-red-500">*</span>
                </label>
                <select id="kategori_id" name="kategori_id" required
                        class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                    <option value="">{{ __('Pilih kategori') }}</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            @selected(old('kategori_id', $kampanye->kategori_id) == $kategori->id)>
                            {{ $kategori->nama_tampil }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="judul" class="mb-2 block text-sm font-bold text-stone-700">{{ __('Judul Kampanye') }}<span class="text-red-500">*</span>
                </label>
                <input id="judul" name="judul" type="text" required maxlength="150"
                       value="{{ old('judul', $kampanye->judul) }}"
                       placeholder="{{ __('Contoh: Bantu Korban Bencana Alam') }}"
                       class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                @error('judul')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="judul_en" class="mb-2 block text-sm font-bold text-stone-700">{{ __('Judul Kampanye (Bahasa Inggris)') }}</label>
                <input id="judul_en" name="judul_en" type="text" maxlength="150"
                       value="{{ old('judul_en', $kampanye->judul_en) }}"
                       placeholder="{{ __('Campaign title in English') }}"
                       class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                @error('judul_en')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="lokasi" class="mb-2 block text-sm font-bold text-stone-700">{{ __('Lokasi') }}</label>
                <input id="lokasi" name="lokasi" type="text" maxlength="120"
                       value="{{ old('lokasi', $kampanye->lokasi) }}"
                       placeholder="{{ __('Contoh: Gresik, Jawa Timur') }}"
                       class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                @error('lokasi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="penggalang" class="mb-2 block text-sm font-bold text-stone-700">{{ __('Nama Penggalang') }}<span class="text-red-500">*</span>
                </label>
                <input id="penggalang" name="penggalang" type="text"
                       required maxlength="150"
                       value="{{ old('penggalang', $kampanye->penggalang) }}"
                       placeholder="{{ __('Masukkan nama penggalang dana') }}"
                       class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                @error('penggalang')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="mb-2 block text-sm font-bold text-stone-700">{{ __('Deskripsi Kampanye') }}</label>
                <textarea id="deskripsi" name="deskripsi" rows="6" maxlength="5000"
                          placeholder="{{ __('Jelaskan kondisi, tujuan penggalangan dana, dan bagaimana dana akan digunakan.') }}"
                          class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">{{ old('deskripsi', $kampanye->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi_en" class="mb-2 block text-sm font-bold text-stone-700">{{ __('Deskripsi Kampanye (Bahasa Inggris)') }}</label>
                <textarea id="deskripsi_en" name="deskripsi_en" rows="5" maxlength="5000"
                          placeholder="{{ __('Campaign description in English') }}"
                          class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">{{ old('deskripsi_en', $kampanye->deskripsi_en) }}</textarea>
                @error('deskripsi_en')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="tahun_mulai" class="mb-2 block text-sm font-bold text-stone-700">{{ __('Tahun Mulai') }}<span class="text-red-500">*</span>
                    </label>
                    <input id="tahun_mulai" name="tahun_mulai" type="number"
                           min="2000" max="{{ date('Y') }}" required
                           value="{{ old('tahun_mulai', $kampanye->tahun_mulai ?? date('Y')) }}"
                           class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                    @error('tahun_mulai')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="target_dana" class="mb-2 block text-sm font-bold text-stone-700">{{ __('Target Dana (Rupiah)') }}<span class="text-red-500">*</span>
                    </label>
                    <input id="target_dana" name="target_dana" type="number"
                           min="100000" required
                           value="{{ old('target_dana', $kampanye->target_dana) }}"
                           placeholder="{{ __('Contoh: 10000000') }}"
                           class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                    @error('target_dana')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t border-stone-100 pt-5">
                <h2 class="text-lg font-bold text-stone-800">{{ __('Informasi Sumber') }}</h2>
                <p class="mt-1 text-sm text-stone-500">{{ __('Isi informasi sumber atau referensi yang mendukung kampanye.') }}</p>

                <div class="mt-4 space-y-4">
                    <div>
                        <label for="sumber_nama" class="mb-2 block text-sm font-bold text-stone-700">{{ __('Nama Sumber') }}</label>
                        <input id="sumber_nama" name="sumber_nama" type="text" maxlength="150"
                               value="{{ old('sumber_nama', $kampanye->sumber_nama) }}"
                               placeholder="{{ __('Nama lembaga, berita, atau sumber informasi') }}"
                               class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                        @error('sumber_nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sumber_url" class="mb-2 block text-sm font-bold text-stone-700">{{ __('URL Sumber') }}</label>
                        <input id="sumber_url" name="sumber_url" type="url" maxlength="500"
                               value="{{ old('sumber_url', $kampanye->sumber_url) }}"
                               placeholder="https://contoh.com"
                               class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                        @error('sumber_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sumber_tanggal" class="mb-2 block text-sm font-bold text-stone-700">{{ __('Tanggal Sumber') }}</label>
                        <input id="sumber_tanggal" name="sumber_tanggal" type="date"
                               value="{{ old('sumber_tanggal', $kampanye->sumber_tanggal?->format('Y-m-d')) }}"
                               class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
                        @error('sumber_tanggal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-stone-100 pt-5">
                <label for="gambar" class="mb-2 block text-sm font-bold text-stone-700">{{ __('Foto Kampanye') }}</label>

                @if ($kampanye->exists && $kampanye->gambar)
                    <div class="mb-4">
                        <img src="{{ $kampanye->gambar_url }}"
                             alt="Foto kampanye saat ini"
                             class="h-48 w-full rounded-xl object-cover sm:w-72">

                        <label class="mt-3 flex items-center gap-2 text-sm text-red-600">
                            <input type="checkbox" name="hapus_gambar" value="1"
                                   class="rounded border-stone-300 text-red-600 focus:ring-red-500">{{ __('Hapus foto saat ini') }}</label>
                    </div>
                @endif

                <input id="gambar" name="gambar" type="file"
                       accept=".jpg,.jpeg,.png,.webp"
                       class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-teal-50 file:px-4 file:py-2 file:font-semibold file:text-teal-700">
                <p class="mt-2 text-xs text-stone-500">{{ __('Format JPG, JPEG, PNG, atau WEBP. Maksimal ukuran 3 MB.') }}</p>
                @error('gambar')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-wrap justify-end gap-3 border-t border-stone-100 pt-5">
                <a href="{{ route('penggalang.kampanye.index') }}"
                   class="rounded-xl border border-stone-300 px-5 py-3 text-sm font-bold text-stone-600 hover:bg-stone-50">{{ __('Batal') }}</a>

                <button type="submit"
                        class="rounded-xl bg-teal-700 px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-teal-800">
                    {{ $kampanye->exists ? 'Simpan Perubahan' : 'Ajukan Kampanye' }}
                </button>
            </div>
        </form>
    </div>
</x-shell>
