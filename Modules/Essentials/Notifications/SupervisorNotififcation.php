<?php

namespace Modules\Essentials\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class SupervisorNotififcation extends Notification
{
    use Queueable;

    protected User $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
      return ['mail'];
        
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
      return (new MailMessage)
      ->greeting('هذا الموظف خارج النطاق المحدد')
      ->line($this->user->getUserFullNameAttribute() )
      ->line(strip_tags(__('', ['assigned_by' => $this->user->getUserFullNameAttribute()]) ))
      ->line(strip_tags(__('', ['email' => $this->user->email]) ));
      // ->action('Go To',action('\Modules\Essentials\Http\Controllers\ToDoController@show', $this->user->id));
   
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
           
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
       
    }
}
