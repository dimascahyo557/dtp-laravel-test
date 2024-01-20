<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LanguageControllerTest extends TestCase
{
    public function testSetLanguage(): void
    {
        $backUrl = back()->getTargetUrl();
        
        $this->get(route('lang.set', 'en'))
            ->assertRedirect($backUrl)
            ->assertCookie('lang', 'en');
    }
}
