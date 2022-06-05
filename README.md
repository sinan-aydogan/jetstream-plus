<p align="center"><img src="/art/logo.svg" alt="Logo Laravel Jetstream"></p>

<p align="center">
    <a href="https://github.com/laravel/jetstream/actions">
        <img src="https://github.com/laravel/jetstream/workflows/tests/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/laravel/jetstream">
        <img src="https://img.shields.io/packagist/dt/laravel/jetstream" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/laravel/jetstream">
        <img src="https://img.shields.io/packagist/v/laravel/jetstream" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/laravel/jetstream">
        <img src="https://img.shields.io/packagist/l/laravel/jetstream" alt="License">
    </a>
</p>

## Introduction
> This isn't offical Jetstream, but it's a collection of tools that I've found useful. It has multi-language support by [vue-i18n](https://vue-i18n.intlify.dev/).

Laravel Jetstream is a beautifully designed application scaffolding for Laravel. Jetstream provides the perfect starting point for your next Laravel application and includes login, registration, email verification, two-factor authentication, session management, API support via [Laravel Sanctum](https://github.com/laravel/sanctum), and optional team management.

Jetstream is designed using [Tailwind CSS](https://tailwindcss.com) and offers your choice of [Livewire](https://jetstream.laravel.com/2.x/stacks/livewire.html) or [Inertia](https://jetstream.laravel.com/2.x/stacks/inertia.html) scaffolding.

## Official Documentation

Documentation for Jetstream can be found on the [Jetstream website](https://jetstream.laravel.com).

Setup Directions
------

1. ```composer require sinan-aydogan/jetstream-plus```
2. ```php artisan jetstream:install inertia``` or ```php artisan jetstream:install inertia --teams```
3. ```npm install && npm run dev```
4. ```php artisan migrate --seed```
5. ```npm run hot```
6. ```php artisan serve```
7. ```Goto: http://localhost:8000```

# Multi-language support (Vue I18n and backend)

- You can add new languages to the project by adding a new language file to the `resources/Languages` directory like `bg.json`.
### bg.json
```json

{
    "product": {
        "create": {
            "title": "Създаване на продукт"
        }
    }
}
```
### usages
```javascript
<span v-text="$t('product.create.title')"/>
```
- You can add new flags to the `resources/Flags` directory then you should import them in the `resources/language.js`.
```javascript
import bgTranslates from '@/Languages/bg.json';
import flagBg from "@/Languages/Flags/flagBg";

/*Flags*/
const flags = {
    flagEn: flagEn,
    flagTr: flagTr,
    flagBg: flagBg,
};

/* Languages */
const languages = [
    { id: "en", name: "English", flag: "flagEn" },
    { id: "tr", name: "Türkçe", flag: "flagTr" },
    { id: "bg", name: "български", flag: "flagBg" },
];

/*Translates*/
const translates = {
    en: {
        ...jpTranslates.en,
        ...enTranslates
    },
    tr: {
        ...jpTranslates.tr,
        ...trTranslates
    },
    bg: {
        ...jpTranslates.bg,
        ...bgTranslates
    }
}
```

## Help

If you need to help more than this documentation:
- You can join our [Discord Channel](https://discord.gg/TnjA2GqYmw) then ask your questions
- Access to our [Tabbs page](https://tailadmin.tabbs.co/) for how to make links (Install in Linux, solution of the npm errors etc.)

### Premium Partners

> <a href="https://cleavr.io/" target="_blank"><img src="https://v1.tailadmin.dev/img/misc/cleavr_io_07092021_07092022.jpg" style="width: 200px" alt="Cleavr"/><br>
Cleavr is your all-in-one server and deployment management platform for your PHP and NodeJS apps. Provision,
deploy, monitor, backup, & more.
</a>

> :metal: If you want to support us, you can send a mail to us via [admin@tailadmin.dev](mailto:admin@tailadmin.dev)

## Contributing

Thank you for considering contributing to Jetstream Plus! You can read the contribution guide [here](.github/CONTRIBUTING.md).

## License

Laravel Jetstream is open-sourced software licensed under the [MIT license](LICENSE.md).
