<?php

namespace Tests\Unit;

use App\Services\Crawler;
use PHPUnit\Framework\TestCase;

class CrawlerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_token_deobfuscator()
    {
        $input = '55604z21vw1w48zz7y14219x81052zwz';
        $response = '44395a78ed8d51aa2b85780c18947ada';
        $crawler = new Crawler();
        $this->assertEquals(
            $crawler->deObfuscateToken($input),
            $response
        );
    }
}
