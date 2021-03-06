<?php

namespace App\Http\Controllers;

use App\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index()
    {
        $labels = Label::all();

        return view('label.index', compact('labels'));
    }

    public function create()
    {
        $label = new Label();

        return view('label.create', compact('label'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $label = new Label();
        $label->name = $request->input('name');
        $label->saveOrFail();
        flash()->success(__('layout.flash.success'));

        return redirect()->route('labels.index');
    }

    public function show(Label $label)
    {
        abort(404);
    }

    public function edit(Label $label)
    {
        return view('label.edit', compact('label'));
    }

    public function update(Request $request, Label $label)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $label->name = $request->input('name');
        $label->saveOrFail();
        flash()->success(__('layout.flash.success'));

        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        $label->delete();
        flash()->success(__('layout.flash.success'));

        return redirect()->route('labels.index');
    }
}
