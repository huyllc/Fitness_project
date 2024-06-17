<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRegister extends Notification
{
    use Queueable;
    /**
     * Create a new notification instance.
     */
    protected $user;
    protected $course;
    public function __construct($user, $course)
    {
        $this->user = $user;
        $this->course= $course;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // /**
    //  * Get the mail representation of the notification.
    //  */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'student_id' => $this->user->id,
            'course_id' => $this->course->id,
            'student_name' => $this->user->name,
            'course_title' => $this->course->title,
            'message' => " has registered for the course "
        ];
    }
}
