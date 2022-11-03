<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class CursusScreen extends Screen
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
        return 'Interface du Cursus';
    }

    public function description(): ?string
    {
        return 'Vos informations sur le Cursus';
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
        return [
            Layout::tabs([
                '2018-2019' => Layout::view('platform::dummy.block'),
                '2019-2020' => Layout::view('platform::dummy.block'),
                '2020-2021' => Layout::view('platform::dummy.block'),
            ]),
        ];
    }
}
