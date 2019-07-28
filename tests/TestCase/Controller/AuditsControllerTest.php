<?php
namespace App\Test\TestCase\Controller;

use App\Controller\AuditsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Twig\Test\IntegrationTestCase;

/**
 * App\Controller\AuditsController Test Case
 */
class AuditsControllerTest extends TestCase
{
    use AppTestTrait;
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Users',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.SectionTypes',
        'app.ScoutGroups',
        'app.Audits',
        'app.Roles',
    ];

    /**
     * Test index method
     *
     * @return void
     *
     * @throws
     */
    public function testIndex()
    {
        $this->login();

        $this->get(['controller' => 'Audits', 'action' => 'index']);

        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     *
     * @throws
     */
    public function testView()
    {
        $this->login();

        $this->get(['controller' => 'Audits', 'action' => 'view', 1]);

        $this->assertRedirect(['controller' => 'Users', 'action' => 'view', 1]);
    }
}
