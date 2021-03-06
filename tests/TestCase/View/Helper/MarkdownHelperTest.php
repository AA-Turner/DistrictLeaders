<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\MarkdownHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;
use Josbeir\Filesystem\FilesystemAwareTrait;

/**
 * App\View\Helper\MarkdownHelper Test Case
 */
class MarkdownHelperTest extends TestCase
{
    use FilesystemAwareTrait;

    /**
     * Test subject
     *
     * @var \App\View\Helper\MarkdownHelper
     */
    public $Markdown;

    /**
     * @var string Path Variable
     */
    private $testFile;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->testFile = TESTS . '/dummy_readme.md';

        $view = new View();
        $this->Markdown = new MarkdownHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Markdown);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        TestCase::assertClassHasAttribute('converter', '\App\View\Helper\MarkdownHelper');
    }

    /**
     * Test markdownToHtml method
     *
     * @return void
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \Josbeir\Filesystem\Exception\FilesystemException
     */
    public function testMarkdownToHtml()
    {
        $fileSystem = $this->getFilesystem('local');
        $fileDisk = $fileSystem->getDisk();

        $file = $fileSystem->upload($this->testFile);
        $markdownText = $fileDisk->read($file->getPath());
        TestCase::assertStringContainsString('# CakePHP Application Skeleton', $markdownText);
        TestCase::assertStringContainsString('[![Build Status](https://travis-ci.org/LBDistrictScouts/DistrictLeaders.svg?branch=Development)](https://travis-ci.org/LBDistrictScouts/DistrictLeaders)', $markdownText);
        TestCase::assertStringContainsString('Then visit `http://localhost:8765` to see the welcome page.', $markdownText);

        $htmlText = $this->Markdown->markdownToHtml($markdownText);

        TestCase::assertStringContainsString('<h1>CakePHP Application Skeleton</h1>', $htmlText);
        TestCase::assertStringContainsString('<a href="https://travis-ci.org/LBDistrictScouts/DistrictLeaders"><img src="https://travis-ci.org/LBDistrictScouts/DistrictLeaders.svg?branch=Development" alt="Build Status" /></a>', $htmlText);
        TestCase::assertStringContainsString('<p>Then visit <code>http://localhost:8765</code> to see the welcome page.</p>', $htmlText);
    }
}
