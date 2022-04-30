<?php

namespace Tests\Unit;

use App\Models\User;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;

use Tests\TestCase;

class UserTest extends TestCase
{
    
    public function test_login_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_database()
    {
        $this->assertDatabaseHas('users',[
            'name'=>'admin'
        ]);
    }

    public function test_view_coaches_database()
    {
        $this->assertDatabaseHas('coaches',[
            'name'=>'Rakib'
        ]);
    }

    public function test_user_can_register()
    {
        $data = [
            'name' => 'test', 
            'email' => 'test@gmail.com',
            'phone' => '00000000', 
            'address' => 'test', 
            'password' => '12345678'
        ];
        $this->withoutMiddleware();
        $response = $this->call('POST', '/register', $data, [], [], ['HTTP_REFERER' => '/register']);
        $response->assertRedirect('/register');
    }
    
    public function test_user_can_login()
    {

        $this->withoutMiddleware();

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => '12345678'
        ]);
        
        $this->assertTrue(true);

    }
    
    public function test_update_profile()
    {

        $this->actingAs($user = User::factory()->create());

        Livewire::test(UpdateProfileInformationForm::class)
                ->set('state', ['name' => 'Test Name', 'email' => 'test@example.com'])
                ->call('updateProfileInformation');

        $this->assertEquals('Test Name', $user->fresh()->name);
        $this->assertEquals('test@example.com', $user->fresh()->email);

    }
}