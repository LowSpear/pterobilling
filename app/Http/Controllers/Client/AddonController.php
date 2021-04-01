<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function show($id)
    {
        $view_variables = array('title' => "Add-ons | Server #${id} - My Servers", 'header1' => 'My Servers', 'header1_route' => 'client.server.index', 'header2' => "Server #${id}", 'header2_route' => 'client.server.show', 'header_title' => 'Add-ons', 'id' => $id);
        return view('client.server.addon', $view_variables);
    }

    public function remove($id, $addon_id)
    {
        $view_variables = array('title' => "Remove Add-on | Server #${id} - My Servers", 'header1' => 'My Servers', 'header1_route' => 'client.server.index', 'header2' => "Server #${id}", 'header2_route' => 'client.server.show', 'header_title' => 'Remove Add-on', 'id' => $id, 'addon_id' => $addon_id);
        return view('client.server.remove', $view_variables);
    }

    public function destroy(Request $request, $id)
    {
        $view_variables = array('title' => "Add-on Removed | Server #${id} - My Servers", 'header1' => 'My Servers', 'header1_route' => 'client.server.index', 'header2' => "Server #${id}", 'header2_route' => 'client.server.show', 'header_title' => 'Add-on Removed', 'id' => $id);
        return view('client.server.removed', $view_variables);
    }

    public function add($id, $addon_id)
    {
        $view_variables = array('title' => "Add Add-on | Server #${id} - My Servers", 'header1' => 'My Servers', 'header1_route' => 'client.server.index', 'header2' => "Server #${id}", 'header2_route' => 'client.server.show', 'header_title' => 'Add add-on', 'id' => $id, 'addon_id' => $addon_id);
        return view('client.server.add', $view_variables);
    }

    public function store(Request $request, $id)
    {
        //
    }

    public function confirm()
    {
        //
    }

    public function checkout()
    {
        //
    }

    public function added($id)
    {
        $view_variables = array('title' => "Add-on Added | Server #${id} - My Servers", 'header1' => 'My Servers', 'header1_route' => 'client.server.index', 'header2' => "Server #${id}", 'header2_route' => 'client.server.show', 'header_title' => 'Add-on Added', 'id' => $id);
        return view('client.server.added', $view_variables);
    }
}
