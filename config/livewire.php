<?php

declare(strict_types=1);

return [

    /*
    |---------------------------------------------------------------------------
    | Page Layout
    |---------------------------------------------------------------------------
    |
    | Livewire 4's default ('layouts::app') expects a hint-namespaced view in
    | resources/views/layouts, which this project doesn't use. The root layout
    | lives at resources/views/components/layouts/app.blade.php, so point full
    | page components (Volt routes and Route::get(..., Component::class)) there.
    |
    */

    'component_layout' => 'components.layouts.app',

];
