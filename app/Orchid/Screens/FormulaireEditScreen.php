<?php

namespace App\Orchid\Screens;

use App\Models\Departement;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class FormulaireEditScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
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
        return 'Formulaire d\'inscription';
    }

    public function description(): ?string
    {
        return 'Remplissez les champs du formulaire d\'instcription.';
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
                Group::make([
                    Input::make('user.identite.nom')
                        ->title('Nom :')
                        ->placeholder('Saisisez votre Nom')
                        ->required(),

                    Input::make('user.identite.postnom')
                        ->title('Postnom :')
                        ->placeholder('Saisisez notre Postnom')
                        ->required(),
                ]),

                Group::make([
                    Input::make('user.identite.prenom')
                        ->title('Prenom :')
                        ->placeholder('Saisisez votre Prenom')
                        ->required(),

                    Select::make('user.identite.sexe')
                        ->options([
                            'Masculin'   => 'M',
                            'Féminin' => 'F',
                        ])
                        ->title('Sexe')
                        ->required()
                        ->help('Choisisez votre genre'),
                    ]),

                    Group::make([
                        Input::make('user.identite.lieu_naissance')
                            ->title('Lieu de naissance :')
                            ->placeholder('Saisisez votre lieu de naissance')
                            ->required(),

                        Input::make('user.identite.date_naissance')
                            ->type('date')
                            ->title('Date de naissance')
                            ->value('2005-08-19')
                            ->required(),
                    ]),

                    Group::make([
                        Input::make('user.identite.nationalite')
                            ->title('Nationnalité :')
                            ->placeholder('Saisisez votre nationnalité')
                            ->required(),

                        Input::make('user.identite.telephone')
                            ->mask('+999 999 999 999')
                            ->title('Téléphone')
                            ->placeholder('Saisisez votre numéro'),
                    ]),

                ]),
            )
                ->title('IDENTITE')
                ->description('Insérez-y des vraies informations relatives à votre identité car les fausses informations annuleront votre bulletin'),

            Layout::block(Layout::rows([
                Group::make([
                    Input::make('user.etude.province_ecole')
                        ->title('Province Ecole :')
                        ->placeholder('Saisisez la province de votre école')
                        ->required(),

                    Input::make('user.etude.nom_ecole')
                        ->title('Nom Ecole :')
                        ->placeholder('Saisisez le nom de votre école')
                        ->required(),
                ]),

                Group::make([
                    Input::make('user.etude.nom_centre')
                        ->title('nom du centre :')
                        ->placeholder('Saisisez le nom du centre')
                        ->required(),

                    DateTimer::make('user.etude.annee')
                        ->title('Année')
                        ->format('Y')
                        ->help('Selectionnez l\'année de l\'obtention du diplôme'),
                ]),

                Group::make([
                    Input::make('user.etude.section')
                        ->title('Section :')
                        ->placeholder('Saisisez votre section')
                        ->required(),

                    Input::make('user.etude.pourcentage')
                        ->mask('99 %')
                        ->title('Pourcentage :')
                        ->placeholder('Saisisez votre Pourcentage obtenu')
                        ->required(),
                ]),

                Input::make('user.etude.num_diplome')
                        ->title('Numéro diplôme :')
                        ->placeholder('Saisisez le numéro du diplôme.')
                        ->required(),
            ]))
                ->title('ÉTUDES SECONDAIRES FAITES')
                ->description('Insérez-y des vraies informations relatives à votre parcours scolaire car les fausses informations annuleront votre bulletin'),

            Layout::block(Layout::rows([

                    Input::make('user.occupation.activite_pro')
                        ->title('Activité professionnelle :'),

                    Input::make('user.occupation.etude_pre_univ')
                        ->title('Etude pré-universitaire :'),
            ]))
                ->title('OCCUPATIONS APRES LES HUMANITES')
                ->description('Dites-nous ce que vous avez faites après les humanités'),

            Layout::block(Layout::rows([
                Label::make('choix1')
                    ->title('Premier Choix:'),
                Group::make([
                    Relation::make('user.choix.faculty_id')
                        ->fromModel(Faculty::class,'name','id')
                        ->title('Faculté 1')
                        ->required()
                        ->help('Choisisez une Faculté'),

                    Relation::make('user.choix.department_id')
                        ->fromModel(Departement::class,'name','id')
                        ->title('Departement 1')
                        ->required()
                        ->help('Choisisez un departement')
                ]),

                    Label::make('choix2')
                        ->title('Deuxième Choix:'),
                Group::make([

                    Relation::make('user.choix.faculty_id')
                    ->fromModel(Faculty::class,'name','id')
                    ->title('Faculté 2')
                    ->required()
                    ->help('Choisisez une Faculté'),

                Relation::make('user.choix.department_id')
                    ->fromModel(Departement::class,'name','id')
                    ->title('Departement 2')
                    ->required()
                    ->help('Choisisez un departement')
                ])
            ]))
                ->title('CHOIX FORMULES')
                ->description('Faites deux choix de formules selon l\'ordre de priorité.'),

            ];
    }

    public function save(Request $request){
        dd($request->input());
    }
}
