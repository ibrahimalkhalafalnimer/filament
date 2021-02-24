<?php

namespace Filament\Resources;

use Filament\NavigationItem;
use Filament\Resources\Forms\Form;
use Filament\Resources\Tables\Table;
use Illuminate\Support\Str;

class Resource
{
    public static $icon = 'heroicon-o-collection';

    public static $label;

    public static $model;

    public static $slug;

    public static $sort = 0;

    public static function authorization()
    {
        return [];
    }

    public static function authorizationManager()
    {
        return new AuthorizationManager(static::class);
    }

    public static function form(Form $form)
    {
        return $form;
    }

    public static function generateUrl($name = null, $parameters = [], $absolute = true)
    {
        if (! $name) $name = static::router()->getIndexRoute()->name;

        return route('filament.resources.' . static::getSlug() . '.' . $name, $parameters, $absolute);
    }

    public static function getIcon()
    {
        return static::$icon;
    }

    public static function getLabel()
    {
        if (static::$label) return static::$label;

        return (string) Str::of(class_basename(static::getModel()))
            ->kebab()
            ->replace('-', ' ');
    }

    public static function getModel()
    {
        if (static::$model) return static::$model;

        return (string) Str::of(class_basename(static::class))
            ->beforeLast('Resource')
            ->prepend('App\\Models\\');
    }

    public static function getSlug()
    {
        if (static::$slug) return static::$slug;

        return (string) Str::of(class_basename(static::getModel()))
            ->plural()
            ->kebab();
    }

    public static function getSort()
    {
        return static::$sort;
    }

    public static function navigationItems()
    {
        $label = (string) Str::of(static::getLabel())->plural()->title();

        return [
            NavigationItem::make($label, static::generateUrl())
                ->activeRule((string) Str::of(parse_url(static::generateUrl(), PHP_URL_PATH))
                    ->after('/')
                    ->append('*'),
                )
                ->icon(static::getIcon())
                ->sort(static::getSort()),
        ];
    }

    public static function relations()
    {
        return [];
    }

    public static function router()
    {
        return new Router(static::class);
    }

    public static function routes()
    {
        return [];
    }

    public static function table(Table $table)
    {
        return $table;
    }
}
