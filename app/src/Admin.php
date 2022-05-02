<?php

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin;

use UserFrosting\Sprinkle\SprinkleReceipe;

class Admin implements SprinkleReceipe
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'Admin Sprinkle';
    }

    /**
     * {@inheritdoc}
     */
    public static function getPath(): string
    {
        return __DIR__ . '/../';
    }

    /**
     * {@inheritdoc}
     */
    public static function getBakeryCommands(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getSprinkles(): array
    {
        return [];
    }

    /**
     * Returns a list of routes definition in PHP files.
     *
     * @return string[]
     */
    public static function getRoutes(): array
    {
        return [];
    }

    /**
     * Returns a list of all PHP-DI services/container definitions files.
     *
     * @return string[]
     */
    public static function getServices(): array
    {
        return [];
    }
}