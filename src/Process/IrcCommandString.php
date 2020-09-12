<?php

namespace GhostZero\TmiCluster\Process;

use GhostZero\TmiCluster\PhpBinary;
use Illuminate\Support\Str;

class IrcCommandString
{
    public static string $command = 'exec @php artisan tmi:work';

    public static function fromOptions(ProcessOptions $param): string
    {
        $command = str_replace('@php', PhpBinary::path(), static::$command);

        return sprintf(
            "%s --uuid %s",
            $command,
            Str::uuid()
        );
    }
}
