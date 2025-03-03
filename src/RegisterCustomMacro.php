<?php


namespace Kirago\BusinessCore;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as DBBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait RegisterCustomMacro {

    public function registerMacroHelpers(){


        // Définir la macro "whereLike" pour les deux constructeurs
        $macroWhereLike = function (array|string $attributes,string $search) {
                            $this->where(function ($q) use ($attributes,$search){
                                foreach (Arr::wrap($attributes) as $attribute) {
                                    $q->orWhere($attribute, 'LIKE', "%{$search}%");
                                }
                            });

                            return $this;
                        };

        $macroWhereDateBetween = function (string $attribute, array $dates) {

            if(count($dates) == 2){

                [$start_date , $end_date] = $dates;

                $this->whereDate($attribute,">=",format_date($start_date,"Y-m-d"))
                     ->whereDate($attribute,"<=",format_date($end_date,"Y-m-d"));
            }
            return $this;
        };

        $macroWhereMultiple = function (array|string $attributes, string $search) {
                                    return $this->where(function ($q) use ($attributes,$search){
                                                    foreach (Arr::wrap($attributes) as $attribute) {
                                                        $q->orWhere($attribute,$search);
                                                    }
                                                });
                                };

        EloquentBuilder::macro("whereLike",$macroWhereLike);
        DBBuilder::macro("whereLike",$macroWhereLike);

        EloquentBuilder::macro("whereDateBetween",$macroWhereDateBetween);
        DBBuilder::macro("whereDateBetween",$macroWhereDateBetween);

        EloquentBuilder::macro("whereMultiple",$macroWhereMultiple);
        DBBuilder::macro("whereMultiple",$macroWhereMultiple);

        // Definition du macro "wherePeriod" sur le Builder d'Eloquent
        // clause de recherche
        EloquentBuilder::macro("wherePeriod",function ($attributes, $search){
            $attributes = (array) $attributes; // [2022-04 , 2022-01]
            if (is_array($attributes)){
                foreach (Arr::wrap($attributes) as $attribute){
                    $date = format_date($search,"Y-m");  // 2022-02
                    $year = date("Y",strtotime($date)); // 2022
                    $month = date("m",strtotime($date)); // 04
                    $this->whereYear($attribute,"{$year}")
                        ->whereMonth($attribute,"{$month}");
                }
            }else{
                $date = format_date($search,"Y-m"); // 2020-04
                $year = date("Y",strtotime($date)); // 2020
                $month = date("m",strtotime($date)); // 04
                $this->whereYear($attributes,"{$year}")
                    ->whereMonth($attributes,"{$month}");
            }
            return $this;
        });


        //Converti tous les éléments (array ou objet) d'une collection en collection
        Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                return  (is_array($value) || is_object($value))
                    ? collect($value)->recursive()
                    : $value;
            });
        });

        Str::macro("password",function ($length = 32, $letters = true, $numbers = true, $symbols = true, $spaces = false){
            return (new Collection)
                    ->when($letters, fn ($c) => $c->merge([
                        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k',
                        'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v',
                        'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G',
                        'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
                        'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                    ]))
                    ->when($numbers, fn ($c) => $c->merge([
                        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
                    ]))
                    ->when($symbols, fn ($c) => $c->merge([
                        '~', '!', '#', '$', '%', '^', '&', '*', '(', ')', '-',
                        '_', '.', ',', '<', '>', '?', '/', '\\', '{', '}', '[',
                        ']', '|', ':', ';',
                    ]))
                    ->when($spaces, fn ($c) => $c->merge([' ']))
                    ->pipe(fn ($c) => Collection::times($length, fn () => $c[random_int(0, $c->count() - 1)]))
                    ->implode('');
        });

    }
}
