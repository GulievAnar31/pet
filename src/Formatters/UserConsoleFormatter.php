<?php

namespace App\Formatters;

/** @param User[] $users */
class UserConsoleFormatter
{
    public function format($users): string
    {
        $formattedStr = "";

        if ($users === []) {
            return "Пользователей нет\n";
        }

        foreach ($users as $user) {
            $formattedStr .= "#{$user->getId()} {$user->getName()} {$user->getSurname()} <{$user->getEmail()}>\n";
        }

        return $formattedStr;
    }
}
