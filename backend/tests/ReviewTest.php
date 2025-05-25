<?php
// filepath: c:\xampp\htdocs\web-project\backend\tests\ReviewTest.php

use PHPUnit\Framework\TestCase;

class ReviewTest extends TestCase {
    public function setUp(): void
    {
        require_once __DIR__ . '/../vendor/autoload.php';
        require_once __DIR__ . '/../index.php';
        Flight::halt(false);  // prevent auto-exit during test
        Flight::start();      // start the app
    }

    public function testGetAllReviews()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/reviews';
        ob_start();
        Flight::start();
        $output = ob_get_clean();
        $this->assertEquals(200, http_response_code());
        $this->assertJson($output);
        // Optionally, check for expected structure
        $this->assertStringContainsString('data', $output);
    }

    public function testGetReviewById()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/reviews/1'; // Use an ID that exists in your test DB
        ob_start();
        Flight::start();
        $output = ob_get_clean();
        $this->assertEquals(200, http_response_code());
        $this->assertJson($output);
        $this->assertStringContainsString('"id":1', $output);
    }
}
