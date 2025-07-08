> This project is a work in progress, some of the features may not be fully implemented yet, and the API may change in future releases.

<p align="center">
    <img src="https://raw.githubusercontent.com/nunomaduro/pair/main/docs/logo.png" height="300" alt="Pair Logo">
    <p align="center">
        <a href="https://github.com/nunomaduro/pair/actions"><img alt="GitHub Workflow Status (main)" src="https://github.com/nunomaduro/pair/actions/workflows/tests.yml/badge.svg"></a>
        <a href="https://packagist.org/packages/nunomaduro/pair"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/nunomaduro/pair"></a>
        <a href="https://packagist.org/packages/nunomaduro/pair"><img alt="Latest Version" src="https://img.shields.io/packagist/v/nunomaduro/pair"></a>
        <a href="https://packagist.org/packages/nunomaduro/pair"><img alt="License" src="https://img.shields.io/packagist/l/nunomaduro/pair"></a>
    </p>
</p>

------
Pair stands for **Protocol for AI Rules**, and it aims to provide a standardized way to define and manage rules for AI editor/agents, ensuring you only maintain one set of AI rules under `.ai` folder, which can be used by multiple AI editors/agents.

> **Requires [PHP 8.3+](https://php.net/releases/)**

## Installation

You may install Pair using [Composer](https://getcomposer.org):

```bash
composer require nunomaduro/pair --dev
```

## Usage

> Supports: Cursor, Junie, Windsurf, and Cline.

You may run Pair using the `pair` command. Initially, this command will create a `.ai` directory in your project root, which will contain the configuration files for your AI rules.

```bash
./vendor/bin/pair install
```

Pair will add `.cursor`, `.junie`, etc, files to your project `.gitignore` file, if it exists, to prevent these files from being committed to your version control system.

Also, Pair will automatically add `./vendor/bin/pair sync` to your `composer.json` file under the `scripts` section, allowing you to run the sync command on every `composer install` or `composer update` command. This ensures that the AI rules are always in sync with the editors or agents you are using.

Of course, you can run the sync command manually at any time:

```bash
./vendor/bin/pair sync
```

**Pair** was created by **[Nuno Maduro](https://x.com/enunomaduro)** under the **[MIT license](https://opensource.org/licenses/MIT)**.
