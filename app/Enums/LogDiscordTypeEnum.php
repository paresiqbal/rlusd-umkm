<?php
namespace App\Enums;

enum LogDiscordTypeEnum: string {
    case ERROR = "error";
    case WARNING = "warning";
    case INFO = "info";
}
