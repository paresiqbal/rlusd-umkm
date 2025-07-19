<?php
namespace App\Enums;

enum ToastTypeEnum: string {
    case SUCCESS = "success";
    case ERROR = "error";
    case WARNING = "warning";
    case INFO = "info";
}
