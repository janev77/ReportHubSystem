<?php

namespace App\Listeners;

use App\Events\AnnouncementCreated;
use App\Mail\AnnouncementNotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendAnnouncementEmailNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $retryAfter = 3600;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Handle the event.
     */
    public function handle(AnnouncementCreated $event): void
    {
        $announcement = $event->announcement;
        $recipients = $this->getRecipients($announcement);

        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient->email)
                    ->send(new AnnouncementNotification($announcement));
            } catch (\Throwable $e) {
                logger()->error('Failed to send announcement email', [
                    'recipient' => $recipient->email,
                    'announcement_id' => $announcement->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Get the recipients based on the announcement's target.
     * Target can be 'all' or specific user IDs/emails
     */
    private function getRecipients($announcement)
    {
        $target = $announcement->target ?? ['all'];

        // If target includes 'all', send to all active users
        if (is_array($target) && in_array('all', $target)) {
            return User::where('is_active', true)->get();
        }

        // Handle the case where target contains user IDs or emails
        $query = User::where('is_active', true);

        if (is_array($target) && count($target) > 0) {
            // Try to query by ID if they look like IDs (numeric)
            $numericIds = array_filter($target, fn($id) => is_numeric($id));
            if (count($numericIds) > 0) {
                return $query->whereIn('id', $numericIds)->get();
            }

            // Otherwise treat them as emails
            return $query->whereIn('email', $target)->get();
        }

        return collect();
    }
}


