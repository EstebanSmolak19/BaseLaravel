<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\EventController;
use App\Models\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Mockery;

class EventControllerTest extends TestCase
{
    /**
     * Fonction de Test sur la méthode Index de l'EventController. 
     * Permet de vérifier si la méthode renvoie la bonne vue.
     * @return void
     */
    public function test_function_index()
    {
        $eventMock = Mockery::mock('alias:App\Models\Event');

        $fakeEvent = (object)[
            'Nom' => 'Conférence',
            'TypeId' => 1
        ];

        // Mock la méthode all()
        $eventMock->shouldReceive('all')->once()->andReturn([$fakeEvent]);

        $controller = new EventController();
        $response = $controller->index();

        // Vérifie que la réponse est une vue
        $this->assertInstanceOf(View::class, $response);

        // Vérifie le nom de la vue
        $this->assertEquals('index', $response->name());

        // Vérifie que la vue contient bien la variable 'events'
        $this->assertArrayHasKey('events', $response->getData());

        // Vérifie que 'events' contient exactement notre événement factice
        $this->assertEquals([$fakeEvent], $response->getData()['events']);
    }

    /**
     * Fonction de Test sur la méthode Create de l'EventController.
     * Permet de vérifier si la méthode renvoie bien la bonne vue avec l'autorisation.
     * @return void
     */
    public function test_function_create_authorize() 
    {
        Gate::shouldReceive('authorize')
            ->once()
            ->with('create', Event::class)
            ->andReturn(true);

        $typeMock = Mockery::mock('alias:App\Models\Type');

        $fakeType = (object)[
            'Nom' => 'Sport'
        ];

        $typeMock->shouldReceive('all')->once()->andReturn([$fakeType]);

        $controller = new EventController();
        $response = $controller->create();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('create', $response->name());
        $this->assertArrayHasKey('types', $response->getData());
        $this->assertEquals([$fakeType], $response->getData()['types']);
    }

    // Important : permet de fermer correctement les mocks
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}