<?php

namespace App\Orchid\Layouts;

// use Orchid\Screen\Layout;

use App\Models\Departement;
use App\Models\Faculty;
use App\Models\Promotion;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Radio;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Facades\Layout;

class ChoiseListener extends Listener
{


    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        // 'departement1_id',
        // 'departement2_id',
        'speciale',
        'faculty1_id',
        'faculty2_id',

    ];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncSum';

    protected $submitted;
    // private $fac1 = $this->query->has('a');

    public function getPromo()
    {

        if ($this->query->get('faculty1_id') == 400) {
            // return Promotion::where('faculty_id',null)
            // ->orWhere('faculty_id',$this->query->get('faculty1_id'));
            return Promotion::whereBetween('codetude',[400,500])
                ->orWhereIn('codetude',[102,103,104,105,106,107,1071,1081]);
        }elseif ($this->query->get('faculty1_id') == 500) {
            // return Promotion::where('faculty_id',null)
            // ->orWhere('faculty_id',$this->query->get('faculty1_id'));
            return Promotion::whereBetween('codetude',[500,600])
                ->orWhereIn('codetude',[102,103,104,105,106,107,1071,1081]);
        }elseif ($this->query->get('faculty1_id') == 600) {
            // return Promotion::where('faculty_id',null)
            // ->orWhere('faculty_id',$this->query->get('faculty1_id'));
            return Promotion::whereBetween('codetude',[600,700])
                ->orWhereIn('codetude',[102,103,104,105,106,107,1071,1081]);
        }elseif ($this->query->get('faculty1_id') == 700) {
            // return Promotion::where('faculty_id',null)
            // ->orWhere('faculty_id',$this->query->get('faculty1_id'));
            return Promotion::whereBetween('codetude',[700,800])
                    ->whereIn('codetude',[102,103,104,702,106,107,1005,1006]);
        }elseif ($this->query->get('faculty1_id') == 1000) {
            // return Promotion::where('faculty_id',null)
            // ->orWhere('faculty_id',$this->query->get('faculty1_id'));
            return Promotion::whereIn('codetude',[102,103,104,702,106,107,1071,1081,1005,1006]);

        } else {
            return Promotion::whereIn('codetude',[102,103,104,702,106,107,1071,1081]);
        }


    }
    /**
     * @return Layout[]
     */
    protected function layouts(): iterable
    {
        // dd(Promotion::whereIn('id',[1,2,3]));
        // dd($this->query->get('a'));
        // $fac1 = $this->query->has('a');
        $this->submitted = Auth::user()->choice->submitted ?? 0;
        $choiceIsSet = Auth::user()->choice ? 1 : 0;

        return [

            Layout::block(Layout::rows([
                CheckBox::make('speciale')
                    ->sendTrueOrFalse()
                    ->title('Inscription spéciale')
                    ->disabled($this->submitted == 1)
                    ->placeholder('Est-ce une inscription spéciale ?'),


                Label::make('choix1')
                    ->title(($this->query->get('speciale') == 0) ? 'Premier Choix:' : 'Votre Choix:'),
                Group::make([
                    // Relation::make('faculty1_id')
                    //     ->fromModel(Faculty::class,'name','id')
                    //     ->title(($this->query->get('speciale') == 0) ? 'Faculté 1' : 'Faculté')
                    //     ->required()
                    //     ->disabled($this->submitted == 1)
                    //     ->help('Choisisez une Faculté'),

                    Select::make('faculty1_id')
                        ->fromModel(Faculty::class,'libellefac','codefac')
                        ->title(($this->query->get('speciale') == 0) ? 'Faculté 1' : 'Faculté')
                        ->required()
                        ->disabled($this->submitted == 1)
                        ->help('Choisisez une Faculté'),

                    Select::make('departement1_id')
                        ->title(($this->query->get('speciale') == 0) ? 'Département 1' : 'Département')
                        ->fromQuery(Departement::where('codefac',$this->query->get('faculty1_id')),'libelledpt','codedpt')
                        ->disabled($this->submitted == 1),
                    // Select::make('departement1_id')
                    //     ->title(($this->query->get('speciale') == 0) ? 'Département 1' : 'Département')
                    //     ->fromQuery(Departement::where('faculty_id',$this->query->get('faculty1_id')),'name','id')
                    //     ->disabled($this->submitted == 1),
                        // Relation::make('user.choice.departement1_id')
                    //     ->fromModel(Departement::class,'name','id')
                    //     ->title('Faculté / Departement 1')
                    //     // ->displayAppend('full')
                    //     ->required()
                    //     ->help('Choisisez un departement')
                ]),


                Label::make('choix2')
                    ->title('Deuxième Choix:')
                    ->canSee(($this->query->get('speciale') == 0) ?  : ''),
                Group::make([

                // Relation::make('faculty2_id')
                //     ->fromModel(Faculty::class,'name','id')
                //     ->title('Faculté 2')
                //     ->required()
                //     ->disabled($this->submitted == 1)
                //     ->popover('tapez le nom de la faculté')
                //     ->help('Choisisez une Faculté')
                //     ->canSee(($this->query->get('speciale') == 0)),

                Select::make('faculty2_id')
                    ->fromModel(Faculty::class,'libellefac','codefac')
                    ->title('Faculté 2')
                    ->required()
                    ->disabled($this->submitted == 1)
                    ->popover('tapez le nom de la faculté')
                    ->help('Choisisez une Faculté')
                    ->canSee(($this->query->get('speciale') == 0)),

                Select::make('departement2_id')
                    ->title('Departement 2')
                    ->fromQuery(Departement::where('codefac',$this->query->get('faculty2_id')),'libelledpt','codedpt')
                    ->canSee(($this->query->get('speciale') == 0))
                    ->disabled($this->submitted == 1),

                // Select::make('departement2_id')
                //     ->title('Departement 1')
                //     ->fromQuery(Departement::where('faculty_id',$this->query->get('faculty2_id')),'name','id')
                //     ->canSee(($this->query->get('speciale') == 0))
                //     ->disabled($this->submitted == 1),
                // Relation::make('user.choice.departement2_id')
                //     ->fromModel(Departement::class,'name','id')
                //     ->title('Faculté / Departement 2')
                //     // ->displayAppend('full')
                //     ->required()

                //     ->help('Choisisez un departement')
                ]),

                // Select::make('promotion_id')
                //     ->title('Promotion')
                //     ->fromQuery($this->getPromo(),'name','id')
                //     ->canSee($this->query->get('speciale') == 1)
                //     ->disabled($this->submitted == 1),

                Select::make('promotion_id')
                ->title('Promotion')
                ->fromQuery($this->getPromo(),'sigleetude','codetude')
                ->canSee($this->query->get('speciale') == 1)
                ->disabled($this->submitted == 1),
            ]))
                ->title('CHOIX FORMULES')
                ->description('Faites deux choix de formules selon l\'ordre de priorité.'),

        // Layout::rows([
        //     // Input::make('a')
        //     // ->title('First argument')
        //     // ->type('number'),

        //     // Input::make('b')
        //     //     ->title('Second argument')
        //     //     ->type('number'),

        //     Input::make('sum')
        //         ->readonly()
        //         ->canSee($this->query->has('sum')),

        //     // Select::make('departement1_id')
        //     //     ->title('Departement 1')
        //     //     ->fromQuery(Departement::where('faculty_id',$this->query->get('faculty1_id')),'name','id')
        //     ]),



        ];
    }
}
