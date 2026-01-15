<?php

namespace App\Http\Controllers\Goal;

use App\Http\Controllers\Controller;
use App\Services\Goal\GoalService;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function __construct(
        protected GoalService $goalService
    ){}
}
