<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function vitalSigns(Request $request)
    {
        $form_name = $request->get('form_name', 'default');
        return view('components.vital-signs', compact('form_name'));
    }
}
