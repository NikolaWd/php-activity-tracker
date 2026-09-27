<?php

declare(strict_types=1);

namespace App\Actions\Event;

use App\Core\Database;
use App\Enums\EventAction;
use App\Enums\EventTarget;

class RecordEvent
{
    public function execute(int $userId, EventAction $action, ?EventTarget $target = null): void
    {
        $validTarget = match ($action) {
            EventAction::Login, EventAction::Logout, EventAction::Registration => $target === null,
            EventAction::ViewPage => in_array($target, [EventTarget::PageA, EventTarget::PageB], true),
            EventAction::ButtonClick => in_array($target, [EventTarget::BuyCow, EventTarget::Download], true),
        };

        if (!$validTarget) {
            throw new \InvalidArgumentException('Invalid event action and target.');
        }

        $statement = Database::connection()->prepare(
            'INSERT INTO events (user_id, action, target) VALUES (:user_id, :action, :target)'
        );

        $statement->execute([
            'user_id' => $userId,
            'action' => $action->value,
            'target' => $target?->value,
        ]);
    }
}
