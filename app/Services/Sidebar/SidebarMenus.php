<?php

namespace App\Services\Sidebar;

use App\Services\Documentation;
use Illuminate\Support\Facades\Cache;

class SidebarMenus
{

    private $versionLinks = [];
    private $groups       = [];


    /**
     * @return SidebarItem[][]
     */
    public function menus(): array
    {
        return [
            '1.0' => $this->versionOne(),
            '2.0' => $this->versionTwo(),
        ];
    }


    /**
     * @return SidebarItem[]
     */
    public static function getMenu(): array
    {
        return (new static)->menus()[Documentation::getUserVersion()];
    }

    public static function clearCache()
    {
        $menus = new static();

        Cache::forget('links');
        Cache::forget('version-links');
        Cache::forget('groups');

        foreach (array_keys($menus->menus()) as $version) {
            Cache::tags([$version, 'links'])->flush();
        }
    }

    public static function versionLinks()
    {
        return Cache::get('version-links');
    }

    public static function groups()
    {
        return Cache::get('groups');
    }

    public static function cache()
    {
        $menus = new static();
        self::clearCache();

        $versions = [];
        foreach ($menus->menus() as $version => $items) {
            $links = [];
            foreach ($items as $item) {
                $links = array_merge($links, $menus->storeLink($item, $version));
            }
            $versions[$version] = $links;
        }

        Cache::put('links', $versions);
        Cache::put('version-links', $menus->versionLinks);
        Cache::put('groups', $menus->groups);
    }

    public function storeLink(SidebarItem $item, $version)
    {
        $link = [
            'title'    => $item->title(),
            'route'    => $item->route(),
            'rawRoute' => $item->rawRoute(),
        ];

        $links = [$link['rawRoute'] => $link];

        if (!isset($this->versionLinks[$version]) && $item->hasPages()) {
            $this->versionLinks[$version] = [
                'title' => $version,
                'url'   => $item->pages()[0]->route(),
            ];
        }

        Cache::tags([$version, 'links'])->put($item->rawRoute(), $link);

        if (!$item->hasParent()) {
            $this->groups[] = [
                'title' => $item->title(),
                'route' => $item->rawRoute(),
            ];
        }

        if ($item->hasPages()) {
            foreach ($item->pages() as $child) {
                $links = array_merge($links, $this->storeLink($child, $version));
            }
        }

        return $links;
    }

    public function versionOne()
    {
        return [
            new SidebarItem([
                'route' => '1.0/prologue',
                'title' => 'Prologue',
                'pages' => [
                    ['title' => 'Release notes', 'route' => '1.0/prologue/release-notes'],
                    ['title' => 'Contribute', 'route' => '1.0/prologue/contribute'],
                ],
                'sub'   => [],
            ]),
            new SidebarItem([
                'route' => '1.0/getting-started',
                'title' => 'Getting-started',
                'pages' => [
                    ['title' => 'Setup', 'route' => '1.0/getting-started/setup'],
                    ['title' => 'CLI', 'route' => '1.0/getting-started/cli'],
                ],
                'sub'   => [],
            ]),
            new SidebarItem([
                'route' => '1.0/http',
                'title' => 'Http',
                'pages' => [
                    ['title' => 'Routes', 'route' => '1.0/http/routes'],
                    ['title' => 'Request', 'route' => '1.0/http/request'],
                    ['title' => 'Response', 'route' => '1.0/http/response'],
                    ['title' => 'Controllers', 'route' => '1.0/http/controllers'],
                    ['title' => 'Middleware', 'route' => '1.0/http/middleware'],
                ],
                'sub'   => [],
            ]),
            new SidebarItem([
                'route' => '1.0/database',
                'title' => 'Database',
                'pages' => [
                    ['title' => 'Models', 'route' => '1.0/database/models'],
                    ['title' => 'Query builder', 'route' => '1.0/database/query-builder'],
                    ['title' => 'Seeders', 'route' => '1.0/database/seeders'],
                ],
                'sub'   => [],
            ]),
            new SidebarItem([
                'route' => '1.0/authentication',
                'title' => 'Authentication',
                'pages' => [
                    ['title' => 'Authentication', 'route' => '1.0/authentication/authentication'],
                    ['title' => 'Policies', 'route' => '1.0/authentication/policies'],
                ],
                'sub'   => [],
            ]),
            new SidebarItem([
                'route' => '1.0/websockets',
                'title' => 'Websockets',
                'pages' => [
                    ['title' => 'Server', 'route' => '1.0/websockets/server'],
                    ['title' => 'Client', 'route' => '1.0/websockets/client'],
                ],
                'sub'   => [],
            ]),
            new SidebarItem([
                'route' => '1.0/additional',
                'title' => 'Additional',
                'pages' => [
                    ['title' => 'Cache', 'route' => '1.0/additional/cache'],
                    ['title' => 'Data transfer objects', 'route' => '1.0/additional/data-transfer-objects'],
                    ['title' => 'Encryption/hashing', 'route' => '1.0/additional/encryption-hashing'],
                    ['title' => 'Storage', 'route' => '1.0/additional/storage'],
                ],
                'sub'   => [],
            ]),
        ];
    }

    private function versionTwo()
    {
        return [
            new SidebarItem([
                'route' => '2.0/prologue',
                'title' => 'Prologue',
                'pages' => [
                    ['title' => 'Release notes', 'route' => '2.0/prologue/release-notes'],
                    ['title' => 'Contribute', 'route' => '2.0/prologue/contribute'],
                ],
                'sub'   => [],
            ]),
            new SidebarItem([
                'route' => '2.0/getting-started',
                'title' => 'Getting-started',
                'pages' => [
                    ['title' => 'Setup', 'route' => '2.0/getting-started/setup'],
                    ['title' => 'CLI', 'route' => '2.0/getting-started/cli'],
                ],
                'sub'   => [],
            ]),
            new SidebarItem([
                'route' => '2.0/http',
                'title' => 'Http',
                'pages' => [
                    ['title' => 'Routes', 'route' => '2.0/http/routes'],
                    ['title' => 'Request', 'route' => '2.0/http/request'],
                    ['title' => 'Response', 'route' => '2.0/http/response'],
                    ['title' => 'Controllers', 'route' => '2.0/http/controllers'],
                    ['title' => 'Middleware', 'route' => '2.0/http/middleware'],
                ],
                'sub'   => [],
            ]),
            new SidebarItem([
                'route' => '2.0/database',
                'title' => 'Database',
                'pages' => [
                    ['title' => 'Models', 'route' => '2.0/database/models'],
                    ['title' => 'Query builder', 'route' => '2.0/database/query-builder'],
                    ['title' => 'Seeders', 'route' => '2.0/database/seeders'],
                ],
                'sub'   => [],
            ]),
            new SidebarItem([
                'route' => '2.0/authentication',
                'title' => 'Authentication',
                'pages' => [
                    ['title' => 'Authentication', 'route' => '2.0/authentication/authentication'],
                    ['title' => 'Policies', 'route' => '2.0/authentication/policies'],
                ],
                'sub'   => [],
            ]),
            new SidebarItem([
                'route' => '2.0/websockets',
                'title' => 'Websockets',
                'pages' => [
                    ['title' => 'Server', 'route' => '2.0/websockets/server'],
                    ['title' => 'Client', 'route' => '2.0/websockets/client'],
                ],
                'sub'   => [],
            ]),
            new SidebarItem([
                'route' => '2.0/additional',
                'title' => 'Additional',
                'pages' => [
                    ['title' => 'Cache', 'route' => '2.0/additional/cache'],
                    ['title' => 'Data transfer objects', 'route' => '2.0/additional/data-transfer-objects'],
                    ['title' => 'Encryption/hashing', 'route' => '2.0/additional/encryption-hashing'],
                    ['title' => 'Storage', 'route' => '2.0/additional/storage'],
                ],
                'sub'   => [],
            ]),
        ];
    }
}
