<?php

namespace App\Orchid\Screens;

use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class AdmissionScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Résultat d’admission';
    }

    public function description(): ?string
    {
        return 'Vos informations sur l’admission';
    }
    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        // dd(Auth::user()->checkAutoAdmis());
        // dd(substr(Auth::user()->etude->pourcentage,0,2) > 60);
        return [
            // Layout::block(Layout::view('platform::partials.congrat'))
            //     ->title('Situation')
            //     ->description('Ici savoir si vous êtes admis'),

            Layout::view('platform::partials.congrat')->canSee(Auth::user()->checkAutoAdmis()),
            Layout::view('platform::partials.wrong')->canSee(!Auth::user()->checkAutoAdmis()),
            // Layout::view('platform::partials.wrong')
        ];
    }
}
