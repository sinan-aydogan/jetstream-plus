<?php

namespace Laravel\Jetstream\Http\Controllers\JetstreamPlus;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class DisplayLanguageController extends Controller
{
    /**
     * Update the authenticated user's current team.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        /*Validation*/
        Validator::make($request->all(), [
            'activeLanguage' => 'required|string|max:2',
        ])->after(function ($validator) use ($request) {
            if (! isset($request['activeLanguage'])) {
                $validator->errors()->add('activeLanguage', __('There has been occurred undefined problem, please reload page'));
            }
        })->validateWithBag('activeLanguage');

        $user = auth()->user();

        /*Set Frontend Language*/
        $user->forceFill([
            'language' => $request->input('activeLanguage'),
        ])->save();

        /*Set Backend Language*/
        session()->put('locale', $request->input('activeLanguage'));

        return redirect()->back();
    }
}
