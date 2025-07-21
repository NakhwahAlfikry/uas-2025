<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Data penerimaan murid baru SMA Negeri 1 Ambarawa </h1>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Alamat</th>
                    <th class="border px-4 py-2">Tanggal Lahir</th>
                    <th class="border px-4 py-2">Sekolah Asal</th>
                    <th class="border px-4 py-2">Jenis Kelamin</th>
                    <th class="border px-4 py-2">Nama Orang Tua</th>
                    <th class="border px-4 py-2">Tanggal Daftar</th>
                    <th class="border px-4 py-2">Status</th>
                    
                </tr>
            </thead>
            <tbody>
                @if ($pendaftarans->isEmpty())
                    <tr>
                        <td colspan="8" class="border px-4 py-2 text-center">Tidak ada data pendaftaran.</td>
                    </tr>
                @else
                    @foreach ($pendaftarans as $data)
                        <tr>
                            <td class="border px-4 py-2">{{ $data->Nama }}</td>
                            <td class="border px-4 py-2">{{ $data->Alamat }}</td>
                            <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($data->Tanggal_Lahir)->format('d M Y') }}</td>
                            <td class="border px-4 py-2">{{ $data->Sekolah_Asal }}</td>
                            <td class="border px-4 py-2">{{ $data->Jenis_kelamin }}</td>
                            <td class="border px-4 py-2">{{ $data->Nama_Orangtua }}</td>
                            <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($data->Tanggal_Daftar)->format('d M Y') }}</td>
                            <td class="border px-4 py-2">{{ $data->Status }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>            
        </table>
    </div>
</div>
