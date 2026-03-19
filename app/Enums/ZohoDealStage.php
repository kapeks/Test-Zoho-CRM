<?php

namespace App\Enums;

enum ZohoDealStage: string
{
    case QUALIFICATION = 'Оценка пригодности';
    case ANALYSIS = 'Требуется анализ';
    case PROPOSAL = 'Ценностное предложение';
    case ID_DECISION_MAKERS = 'Идентификация ответственных за принятие решений';
    case QUOTE = 'Коммерческое предложение/Ценовое предложение';
    case NEGOTIATION = 'Переговоры /Оценка';
    case CLOSED_WON = 'Закрытые заключенные';
    case CLOSED_LOST = 'Закрытые упущенные';
    case CLOSED_LOST_COMPETITION = 'Закрытые и выигранные конкурентами';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
