<?php

namespace App\Listeners;

use App\Events\AnnouncementCreated;
use App\Mail\AnnouncementNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendAnnouncementEmailNotification
{

    /**
     * Handle the event.
     */
    public function handle(AnnouncementCreated $event): void
    {
        $announcement = $event->announcement;
        $recipients = $this->getRecipients($announcement);

        // Send emails synchronously without queue
        // Note: This will block the request until all emails are sent
        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient->email)
                    ->send(new AnnouncementNotification($announcement));
            } catch (\Exception $e) {
                // Log email sending errors silently
                \Illuminate\Support\Facades\Log::error('Failed to send announcement email', [
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


