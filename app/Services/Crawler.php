<?php

namespace App\Services;

use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;

class Crawler
{
    public function getCrawlyCurrentAnswer()
    {
        $crawlyHTML = Http::get(env('CRAWLER_URL'));
        $crawlyCookies = $crawlyHTML->cookies();

        $documentPath = $this->getDocumentXPath($crawlyHTML);
        $inputTags = $this->getDocumentTagsByExpressionFromXPath('//input[@name="token"]', $documentPath);

        if (count($inputTags) <= 0)
            throw new Exception('No token input found, maybe code changed?');

        try {
            $token = $inputTags[0]->getAttribute("value");
        } catch (Exception $e) {
            throw new Exception('Error while extracting token form value of the input');
        }

        $deObfuscatedToken = $this->deObfuscateToken($token);

        if (count($crawlyCookies->toArray()) <= 0)
            throw new Exception('No token input found, maybe code changed?');

        $cookie = $crawlyCookies->toArray()[0];

        $headers = [
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Accept-Language' => 'en-US,en;q=0.9,pt-BR;q=0.8,pt;q=0.7,fr;q=0.6',
            'Cache-Control' => 'max-age=0',
            'Connection' => 'keep-alive',
            'Cookie' => 'PHPSESSID='.$cookie['Value'],
            'Origin' => 'http://applicant-test.us-east-1.elasticbeanstalk.com',
            'Referer' => 'http://applicant-test.us-east-1.elasticbeanstalk.com/',
            'Upgrade-Insecure-Requests' => 1,
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36'
        ];
        $crawlyHTML = Http::withHeaders($headers)
            ->withBody(
                'token='.$deObfuscatedToken, 'application/x-www-form-urlencoded'
            )
            ->post( env('CRAWLER_URL'));

        if($crawlyHTML->body() == 'Forbidden'){
            throw new Exception('Error, the de-obfuscator changed or more protection added!');
        }

        $documentPath = $this->getDocumentXPath($crawlyHTML);

        $tags = $this->getDocumentTagsByExpressionFromXPath('//span[@id="answer"]', $documentPath);
        if (count($tags) <= 0)
            throw new Exception('No answer found, maybe code changed?');

        try {
            $answer = $tags[0]->nodeValue;
        } catch (Exception $e) {
            throw new Exception('Error while extracting token form value of the input');
        }

        return $answer;
    }
    public function getDocumentXPath($html){
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        return new DOMXPath($dom);
    }
    public function getDocumentTagsByExpressionFromXPath($expression, $xpath){
        return $xpath->query($expression);
    }
    public function deObfuscateToken($originalToken){
        $replacements = ["a" => "z", "b" => "y", "c" => "x", "d" => "w", "e" => "v", "f" => "u", "g" => "t", "h" => "s", "i" => "r", "j" => "q", "k" => "p", "l" => "o", "m" => "n", "n" => "m", "o" => "l", "p" => "k", "q" => "j", "r" => "i", "s" => "h", "t" => "g", "u" => "f", "v" => "e", "w" => "d", "x" => "c", "y" => "b", "z" => "a", "0" => "9", "1" => "8", "2" => "7", "3" => "6", "4" => "5", "5" => "4", "6" => "3", "7" => "2", "8" => "1", "9" => "0"];
        $originalToken = str_split($originalToken);
        $resultToken = '';
        foreach ($originalToken as $originalTokenChar){
            $resultToken .= $replacements[$originalTokenChar];
        }
        return $resultToken;
    }
}
