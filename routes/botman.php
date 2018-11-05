<?php

use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('Hola', BotManController::class.'@startConversation');
