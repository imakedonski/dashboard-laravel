<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Color;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LinkController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(int $position): \Illuminate\Contracts\View\View|RedirectResponse
    {
        if ($link = Link::where('position', $position)->first()) {
            return to_route('link.edit', ['link' => $link]);
        }

        return view('links.create',
            [
                'colors' => Color::all(),
                'position' => $position,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLinkRequest $request): RedirectResponse
    {
        Link::create($request->all());

        return to_route('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link): \Illuminate\Contracts\View\View|RedirectResponse
    {
        if (!Gate::check('edit', $link)) {
            return to_route('dashboard');
        }

        return view('links.edit',
            [
                'link' => $link,
                'colors' => Color::all(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Link $link, UpdateLinkRequest $request): RedirectResponse
    {
        if (!Gate::check('update', $link)) {
            return to_route('dashboard');
        }

        $updated = $link->update([
            'title' => $request->get('title'),
            'color_id' => $request->get('color_id'),
            'url' => $request->get('url'),
        ]);

        return to_route('link.edit', ['link' => $link])
            ->with('status', $updated
                ?
                __('Link updated!')
                :
                __('Something went wrong, please try again later!')
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link, Request $request): \Illuminate\Http\JsonResponse
    {
        if (!Gate::check('delete', $link)) {
            return to_route('dashboard');
        }

       try {
           $link->delete();

           return response()->json([
              'success'  =>  true,
              'message' => __('The link was deleted! Refreshing in 2 seconds.')
           ]);
       } catch (\LogicException) {
           return response()->json([
               'success' => false,
               'message' => __('Something went wrong, please try again later.')
           ]);
       }

    }
}
