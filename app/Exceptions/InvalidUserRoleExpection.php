<?php

namespace App\Exceptions;

use Exception;

class InvalidUserRoleExpection extends Exception
{
    public static function invalidUserGiven()
    {
        throw new static("Ungültiger Benutzer übergeben");
    }

    public static function invalidLeagueGiven()
    {
        throw new static("Ungültiger Träger übergeben");
    }

    public static function invalidRoleGiven()
    {
        throw new static("Ungültige Berechtigung übergeben");
    }

    public static function userNotInLeague($username, $leaguename)
    {
        throw new static("$username gehört nicht zum Träger $leaguename");
    }
}
