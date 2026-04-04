<?php

declare(strict_types=1);

namespace App\Services\Localization;

final readonly class TranslatableRuleBuilder
{
    /**
     * @param  list<string>  $locales
     */
    public function __construct(
        private array $locales,
        private string $defaultLocale,
    ) {}

    /**
     * Generate validation rules for translatable fields.
     *
     * @param  array<string, list<mixed>>  $fields  ['name' => ['string', 'max:255'], ...]
     * @return array<string, list<mixed>>
     */
    public function rules(array $fields): array
    {
        $result = [];

        foreach ($fields as $field => $fieldRules) {
            $result[$field] = ['required', 'array'];

            foreach ($this->locales as $locale) {
                $localeRules = $locale === $this->defaultLocale
                    ? ['required', ...$fieldRules]
                    : ['nullable', ...$fieldRules];

                $result["{$field}.{$locale}"] = $localeRules;
            }
        }

        return $result;
    }
}
