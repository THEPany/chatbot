<?php

Route::get('/', function ($website) {
    dd(
        "SubDominio: " . $website,
        auth()->user()->name ?? "GUEST"
    );
});