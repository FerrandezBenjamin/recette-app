<?php

namespace App\Notifications;

use App\Models\Dish;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DishCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $dish;

    public function __construct(Dish $dish)
    {
        $this->dish = $dish;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre recette est en ligne !')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Votre recette "' . $this->dish->name . '" est maintenant publiée sur le site.')
            ->action('Voir ma recette', url('/dishes/' . $this->dish->id));
    }
}
