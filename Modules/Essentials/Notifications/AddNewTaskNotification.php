<?php

namespace Modules\Essentials\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Essentials\Entities\ToDo;

class AddNewTaskNotification extends Notification
{
    use Queueable;

    protected ToDo $task;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( ToDo $task)
    {
        $this->task = $task;
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
      ->greeting(__('essentials::lang.new_task_added'))
      ->line($this->task->name )
      ->line(strip_tags(__('essentials::lang.new_task_notification', ['assigned_by' => $this->task->assigned_by->getUserFullNameAttribute(), 'task_id' => $this->task->task_id]) ))
      ->action('Go To',action('\Modules\Essentials\Http\Controllers\ToDoController@show', $this->task->id));
   
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
