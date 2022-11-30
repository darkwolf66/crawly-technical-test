<?php

namespace App\Http\Controllers;

use App\Services\Crawler;
use Illuminate\Http\Request;
use Mockery\Exception;

class CrawlerAnswer extends Controller
{
    public function crawlyAnswer(){
        $crawler = new Crawler();
        try {
            $answer = $crawler->getCrawlyCurrentAnswer();
        }catch (Exception $e){
            return response()->json($e, 400);
        }
        return response()->json([
            'answer' => $answer
        ]);
    }
}
