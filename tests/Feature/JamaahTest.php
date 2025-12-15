<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Jamaah;
use App\Models\Kategori;
use App\Models\Kegiatan;
use App\Models\Donasi;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JamaahTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {
        $payload = [
            'username' => 'arya123',
            'nama_lengkap' => 'Arya Test',
            'kata_sandi' => 'secret99',
            'jenis_kelamin' => 'L'
        ];

        $res = $this->postJson('/api/register', $payload);

        $res->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => ['user', 'token']
            ]);
    }

    /** @test */
    public function can_list_jamaah_with_pagination()
    {
        Jamaah::factory()->count(5)->create();

        $user = Jamaah::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $res = $this->getJson('/api/jamaah?per_page=2', [
            'Authorization' => 'Bearer '.$token
        ]);

        $res->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'data',
                    'current_page',
                    'per_page',
                    'total'
                ]
            ]);
    }

    /** @test */
    public function can_sync_kategori_for_jamaah()
    {
        $jamaah = Jamaah::factory()->create();
        $kategori = Kategori::factory()->create();

        $token = $jamaah->createToken('test')->plainTextToken;

        $res = $this->postJson("/api/jamaah/{$jamaah->id_jamaah}/sync-kategori", [
            'kategori_ids' => [$kategori->id_kategori],
            'periode' => '2025'
        ], [
            'Authorization' => 'Bearer '.$token
        ]);

        $res->assertStatus(200);

        $this->assertDatabaseHas('kategori_jamaah', [
            'id_jamaah' => $jamaah->id_jamaah,
            'id_kategori' => $kategori->id_kategori,
            'periode' => '2025'
        ]);
    }

    /** @test */
    public function can_daftar_kegiatan()
    {
        $jamaah = Jamaah::factory()->create();
        $kegiatan = Kegiatan::factory()->create();

        $token = $jamaah->createToken('test')->plainTextToken;

        $res = $this->postJson("/api/kegiatan/{$kegiatan->id_kegiatan}/daftar", [
            'id_jamaah' => $jamaah->id_jamaah
        ], [
            'Authorization' => 'Bearer '.$token
        ]);

        $res->assertStatus(200);

        $this->assertDatabaseHas('keikutsertaan_kegiatan', [
            'id_jamaah' => $jamaah->id_jamaah,
            'id_kegiatan' => $kegiatan->id_kegiatan
        ]);
    }

    /** @test */
    public function can_catat_donasi()
    {
        $jamaah = Jamaah::factory()->create();
        $donasi = Donasi::factory()->create();

        $token = $jamaah->createToken('test')->plainTextToken;

        $res = $this->postJson("/api/donasi/{$donasi->id_donasi}/catat", [
            'id_jamaah' => $jamaah->id_jamaah,
            'besar_donasi' => 50000
        ], [
            'Authorization' => 'Bearer '.$token
        ]);

        $res->assertStatus(200);

        $this->assertDatabaseHas('riwayat_donasi', [
            'id_jamaah' => $jamaah->id_jamaah,
            'id_donasi' => $donasi->id_donasi
        ]);
    }
}
