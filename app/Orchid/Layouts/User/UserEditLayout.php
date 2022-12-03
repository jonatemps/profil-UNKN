<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [

            Cropper::make('user.profile_photo_path')
            ->title('Photo')
            ->width(500)
            ->height(500)
            ->horizontal(),

            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->disabled(Auth::user()->hasAccess('platform.systems.candidat'))
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->disabled(Auth::user()->hasAccess('platform.systems.candidat'))
                ->title(__('Email'))
                ->placeholder(__('Email')),
        ];
    }
}
