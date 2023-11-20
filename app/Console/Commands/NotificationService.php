<?php

namespace App\Console\Commands;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Console\Command;

class NotificationService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notification-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function sendNotificationByRoles($roles, $title, $body)
    {
        $credentialsPath = base_path(env('FIREBASE_CREDENTIALS'));
        Log::info("Firebase Credentials Path: $credentialsPath");
    
        $factory = (new Factory)->withServiceAccount($credentialsPath);
        $messaging = $factory->createMessaging();
    
        foreach ($roles as $role) {
            // Send a notification to all devices subscribed to a specific role
            $topic = 'role_' . $role;
    
            Log::info("Attempting to send notification to topic: $topic");
    
            $message = CloudMessage::withTarget('topic', $topic)
                ->withNotification(['title' => $title, 'body' => $body]);
    
            try {
                $messaging->send($message);
                Log::info("Notification sent successfully for role: $role");
            } catch (\Exception $e) {
                Log::error("Error sending notification for role $role: " . $e->getMessage());
            }
        }
    }
    
    public function sendNotificationById($id, $title, $body)
    {
        $credentialsPath = base_path(env('FIREBASE_CREDENTIALS'));
        Log::info("Firebase Credentials Path: $credentialsPath");

        $factory = (new Factory)->withServiceAccount($credentialsPath);
        $messaging = $factory->createMessaging();
        // Send a notification to all devices subscribed to a specific role
        $topic = 'id_' . $id;

        Log::info("Attempting to send notification to topic: $topic");
        $message = CloudMessage::withTarget('topic', $topic)
            ->withNotification(['title' => $title, 'body' => $body]);

        try {
            $messaging->send($message);
            Log::info("Notification sent successfully");
        } catch (\Exception $e) {
            Log::error("Error sending notification: " . $e->getMessage());
        }
    } 
    public function handle()
    {
        //
    }
}
