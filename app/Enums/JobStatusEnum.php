<?php

namespace App\Enums;

class JobStatusEnum
{
    const STATUSES = [
        1 => "İş Oluşturuldu",
        2 => "Konuma Gidiliyor",
        3 => "İşlemde",
        4 => "İş Tamamlandı",
    ];

    const INIT = 1;
    const GOING = 2;
    const IN_PROCESS = 3;
    const COMPLETED = 4;
}
