<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Handle localization.
     *
     * @param  $locale - language locale.
     * @return redirect back/
     */
    public function __invoke($locale)
    {
        return redirect()->back()->withCookie(cookie()->forever('language', $locale));
    }
}
