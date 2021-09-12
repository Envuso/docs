<?php

namespace App\Http\Controllers;

use App\Services\Documentation;
use Arr;
use Str;

class DocumentationController extends Controller
{
    public function redirect()
    {
        return redirect(Arr::first(Documentation::versionLinks())['url']);
    }

    public function page($page)
    {
        Documentation::setVersion(Str::before($page, '/'));

        $page = Documentation::getPage($page);

        if (!$page) {
            abort(404);
        }

        if (request()->isJson() || request()->wantsJson()) {
            return response()->json($page);
        }

        return view('docs', $page);
    }

}
