<?php
namespace Illuminate\Support\Facades;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomAuth extends Auth
{
    public static function isTeacher()
    {
        return (DB::table('nastavnici')->where('id_korisnik', $this->user()->id)->first())==null ? false : true;
    }
    public static function isStudent()
    {
        return (DB::table('studenti')->where('id_korisnika', $this->user()->id)->first())==null ? false : true;
    }
}