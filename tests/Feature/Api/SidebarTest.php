<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidebarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    public function test_pengunjung_memakai_navbar_atas_bukan_sidebar(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertDontSee('<aside', false)
            ->assertSee(route('login'), false);
    }

    public function test_admin_melihat_sidebar_lengkap(): void
    {
        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('<aside', false)
            ->assertSee(route('admin.pengguna.index'), false)
            ->assertSee(route('laporan.index'), false)
            ->assertSee(route('logout'), false);
    }

    public function test_donatur_tidak_melihat_menu_admin_di_sidebar(): void
    {
        $donatur = User::factory()->create()->assignRole('donatur');

        $this->actingAs($donatur)->get(route('kampanye.index'))
            ->assertOk()
            ->assertSee('<aside', false)
            ->assertSee(route('pengajuan-penggalang-dana.create'), false)
            ->assertDontSee(route('admin.pengguna.index'), false)
            ->assertDontSee(route('laporan.index'), false);
    }

    public function test_penggalang_tidak_melihat_menu_ajukan_jadi_penggalang(): void
    {
        $penggalang = User::factory()->create()->assignRole('penggalang_dana');

        $this->actingAs($penggalang)->get(route('penggalang.dashboard'))
            ->assertOk()
            ->assertSee(route('penggalang.kampanye.index'), false)
            ->assertDontSee(route('pengajuan-penggalang-dana.create'), false);
    }
}
