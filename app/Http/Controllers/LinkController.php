<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Color;
use App\Models\Link;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LinkController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(int $position)
    {
        if ($link = Link::where('position', $position)->first()) {
            return to_route('link.edit', ['id' => $link->id]);
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
    public function store(StoreLinkRequest $request)
    {
        Link::create(array_merge($request->all(), ['user_id' => auth()->id()]));

        return to_route('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('links.edit',
            [
                'link' => Link::findOrfail($id),
                'colors' => Color::all(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLinkRequest $request)
    {
        Link::findOrFail($request->get('id'))->update([
            'title' => $request->get('title'),
            'color_id' => $request->get('color_id'),
            'url' => $request->get('url'),
        ]);

        return to_route('link.edit', ['id' => $request->get('id')])
                ->with('status', __('Link updated!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
       $me = auth()->id();

       try {
           $link = Link::findOrFail($request->get('id'));

           if (!$link->ownedBy($me)) {
               return response()->json([
                   'success' => false,
                   'message' => __('Link not found!'),
               ]);
           }

           $link->delete();

           return response()->json([
              'success'  =>  true,
              'message' => __('The link was deleted! Refreshing in 2 seconds.')
           ]);
       } catch (ModelNotFoundException) {
           return response()->json([
               'success' => false,
               'message' => __('Link not found!')
           ]);
       }

    }
}
