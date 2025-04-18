<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('make_links_clickable', [$this, 'makeLinksClickable'], ['is_safe' => ['html']]),
        ];
    }

    public function makeLinksClickable(string $text): string
    {
        // Protège le texte puis transforme les URLs en liens cliquables
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        return preg_replace(
            '/(https?:\/\/[^\s]+)/i',
            '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>',
            $text
        );
    }
}
