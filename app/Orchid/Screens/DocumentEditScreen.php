<?php

namespace App\Orchid\Screens;

use App\Models\Document;
use App\Models\Dossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DocumentEditScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        // dd(Auth::user());
        return [
            'user' =>Auth::user()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'documment du dossier et preuve de paiement';
    }

    public function description(): ?string
    {
        return 'Fournissez les documents constituant du dossier et les preuves de paiement.';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Enregistrer'))
                ->icon('check')
                ->confirm(__('Voulez-vous sauvegarder vos documents ?'))
                ->method('save'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(Layout::rows([
                Upload::make('user.dossier.bulletin5')
                    ->title('Bulletin quatième')
                    ->maxFiles(1)
                    ->maxFileSize(0.46)
                    ->acceptedFiles('.jpg,.png,.pdf')
                    ->popover('taille max: (46), type: (.png, .jpg, .pdf)'),

                Upload::make('user.dossier.bulletin6')
                    ->title('Bulletin cinquième')
                    ->maxFiles(1)
                    ->maxFileSize(0.46)
                    ->acceptedFiles('.jpg,.png,.pdf')
                    ->popover('taille max: (46), type: (.png, .jpg, .pdf)'),

                Upload::make('user.dossier.attestation')
                    ->title('Diplôme ou attestation de réussite')
                    ->maxFiles(1)
                    ->maxFileSize(0.46)
                    ->acceptedFiles('.jpg,.png,.pdf')
                    ->popover('taille max: (46), type: (.png, .jpg, .pdf)'),
            ]))
                ->title('BULLETINS et DIPLOME')
                ->description('Insérez sur chaque champ correspondant, le bulletin scanner et veillez à la lisibilité du document.'),

            Layout::block(Layout::rows([
                Upload::make('user.dossier.bordereau')
                    ->title('Bordéreau')
                    ->maxFiles(1)
                    ->maxFileSize(0.46)
                    ->acceptedFiles('.jpg,.png,.pdf')
                    ->popover('taille max: (46), type: (.png, .jpg, .pdf)'),
            ]))
                ->title('PREUVES DE PAIEMENT')
                ->description('Insérez sur chaque champ correspondant, la preuve de paiement et veillez à la lisibilité du document.'),
        ];
    }


    public function save(Request $request)
    {

        $request->validate([
            'bulletin5' => 'required',
            'bulletin6' => 'required',
            'attestation' => 'required',
            'bordereau' => 'required',
        ]);
// dd($request->input('bulletin5'));

        Dossier::create([
            'user_id' => Auth::user()->id,
            'bulletin5' => $request->input('bulletin5')[0],
            'bulletin6' => $request->input('bulletin6')[0],
            'attestation' => $request->input('attestation')[0],
            'bordereau' => $request->input('bordereau')[0],
        ]);

        Toast::info('dossier enregisté !');
        Alert::success('<strong>Succès: 😇!!! </strong>Votre dossier a été enregistré avec <strong> succès!😇.</strong>.');
        return redirect()->back();

    }
}
