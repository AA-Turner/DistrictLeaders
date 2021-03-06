<?php
declare(strict_types=1);

namespace App\Test\TestCase\Command;

use Cake\Console\Command;
use Cake\Core\Configure;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Class InstallBaseCommandTest
 *
 * @package App\Test\TestCase\Command
 * @uses \App\Command\PasswordCommand
 */
class PasswordCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UserStates',
        'app.Users',
        'app.CapabilitiesRoleTypes',
        'app.Capabilities',
        'app.ScoutGroups',
        'app.SectionTypes',
        'app.RoleTemplates',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.Audits',
    ];

    private $configArray = [
        'username' => 'JoeBloggs',
        'email' => 'webmaster@4thgoat.org.uk',
        'first_name' => 'Jacob',
        'last_name' => 'Tyler',
        'membership_number' => '12345',
        'postcode' => 'ABC 9DE',
    ];

    /**
     * Setup Function
     *
     * @throws \Exception
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures();
        $this->useCommandRunner();

        Configure::write('DefaultAdmin', $this->configArray);
    }

    /**
     * Description Output
     *
     * @return void
     */
    public function testDescriptionOutput()
    {
        $this->exec('password --help');
        $this->assertOutputContains('Set a the default user password.');
    }

    /**
     * Description Output
     *
     * @return void
     */
    public function testPasswordUpdate()
    {
        $this->exec('password Cheese');
        $this->assertExitCode(Command::CODE_SUCCESS);

        $this->assertOutputContains('User created.');
        $this->assertOutputContains('User updated with Password.');

        $this->exec('password');
        $this->assertExitCode(Command::CODE_ERROR);
        $this->assertErrorContains('Password not listed.');

        $this->exec('password Goat');
        $this->assertExitCode(Command::CODE_SUCCESS);

        $out = (array)$this->_out;
        $out = $out[' * _out'];

        TestCase::assertEquals($out[0], '<info>User created.</info>');
        TestCase::assertNotEquals($out[2], '<info>User created.</info>');
        $this->assertOutputContains('User updated with Password.');

        $config = $this->configArray;
        $config['email'] = 'webmaster@4thgoat.porg.uk';
        Configure::write('DefaultAdmin', $config);

        $this->exec('password Cheese');
        $this->assertExitCode(Command::CODE_ERROR);

        $this->assertErrorContains('You must use a Scouting Email Address');
        $this->assertErrorContains('User could not be saved.');
    }
}
