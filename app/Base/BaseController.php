<?php
namespace App\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller {
    public $user;

    public function __construct(){
        $this->user = auth("sanctum")->user();
    }
}