<?php

namespace App\Console\Commands;

use App\Helpers\OpenAIHelper;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prompt = 'سلام چه خبره؟';
        $messages = [
            ['role' => 'user', 'content' => $prompt],
        ];
        $r = OpenAIHelper::chat($messages);
        dd($r);
    }
}
