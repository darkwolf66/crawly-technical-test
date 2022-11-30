<?php

namespace App\Console\Commands;

use App\Services\Crawler;
use Illuminate\Console\Command;
use Mockery\Exception;

class CrawlerAnswer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawly:get-crawler-answer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns the crawler current answer';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $crawler = new Crawler();
        try {
            $answer = $crawler->getCrawlyCurrentAnswer();
        }catch (Exception $e){
            $this->error($e);
            return Command::FAILURE;
        }
        $this->info('The answer is '.$answer);

        return Command::SUCCESS;
    }
}
