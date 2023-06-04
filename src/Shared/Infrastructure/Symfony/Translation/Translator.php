<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Translation;

use Symfony\Component\Translation\Translator as SymfonyTranslator;

final class Translator extends SymfonyTranslator
{
    private TranslationManagerInterface $translationManager;

    public function setTranslationManager(TranslationManagerInterface $translationManager)
    {
        $this->translationManager = $translationManager;
    }

    public function trans(?string $id, array $parameters = [], string $domain = null, string $locale = null): string
    {
        if (null === $locale && null !== $this->getLocale()) {
            $locale = $this->getLocale();
        }

        if (null === $locale) {
            $locale = $this->getFallbackLocales()[0]; // fallback locale
        }

        dd($locale);

        return parent::trans($id, $parameters, $domain, $locale);
    }
}