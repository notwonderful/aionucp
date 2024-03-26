<?php

namespace App\Enums\Game;

enum AbyssRankName: int
{
    case GRADE_9_SOLDIER = 1;
    case GRADE_8_SOLDIER = 2;
    case GRADE_7_SOLDIER = 3;
    case GRADE_6_SOLDIER = 4;
    case GRADE_5_SOLDIER = 5;
    case GRADE_4_SOLDIER = 6;
    case GRADE_3_SOLDIER = 7;
    case GRADE_2_SOLDIER = 8;
    case GRADE_1_SOLDIER = 9;
    case STAR_1_OFFICER = 10;
    case STAR_2_OFFICER = 11;
    case STAR_3_OFFICER = 12;
    case STAR_4_OFFICER = 13;
    case STAR_5_OFFICER = 14;
    case GENERAL = 15;
    case GREAT_GENERAL = 16;
    case COMMANDER = 17;
    case SUPREME_COMMANDER = 18;

     public function getRankName(): string
     {
         return match ($this) {
             self::GRADE_9_SOLDIER => __('Grade 9 Soldier'),
             self::GRADE_8_SOLDIER => __('Grade 8 Soldier'),
             self::GRADE_7_SOLDIER => __('Grade 7 Soldier'),
             self::GRADE_6_SOLDIER => __('Grade 6 Soldier'),
             self::GRADE_5_SOLDIER => __('Grade 5 Soldier'),
             self::GRADE_4_SOLDIER => __('Grade 4 Soldier'),
             self::GRADE_3_SOLDIER => __('Grade 3 Soldier'),
             self::GRADE_2_SOLDIER => __('Grade 2 Soldier'),
             self::GRADE_1_SOLDIER => __('Grade 1 Soldier'),
             self::STAR_1_OFFICER => __('1 Star Officer'),
             self::STAR_2_OFFICER => __('2 Star Officer'),
             self::STAR_3_OFFICER => __('3 Star Officer'),
             self::STAR_4_OFFICER => __('4 Star Officer'),
             self::STAR_5_OFFICER => __('5 Star Officer'),
             self::GENERAL => __('General'),
             self::GREAT_GENERAL => __('Great General'),
             self::COMMANDER => __('Commander'),
             self::SUPREME_COMMANDER => __('Supreme Commander'),
             default => '-',
         };
     }
}
