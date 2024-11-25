<?php

namespace Tests\Feature;

use App\Models\Color;
use App\Models\Link;
use App\Models\User;
use Database\Seeders\ColorsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinksTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ColorsSeeder::class);
    }

    public function test_a_guest_cannot_create_a_link()
    {
        $response = $this->post(route('link.store'));

        $response->assertRedirect(route('login'));
    }

    public function test_dashboard_is_displayed()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('dashboard'));

        $response->assertOk();
    }

    public function test_a_user_can_create_a_link()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('link.store', [
                'title'    => __('Google'),
                'url'      => 'https://google.com',
                'position' => 1,
                'color_id' => Color::firstOrFail()->id,
            ]));

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('links', [
            'title'     => __('Google'),
            'url'       => 'https://google.com',
            'color_id'  => 1,
            'user_id'   => $user->id,
        ]);
    }

    public function test_a_user_can_update_a_link()
    {
        $user = User::factory()->create();

        $this->test_a_user_can_create_a_link();

        $response = $this->actingAs($user)
            ->post(route('link.update', [
                'id'        =>  Link::firstOrFail()->id,
                'title'     =>  __('Yahoo!'),
                'url'       =>  'https://yahoo.com',
                'position'  =>  1,
                'color_id'  =>  Color::where('id', '>', 1)->firstOrFail()->id
            ]));

        $response->assertRedirect(route('link.edit', ['id' =>   Link::firstOrfail()->id]));

        $this->assertDatabaseHas('links',[
           'title'      =>  __('Yahoo!'),
           'url'        =>  'https://yahoo.com',
           'position'   =>  1,
           'color_id'   =>  Color::where('id', '>', 1)->firstOrFail()->id,
        ]);
    }

    public function test_a_user_can_delete_a_link()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->test_a_user_can_create_a_link();

        $this->post(route('link.destroy', [
            'id'    =>  Link::firstOrFail()->id,
        ]));

        $this->assertDatabaseEmpty('links');
    }
}
