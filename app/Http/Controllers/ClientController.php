<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\ClientApp;
use App\Models\ClientContract;
use App\Models\ClientType;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Server;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Client::with([
            'clientType',
            'picTim',
            'app.product',
            'app.server',
            'app.features',
            'contracts',
        ]);

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhereHas('clientType', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {

            switch ($request->status) {

                case 'active':
                    $query->where('status', 'active');
                    break;

                case 'expired':
                    $query->where('status', 'expired');
                    break;
            }
        }


        $selectedClientType = null;

        if ($request->filled('tipe')) {
            $selectedClientType = ClientType::find($request->tipe);

            $query->where('client_type_id', $request->tipe);
        }

        $selectedProduct = null;

        if ($request->filled('jenis')) {

            $selectedProduct = Product::find($request->jenis);

            $query->whereHas('app.product', function ($q) use ($request) {
                $q->where('products.id', $request->jenis);
            });
        }


        $perPage = $request->integer('per_page', 10);

        $clients = $query
            ->orderBy('nama')
            ->paginate($perPage)
            ->withQueryString();

        return view('clients.index', [
            'clients'     => $clients,
            'clientTypes' => ClientType::orderBy('nama')->get(),
            'selectedClientType' => $selectedClientType,
            'products'    => Product::orderBy('nama')->get(),
            'selectedProduct' => $selectedProduct,
            'user'        => Auth::user(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view(
            'clients.create',
            [
                'clientType' => ClientType::orderBy('nama')->get(),
                'products'   => Product::orderBy('nama')->get(),
                'servers'    => Server::orderBy('nama')->get(),
                'users'   => User::where('role', 'support')->orWhere('role', 'leader')
                    ->orderBy('name')
                    ->get(),
                'features'   => Feature::orderBy('nama_fitur')->get(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $validated = $request->validated();

        // Generate Kode Client
        $number = Client::withTrashed()->count() + 1;

        do {
            $kodeClient = 'CL-' . str_pad($number, 4, '0', STR_PAD_LEFT);
            $number++;
        } while (Client::withTrashed()->where('kode', $kodeClient)->exists());

        // Simpan Client
        $client = Client::create([
            'kode'            => $kodeClient,
            'nama'            => $validated['nama'],
            'client_type_id'  => $validated['client_type_id'],
            'pic_tim_id'      => $validated['pic_tim_id'],
        ]);

        // Simpan Aplikasi
        $app = ClientApp::create([
            'client_id'          => $client->id,
            'product_id'         => $validated['product_id'],
            'url_aplikasi'       => $validated['url_aplikasi'] ?? null,
            'jumsis'             => $validated['jumsis'] ?? 0,
            'kode_examol'        => $validated['kode_examol'] ?? null,
            'link_presensi'      => $validated['link_presensi'] ?? null,
            'aktivasi_aplikasi'  => $validated['aktivasi_aplikasi'] ?? null,
            'expired_aplikasi'   => $validated['expired_aplikasi'] ?? null,
            'expired_domain'     => $validated['expired_domain'] ?? null,
            'status'             => $validated['status'],
            'server_id'          => $validated['server_id'] ?? null,
            'catatan'            => $validated['catatan'] ?? null,
        ]);

        // Sync fitur
        if ($request->filled('fitur_ids')) {
            $app->features()->sync($request->fitur_ids);
        }

        // Simpan Kontrak
        if ($request->filled('nomor_kontrak') || $request->filled('tanggal_mulai') || $request->filled('tanggal_berakhir') || $request->hasFile('file')) {

            $filePath = null;

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('contracts', 'public');
            }

            ClientContract::create([
                'client_id'        => $client->id,
                'nomor_kontrak'    => $validated['nomor_kontrak'] ?? null,
                'tanggal_mulai'    => $validated['tanggal_mulai'] ?? null,
                'tanggal_berakhir' => $validated['tanggal_berakhir'] ?? null,
                'file'             => $filePath,
            ]);
        }

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client->load([
            'clientType',
            'picTim',
            'app.product',
            'app.server',
            'app.features',
            'app.accounts',
            'contracts',
        ]);

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $client->load([
            'clientType',
            'picTim',
            'app.product',
            'app.server',
            'app.features',
            'contracts',
        ]);

        return view('clients.edit', [
            'client'      => $client,
            'clientTypes' => ClientType::orderBy('nama')->get(),
            'products'    => Product::orderBy('nama')->get(),
            'servers'     => Server::orderBy('nama')->get(),
            'supports'    => User::where('role', 'support')
                ->orderBy('name')
                ->get(),
            'features'    => Feature::orderBy('nama_fitur')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $validated = $request->validated();

        // Update Client
        $client->update([
            'nama'           => $validated['nama'],
            'client_type_id' => $validated['client_type_id'],
            'pic_tim_id'     => $validated['pic_tim_id'],
        ]);

        // Cek apakah sudah punya aplikasi
        if ($client->app) {

            $client->app->update([
                'product_id'         => $validated['product_id'],
                'url_aplikasi'       => $validated['url_aplikasi'] ?? null,
                'jumsis'             => $validated['jumsis'] ?? 0,
                'kode_examol'        => $validated['kode_examol'] ?? null,
                'link_presensi'      => $validated['link_presensi'] ?? null,
                'aktivasi_aplikasi'  => $validated['aktivasi_aplikasi'] ?? null,
                'expired_aplikasi'   => $validated['expired_aplikasi'] ?? null,
                'expired_domain'     => $validated['expired_domain'] ?? null,
                'status'             => $validated['status'],
                'server_id'          => $validated['server_id'] ?? null,
                'catatan'            => $validated['catatan'] ?? null,
            ]);

            if ($request->filled('fitur_ids')) {
                $client->app->features()->sync($request->fitur_ids);
            } else {
                $client->app->features()->sync([]);
            }
        } else {

            $app = ClientApp::create([
                'client_id'          => $client->id,
                'product_id'         => $validated['product_id'],
                'url_aplikasi'       => $validated['url_aplikasi'] ?? null,
                'jumsis'             => $validated['jumsis'] ?? 0,
                'kode_examol'        => $validated['kode_examol'] ?? null,
                'link_presensi'      => $validated['link_presensi'] ?? null,
                'aktivasi_aplikasi'  => $validated['aktivasi_aplikasi'] ?? null,
                'expired_aplikasi'   => $validated['expired_aplikasi'] ?? null,
                'expired_domain'     => $validated['expired_domain'] ?? null,
                'status'             => $validated['status'],
                'server_id'          => $validated['server_id'] ?? null,
                'catatan'            => $validated['catatan'] ?? null,
            ]);

            if ($request->filled('fitur_ids')) {
                $app->features()->sync($request->fitur_ids);
            }
        }

        // ─── Update Kontrak ───
        $contract = $client->contracts()->first();

        if ($contract) {

            $contractData = [
                'nomor_kontrak'    => $validated['nomor_kontrak'] ?? null,
                'tanggal_mulai'    => $validated['tanggal_mulai'] ?? null,
                'tanggal_berakhir' => $validated['tanggal_berakhir'] ?? null,
            ];

            // Upload file baru jika ada
            if ($request->hasFile('file')) {
                $contractData['file'] = $request->file('file')->store('contracts', 'public');
            }

            $contract->update($contractData);
        } else {

            // Belum ada kontrak, buat baru
            $filePath = null;

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('contracts', 'public');
            }

            ClientContract::create([
                'client_id'        => $client->id,
                'nomor_kontrak'    => $validated['nomor_kontrak'] ?? null,
                'tanggal_mulai'    => $validated['tanggal_mulai'] ?? null,
                'tanggal_berakhir' => $validated['tanggal_berakhir'] ?? null,
                'file'             => $filePath,
            ]);
        }

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
