<?php

namespace App\View\Components\Admin;

class Icon
{
    public static function renderSvg(string $name): string
    {
        $icons = [
            'home' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9.75 12 3l9 6.75V21a.75.75 0 0 1-.75.75h-4.5a.75.75 0 0 1-.75-.75v-4.5h-6V21a.75.75 0 0 1-.75.75H3.75A.75.75 0 0 1 3 21z"/></svg>',
            'document-text' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 6h6M9 12h6m-6 6h6M7.5 3h9a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-9a2.25 2.25 0 0 1-2.25-2.25V5.25A2.25 2.25 0 0 1 7.5 3z"/></svg>',
            'sparkles' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.813 15.904 9 21l-1.058-5.282A4.5 4.5 0 0 0 5.282 14L0 13l5.282-1A4.5 4.5 0 0 0 7.942 9.282L9 4l.813 5.096A4.501 4.501 0 0 0 11.473 12L16 13l-4.527 1a4.501 4.501 0 0 0-1.66 1.904zM17 4l.5 2.5L20 7l-2.5.5L17 10l-.5-2.5L14 7l2.5-.5zM20 14l.5 2.5L23 17l-2.5.5L20 20l-.5-2.5L17 17l2.5-.5z"/></svg>',
            'users' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 14a4 4 0 1 0-8 0v2a4 4 0 0 0 8 0zm6-2v2a4 4 0 0 1-3 3.872M2 12v2a4 4 0 0 0 3 3.872M12 6.5A3.5 3.5 0 1 1 8.5 3 3.5 3.5 0 0 1 12 6.5zm7-1A2.5 2.5 0 1 1 21.5 3 2.5 2.5 0 0 1 19 5.5zM5 5.5A2.5 2.5 0 1 1 7.5 3 2.5 2.5 0 0 1 5 5.5z"/></svg>',
        ];

        return $icons[$name] ?? '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="9" stroke-width="1.5" /></svg>';
    }
}
