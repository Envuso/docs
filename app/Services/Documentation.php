<?php

namespace App\Services;

use App\Services\Sidebar\SidebarMenus;
use Arr;
use Cache;
use Illuminate\Support\Str;

class Documentation
{
    public static string $currentVersion = "2.0";

    public static function getUserVersion()
    {
        return request()->session()->get('version', Documentation::$currentVersion);
    }

    public static function clearCaches()
    {
        SidebarMenus::clearCache();
        DocumentationFileStructure::clearCache();
    }

    public static function cacheData()
    {
        SidebarMenus::cache();

        return DocumentationFileStructure::cache();
    }

    public static function versionLinks()
    {
        return SidebarMenus::versionLinks();
    }

    public static function setVersion($version)
    {
        $versions = array_keys(self::versionLinks());

        if (!in_array($version, $versions)) {
            $version = Arr::last($versions);
        }

        request()->session()->put('version', $version);
    }

    public static function getPage($page)
    {
        if (!Cache::tags('pages')->has($page)) {
            return null;
        }

        $page = Cache::tags('pages')->get($page);

        return array_merge($page, [
            'url'         => url($page['path']),
            'activeGroup' => self::activeGroup(),
        ]);
    }

    public static function activeGroup($page = null)
    {
        if ($page === null) {
            $page = request()->path();
        }

        $version = self::getUserVersion();

        foreach (SidebarMenus::groups() as $group) {
            if (!Str::startsWith($group['route'], $version)) {
                continue;
            }

            if (Str::is($group['route'] . '*', $page)) {
                return $group;
            }
        }

        return null;
    }

}
