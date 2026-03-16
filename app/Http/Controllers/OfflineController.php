<?php

namespace App\Http\Controllers;

/**
 * Class OfflineController
 *
 * @package App\Http\Controllers
 * @category Controller
 */
class OfflineController extends Controller
{
    /**
     * Display the offline page.
     *
     * @access public
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('offline');
    }
}
