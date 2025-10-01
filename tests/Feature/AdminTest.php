<?php

namespace Tests\Feature;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Tests\TestCase;

class AdminTest extends TestCase
{
    protected $admin;
    protected $fakeEventData;

    protected function setUp(): void
    {
        parent::setUp();

        // Fake user admin
        $this->admin = Mockery::mock('App\Models\User')->makePartial();
        $this->admin->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $this->admin->shouldReceive('getAttribute')->with('role')->andReturn('admin');

        // Fake Auth
        Auth::shouldReceive('user')->andReturn($this->admin);
        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('attempt')->andReturn(true);

        // Fake event data
        $this->fakeEventData = [
            'Titre' => 'Concert test',
            'Description' => 'Un super concert',
            'Date' => now()->addDays(10)->format('Y-m-d'),
            'type_id' => 1,
            'nom' => 'Concert Nom'
        ];
    }

    public function test_un_admin_peut_se_connecter_et_creer_un_evenement()
    {
        // 🔹 Étape 1 : login via formulaire
        $loginRequest = Mockery::mock(LoginRequest::class);
        $loginRequest->shouldReceive('validated')->andReturn([
            'email' => 'admin@test.com',
            'password' => 'password'
        ]);

        $authController = new AuthController();
        $loginResponse = $authController->login($loginRequest);

        // Vérification que la redirection après login est ok
        $this->assertEquals(302, $loginResponse->getStatusCode());
        $this->assertEquals(route('app.index'), $loginResponse->getTargetUrl());

        // 🔹 Étape 2 : création d'un événement
        $mockEvent = Mockery::mock('alias:' . Event::class);
        $mockEvent->shouldReceive('create')
            ->once()
            ->with($this->fakeEventData)
            ->andReturn(new Event($this->fakeEventData));

        Gate::shouldReceive('authorize')
            ->with('create', Event::class)
            ->andReturnTrue();

        $storeRequest = Mockery::mock(StoreEventRequest::class);
        $storeRequest->shouldReceive('validated')->andReturn($this->fakeEventData);

        $eventController = new EventController();
        $response = $eventController->store($storeRequest);

        // Vérification que la redirection après création est ok
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('app.index'), $response->getTargetUrl());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}