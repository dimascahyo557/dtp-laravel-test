<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function setLanguage(string $code): RedirectResponse
    {
        return redirect()->back()->withCookie('lang', $code);
    }
}
