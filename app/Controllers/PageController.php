<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Actions\Cow\BuyCow;
use App\Actions\Event\RecordEvent;
use App\Core\Auth;
use App\Enums\EventAction;
use App\Enums\EventTarget;
use App\Repositories\CowPurchaseRepository;

class PageController
{
    public function pageA(): string
    {
        $userId = Auth::user()->getId();
        (new RecordEvent())->execute($userId, EventAction::ViewPage, EventTarget::PageA);

        return view('pages/a', [
            'pageTitle' => 'Page A',
            'hasPurchased' => (new CowPurchaseRepository())->hasPurchased($userId),
        ]);
    }

    public function buyCow(): string
    {
        if (!valid_csrf_token()) {
            http_response_code(403);
            return 'Invalid form token.';
        }

        (new BuyCow())->execute(Auth::user()->getId());

        header('Location: ' . route('page-a'), true, 303);
        return '';
    }

    public function pageB(): string
    {
        (new RecordEvent())->execute(Auth::user()->getId(), EventAction::ViewPage, EventTarget::PageB);

        return view('pages/b', ['pageTitle' => 'Page B']);
    }

    public function download(): string
    {
        if (!valid_csrf_token()) {
            http_response_code(403);
            return 'Invalid form token.';
        }

        $file = dirname(__DIR__, 2) . '/storage/downloads/demo.exe';

        if (!is_readable($file)) {
            http_response_code(500);
            return 'Download is not available.';
        }

        $contents = file_get_contents($file);

        if ($contents === false) {
            http_response_code(500);
            return 'Download is not available.';
        }

        (new RecordEvent())->execute(Auth::user()->getId(), EventAction::ButtonClick, EventTarget::Download);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="demo.exe"');
        header('Content-Length: ' . strlen($contents));
        header('X-Content-Type-Options: nosniff');

        return $contents;
    }
}
