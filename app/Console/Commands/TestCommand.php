<?php

namespace App\Console\Commands;

use App\Helpers\OpenAIHelper;
use App\Models\Analysis;
use App\Models\AnalysisAnswers;
use App\Models\Package;
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
        $package_id = 2;
        $package = Package::find($package_id);
        $questions = $package->questions->pluck('content', 'id')->toArray();
        dd($questions);

    }
}
