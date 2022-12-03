<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Layouts\Rows;

class ProfilePasswordLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Password::make('old_password')
                ->placeholder(__('Saisissez le mot de passe actuel'))
                ->title(__('Current password'))
                ->help('This is your password set at the moment.'),

            Password::make('password')
                ->placeholder(__('Saisissez le nouveau mot de passe'))
                ->title(__('Nouveau mot de passe')),

            Password::make('password_confirmation')
                ->placeholder(__('Saisissez le nouveau mot de passe'))
                ->title(__('confirmé nouveau mot de passe'))
                ->help('A good password is at least 15 characters or at least 8 characters long, including a number and a lowercase letter.'),
        ];
    }
}
