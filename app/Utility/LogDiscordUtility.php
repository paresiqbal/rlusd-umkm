<?php
namespace App\Utility;

use App\Enums\LogDiscordTypeEnum;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LogDiscordUtility
{
    /**
     * Send a log to Discord Webhook. If message is an exception, it will be converted to a Java style exception trace.
     * @param \App\Enums\LogDiscordTypeEnum $type
     * @param string $title
     * @param \Exception|string|array $message
     * @return void
     */
    public static function sendLog(LogDiscordTypeEnum $type, string $title, Exception|string|array $message)
    {
        $messageRes = $message;
        if ($message instanceof Exception) {
            $messageRes = self::jTraceEx($message);
        }
        $webhookUrl = env("DISCORD_LOG_WEBHOOK_URL");
        if (empty($webhookUrl)) {
            Log::info("DISCORD_LOG_WEBHOOK_URL not defined, if you don't want to use this, please set the DISCORD_LOG_ENABLE = false.");
            return;
        }
        $content = [
            'embeds' => [
                [
                    'title' => $title,
                    'description' => is_array($messageRes) ? json_encode($messageRes) : $messageRes,
                    'color' => self::getColor($type),
                ],
            ],
        ];
        Log::info(json_encode($content));
        try {
            $client = new Client();
            $client->post($webhookUrl, [
                'json' => $content,
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }

    }

    private static function getColor(LogDiscordTypeEnum $type): int
    {
        return match ($type) {
            LogDiscordTypeEnum::ERROR => 0xFF0000,
            LogDiscordTypeEnum::WARNING => 0xFFA500,
            default => 0x00FF00
        };
    }

    /**
     * jTraceEx() - provide a Java style exception trace
     * @param $exception
     * @param $seen      - array passed to recursive calls to accumulate trace lines already seen
     *                     leave as NULL when calling this function
     * @return string array of strings, one entry per trace line
     */
    public static function jTraceEx($e, $seen = null)
    {
        $starter = $seen ? 'Caused by: ' : '';
        $result = array();
        if (!$seen) {
            $seen = array();
        }

        $trace = $e->getTrace();
        $prev = $e->getPrevious();
        $result[] = sprintf('%s%s: %s', $starter, get_class($e), $e->getMessage());
        $file = $e->getFile();
        $line = $e->getLine();
        while (true) {
            $current = "$file:$line";
            if (is_array($seen) && in_array($current, $seen)) {
                $result[] = sprintf(' ... %d more', count($trace) + 1);
                break;
            }
            $result[] = sprintf(
                ' at %s%s%s(%s%s%s)',
                count($trace) && array_key_exists('class', $trace[0]) ? str_replace('\\', '.', $trace[0]['class']) : '',
                count($trace) && array_key_exists('class', $trace[0]) && array_key_exists('function', $trace[0]) ? '.' : '',
                count($trace) && array_key_exists('function', $trace[0]) ? str_replace('\\', '.', $trace[0]['function']) : '(main)',
                $line === null ? $file : basename($file),
                $line === null ? '' : ':',
                $line === null ? '' : $line
            );
            if (is_array($seen)) {
                $seen[] = "$file:$line";
            }

            if (!count($trace)) {
                break;
            }

            $file = array_key_exists('file', $trace[0]) ? $trace[0]['file'] : 'Unknown Source';
            $line = array_key_exists('file', $trace[0]) && array_key_exists('line', $trace[0]) && $trace[0]['line'] ? $trace[0]['line'] : null;
            array_shift($trace);
        }
        $result = join("\n", $result);
        if ($prev) {
            $result .= "\n" . self::jTraceEx($prev, $seen);
        }

        return $result;
    }
}
