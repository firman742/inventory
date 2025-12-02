<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum SourceSerial: string
{
    use Values;

    case CAMERA = 'camera';
    case HARDWARE_SCANNER = 'hardware_scanner';
    case UPLOAD_IMAGE = 'upload_image';
    case MANUAL = 'manual';
}
