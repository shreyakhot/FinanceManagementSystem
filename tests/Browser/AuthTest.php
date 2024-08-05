namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;

/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="Register a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA


    public function testUserCanRegister()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'John Doe')
                    ->type('email', 'john@example.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Register')
                    ->assertSee('Registration successful');
        });
    }

    public function testUserCanLogin()
    {
        $user = \App\Models\User::factory()->create([
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertSee('Login successful');
        });
    }
}
