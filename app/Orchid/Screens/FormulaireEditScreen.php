<?php

namespace App\Orchid\Screens;

use App\Models\Choice;
use App\Models\Departement;
use App\Models\Etude;
use App\Models\Faculty;
use App\Models\Identity;
use App\Models\Occupation;
use App\Models\Pays;
use App\Orchid\Layouts\ChoiseListener;
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
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Rinvex\Country\Country;

use function PHPUnit\Framework\isTrue;

class FormulaireEditScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public $submitted;

    public function query(): iterable
    {

        // foreach (countries() as $key => $value) {
        //     Pays::create([
        //         'name' => $value['name'],
        //         'official_name' => $value['official_name'],
        //         'iso_3166_1_alpha2' => $value['iso_3166_1_alpha2'],
        //         'calling_code' => $value['calling_code'],

        //     ]);
        // }
        // dd(Auth::user()->choice->submitted->isTrue());
        // dd(Auth::user()->choice->speciale);



        $this->submitted = Auth::user()->choice->submitted ?? 0;

        return [
            'user' =>Auth::user(),
            'faculty1_id' =>Auth::user()->choice->faculty1_id ?? '',
            'faculty2_id' =>Auth::user()->choice->faculty2_id ?? '',
            'departement1_id' =>Auth::user()->choice->departement1_id ?? '',
            'departement2_id' =>Auth::user()->choice->departement2_id ?? '',
            'speciale' =>Auth::user()->choice->speciale ?? 0
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
            Button::make(__('Sauvegarder'))
                ->icon('check')
                ->type(Color::WARNING())
                ->confirm(__('Si vous sauvegardez, vous informations sont simplement enregistrées en attendant vos amples modifications.'))
                ->disabled($this->submitted == 1)
                ->method('save'),

            Button::make(__('Valider'))
                ->icon('check')
                ->type(Color::SUCCESS())
                ->confirm(__('Cette opération est irréversible. Si vous validez, vous n\'aurai plus la possibilité de mettre à jour vos informations.'))
                ->canSee(!empty(Auth::user()->choice))
                ->disabled($this->submitted == 1)
                ->method('validation'),

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
                    Input::make('user.identity.nom')
                        ->title('Nom :')
                        ->placeholder('Saisisez votre Nom')
                        ->disabled($this->submitted == 1)
                        ->required(),

                    Input::make('user.identity.postnom')
                        ->title('Postnom :')
                        ->placeholder('Saisisez notre Postnom')
                        ->disabled($this->submitted == 1)
                        ->required(),

                    // Input::make('deux')
                    //     ->readonly()
                    //     ->canSee($this->query->has('deux')),
                ]),

                Group::make([
                    Input::make('user.identity.prenom')
                        ->title('Prenom :')
                        ->placeholder('Saisisez votre Prenom')
                        ->disabled($this->submitted == 1)
                        ->required(),

                    Select::make('user.identity.sexe')
                        ->options([
                            'Masculin'   => 'M',
                            'Féminin' => 'F',
                        ])
                        ->title('Sexe')
                        ->required()
                        ->disabled($this->submitted == 1)
                        ->help('Choisisez votre genre'),
                    ]),

                    Group::make([
                        Input::make('user.identity.lieu_naissance')
                            ->title('Lieu de naissance :')
                            ->placeholder('Saisisez votre lieu de naissance')
                            ->required()
                            ->disabled($this->submitted == 1),

                        Input::make('user.identity.date_naissance')
                            ->type('date')
                            ->title('Date de naissance')
                            ->value('2005-08-19')
                            ->required()
                            ->disabled($this->submitted == 1),
                    ]),

                    Group::make([
                        Relation::make('user.identity.nationnalite')
                            ->fromModel(Pays::class,'name','id')
                            ->title('Nationalité (Pays)')
                            ->required()
                            ->disabled($this->submitted == 1)
                            ->help('Choisisez votre Pays'),
                        Input::make('user.identity.telephone')
                            ->mask('+243 999 999 999')
                            ->title('Téléphone')
                            ->disabled($this->submitted == 1)
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
                        ->required()
                        ->disabled($this->submitted == 1),

                    Input::make('user.etude.nom_ecole')
                        ->title('Nom Ecole :')
                        ->placeholder('Saisisez le nom de votre école')
                        ->required()
                        ->disabled($this->submitted == 1),
                ]),


                Group::make([
                    Input::make('user.etude.nom_centre')
                        ->title('nom du centre :')
                        ->placeholder('Saisisez le nom du centre')
                        ->required()
                        ->disabled($this->submitted == 1),

                    DateTimer::make('user.etude.annee')
                        ->title('Année')
                        ->format('Y')
                        ->help('Selectionnez l\'année de l\'obtention du diplôme'),
                ]),

                Group::make([
                    Input::make('user.etude.section')
                        ->title('Section :')
                        ->placeholder('Saisisez votre section')
                        ->required()
                        ->disabled($this->submitted == 1),

                    Input::make('user.etude.pourcentage')
                        ->mask('99 %')
                        ->title('Pourcentage :')
                        ->placeholder('Saisisez votre Pourcentage obtenu')
                        ->required()
                        ->disabled($this->submitted == 1),
                ]),

                Input::make('user.etude.num_diplome')
                        ->title('Numéro diplôme :')
                        ->placeholder('Saisisez le numéro du diplôme.')
                        ->required()
                        ->disabled($this->submitted == 1),
            ]))
                ->title('ÉTUDES SECONDAIRES FAITES')
                ->description('Insérez-y des vraies informations relatives à votre parcours scolaire car les fausses informations annuleront votre bulletin'),
                ChoiseListener::class,
                Layout::view('platform::partials.instruction'),
            // Layout::block(Layout::rows([

            //         Input::make('user.occupation.activite_pro')
            //             ->title('Activité professionnelle :'),

            //         Input::make('user.occupation.etude_pre_univ')
            //             ->title('Etude pré-universitaire :'),
            // ]))
            //     ->title('OCCUPATIONS APRES LES HUMANITES')
            //     ->description('Dites-nous ce que vous avez faites après les humanités'),

            // Layout::block(Layout::rows([
            //     Label::make('choix1')
            //         ->title('Premier Choix:'),
            //     Group::make([
            //         Relation::make('user.choix.faculty1_id[]')
            //             ->fromModel(Faculty::class,'name','id')
            //             ->title('Faculté 1')
            //             ->required()
            //             ->help('Choisisez une Faculté'),

            //         Relation::make('user.choice.departement1_id')
            //             ->fromModel(Departement::class,'name','id')
            //             ->title('Faculté / Departement 1')
            //             // ->displayAppend('full')
            //             ->required()
            //             ->help('Choisisez un departement')
            //     ]),

            //         Label::make('choix2')
            //             ->title('Deuxième Choix:'),
            //     Group::make([

            //         Relation::make('user.choix.faculty2_id[]')
            //         ->fromModel(Faculty::class,'name','id')
            //         ->title('Faculté 2')
            //         ->required()
            //         ->help('Choisisez une Faculté'),

            //     Relation::make('user.choice.departement2_id')
            //         ->fromModel(Departement::class,'name','id')
            //         ->title('Faculté / Departement 2')
            //         // ->displayAppend('full')
            //         ->required()
            //         ->help('Choisisez un departement')
            //     ])
            // ]))
            //     ->title('CHOIX FORMULES')
            //     ->description('Faites deux choix de formules selon l\'ordre de priorité.'),
            ];
    }

    public function save(Request $request,Identity $identity,Etude $etude,Occupation $occupation,Choice $choice){

        // dd($request->input());
        $choice = Auth::user()->choice ?? $choice;
        $this->choiceIsSet = Auth::user()->choice ? 1 : 0;

        $identity = Auth::user()->identity ?? $identity;
        $etude = Auth::user()->etude ?? $etude;
        $occupation = Auth::user()->occupation ?? $occupation;
        // dd($request->input('user'));

        $identity->user_id = Auth::user()->id;
        $identity->fill($request->input('user')['identity'])->save();

        $etude->user_id = Auth::user()->id;
        $etude->fill($request->input('user')['etude'])->save();

        // $occupation->user_id = Auth::user()->id;
        // $occupation->fill($request->input('user')['occupation'])->save();

        $choice->user_id = Auth::user()->id;
        $choice->speciale = $request->input('speciale');
        $choice->faculty1_id = $request->input('faculty1_id');
        $choice->departement1_id = $request->input('departement1_id');
        $choice->faculty2_id =$request->input('promotion_id') ? null : $request->input('faculty2_id');
        $choice->departement2_id =$request->input('promotion_id') ? null : $request->input('departement2_id');
        $choice->promotion_id = $request->input('faculty2_id') ? null: $request->input('promotion_id');
        $choice->save();

        // dd($request->input(),$identity,$etude,$occupation,$choice);
    }

    public function asyncChargement(string $faculty1_id = null, string $faculty2_id = null){
        dd('ok');

        return [
            'deux' => Auth::user()->identity->nom
        ];
    }

    public function asyncSum( /* int $departement1_id = null, int $departement2_id = null, */int $speciale = 0,int $faculty1_id = null,int $faculty2_id = null)
    {

        // $this->facult1 = $a;
        return [
            // 'departement1_id' => $departement1_id,
            // 'departement2_id' => $departement2_id,
            'speciale' => $speciale,
            'faculty1_id' => $faculty1_id,
            'faculty2_id' => $faculty2_id,

            'sum' => $speciale ,
        ];
    }

    public function validation(){
        $choice = Auth::user()->choice;
        $choice->submitted = true;
        $choice->save();

        Toast::success('Vos informations ont été soumis avec succès !');

        // Toast::info(__('You are now impersonating this user'));

        return redirect()->back();
    }

}
