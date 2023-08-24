<?php

namespace Modules\Essentials\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Essentials\Entities\EssentialsTodoComment;

class AddNewCommentNotification extends Notification
{
    use Queueable;

    protected EssentialsTodoComment $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( EssentialsTodoComment $comment)
    {
        $this->comment = $comment;
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
      ->greeting(__('essentials::lang.new_comment'))
      ->line($this->comment->added_by->getUserFullNameAttribute() )
      ->line( strip_tags(__('essentials::lang.new_task_comment_notification', ['added_by' => $this->comment->added_by->getUserFullNameAttribute(), 'task_id' => $this->comment->task->task_id]) ))
      ->action('Go To',action('\Modules\Essentials\Http\Controllers\ToDoController@show', $this->comment->task->id));
   
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
