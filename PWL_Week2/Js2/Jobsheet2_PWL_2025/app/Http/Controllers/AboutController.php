<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __invoke()
    {
        return 'Nama = Aditya Yuhanda Putra <br> 
        NIM = 2341760050';
    }
}
