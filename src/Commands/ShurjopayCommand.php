<?php

namespace Yahrdy\Shurjopay\Commands;

use Illuminate\Console\Command;

class ShurjopayCommand extends Command
{
    public $signature = 'shurjopay';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
