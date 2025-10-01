<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\EventController;
use App\Models\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Mockery;
use Carbon\Carbon;

class EventControllerTest extends TestCase
{
    protected $eventMock;
    protected $typeMock;

    /**
     * Configuration avant chaque test
     * Initialise les mocks statiques pour Event et Type
    */
    protected function setUp(): void
    {
        parent::setUp();

        $this->eventMock = Mockery::mock('alias:App\Models\Event');
        $this->typeMock = Mockery::mock('alias:App\Models\Type');
    }

    /**
     * Test de la méthode index du contrôleur EventController
     * Vérifie que la vue renvoyée est 'index' et contient la variable 'events'
     */
    public function test_function_index()
    {
        $fakeEvent = (object)[
            'Nom' => 'Conférence',
            'TypeId' => 1
        ];

        $this->eventMock->shouldReceive('all')->once()->andReturn([$fakeEvent]);

        $controller = new EventController();
        $response = $controller->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('index', $response->name());
        $this->assertArrayHasKey('events', $response->getData());
        $this->assertEquals([$fakeEvent], $response->getData()['events']);
    }

    /**
     * Test de la méthode create du contrôleur EventController
     * Vérifie l'autorisation et la présence de la variable 'types' dans la vue
     */
    public function test_function_create_authorize()
    {
        Gate::shouldReceive('authorize')
            ->once()
            ->with('create', Event::class)
            ->andReturn(true);

        $fakeType = (object)[
            'Nom' => 'Sport'
        ];

        $this->typeMock->shouldReceive('all')->once()->andReturn([$fakeType]);

        $controller = new EventController();
        $response = $controller->create();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('create', $response->name());
        $this->assertArrayHasKey('types', $response->getData());
        $this->assertEquals([$fakeType], $response->getData()['types']);
    }

    /**
     * Test de la méthode estPasse pour un événement passé
     * Vérifie que la méthode retourne true
    */
    public function test_estPasse_passe()
    {
        $fakeEvent = (object)[
            'Id' => 1,
            'Date' => Carbon::now()->subDays(3)->format('Y-m-d')
        ];

        $this->eventMock->shouldReceive('findOrFail')->with(1)->once()->andReturn($fakeEvent);

        $controller = new EventController();
        $this->assertTrue($controller->estPasse(1));
    }

    /**
     * Test de la méthode estPasse pour un événement futur
     * Vérifie que la méthode retourne false
    */
    public function test_estPasse_event_futur()
    {
        $fakeEvent = (object)[
            'Id' => 2,
            'Date' => Carbon::now()->addDays(5)->format('Y-m-d')
        ];

        $this->eventMock->shouldReceive('findOrFail')->with(2)->once()->andReturn($fakeEvent);

        $controller = new EventController();
        $this->assertFalse($controller->estPasse(2));
    }

    /**
     * Test de la méthode estPasse pour un événement sans date
     * Vérifie que la méthode retourne false
     */
    public function test_estPasse_event_sans_date()
    {
        $fakeEvent = (object)[
            'Id' => 3,
            'Date' => null
        ];

        $this->eventMock->shouldReceive('findOrFail')->with(3)->once()->andReturn($fakeEvent);

        $controller = new EventController();
        $this->assertFalse($controller->estPasse(3));
    }

    /**
     * Test de la méthode joursAvant pour un événement futur
     * Vérifie que la méthode retourne le nombre de jours correct avant l'événement
     */
    public function test_joursAvant_Ok() 
    {
        $fakeEvent = (object)[
            'Id' => 2,
            'Date' => Carbon::now()->addDays(10)->format('Y-m-d')
        ];

        $this->eventMock->shouldReceive('findOrFail')
            ->with(2)
            ->once()
            ->andReturn($fakeEvent);

        $controller = new EventController();
        $joursAvant = $controller->joursAvant(2);

        $this->assertEquals(10, $joursAvant);
    }

    /**
     * Test de la méthode joursAvant pour un événement passé
     * Vérifie que la méthode retourne 0
     */
    public function test_joursAvant_pour_un_evenement_passe() 
    {
        $fakeEvent = (object)[
            'Id' => 2,
            'Date' => Carbon::now()->subDays(10)->format('Y-m-d')
        ];

        $this->eventMock->shouldReceive('findOrFail')->with(2)->once()->andReturn($fakeEvent);

        $controller = new EventController();
        $joursAvant = $controller->joursAvant(2);

        $this->assertEquals(0, $joursAvant);
    }

    /**
     * Test de la méthode formatDate
     * Vérifie que la date est correctement formatée en "jour mois année"
     */
    public function test_formatDate_Ok()
    {
        $fakeEvent = (object)[
            'Id' => 2,
            'Date' => Carbon::now()->subDays(10)->format('Y-m-d')
        ];

        $this->eventMock->shouldReceive('findOrFail')->with(2)->once()->andReturn($fakeEvent);

        $controller = new EventController();
        $result = $controller->formatDate(2);

        $date = Carbon::now()->subDays(10);
        $mois = [
            1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
            5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
            9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'
        ];
        $expected = $date->format('d') . ' ' . $mois[(int)$date->format('m')] . ' ' . $date->format('Y');

        $this->assertEquals($expected, $result);
    }

    /**
     * Test de la méthode formatDate pour un événement sans date
     * Vérifie que la méthode retourne une chaîne vide
    */
    public function test_formatDate_Ko() 
    {
        $fakeEvent = (object)[
            'Id' => 2,
            'Date' => null
        ];

        $this->eventMock->shouldReceive('findOrFail')
            ->with(2)
            ->once()
            ->andReturn($fakeEvent);

        $controller = new EventController();
        $result = $controller->formatDate(2);

        $this->assertEquals('', $result);
    } 

    /**
     * Nettoyage après chaque test
     * Ferme correctement les mocks Mockery
    */
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}