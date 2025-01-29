<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $search = request()->get('search', null);
        $withTrashed = request()->get('withTrashed', false);

        return view('campaigns.index', [
            'campaigns' => Campaign::query()
                ->when($withTrashed,  fn(Builder $query) => $query->withTrashed())
                ->when(
                    $search,
                    fn(Builder $query) => $query
                        ->where('name', 'like', "%$search%")
                        ->orWhere('id', '=', $search)
                )
                ->paginate(5)
                ->appends(compact('search'), 'withTrashed'),
            'search' => $search,
            'withTrashed' => $withTrashed,
        ]);
    }

    public function create(?string $tab = null)
    {
        // session()->forget('campaigns::create');

        return view('campaigns.create', [
            'tab' => $tab,
            'form' => match ($tab) {
                'template' => '_template',
                'schedule' => '_schedule',
                default => '_config'
            },

            'data' => session()->get('campaigns::create', [
                'name' => null,
                'subject' => null,
                'email_list_id' => null,
                'template_id' => null,
                'body' => null,
                'track_click' => null,
                'track_open' => null,
                'sent_at' => null,
            ])
        ]);
    }

    public function store(?string $tab = null)
    {
        $toRoute = '';

        $map = array_merge([
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'sent_at' => null,
        ], request()->all());



        if (blank($tab)) {
            request()->validate([
                'name' => ['required', 'max:255'],
                'subject' => ['required', 'max:40'],
                'email_list_id' => ['nullable'],
                'template_id' => ['nullable'],
                'track_click' => ['nullable'],
                'track_open' => ['nullable'],
                'sent_at' => ['nullable'],
            ]);

            $toRoute = route('campaigns.create', ['tab' => 'template']);
        }
        // dd($tab);
        if ($tab == 'template') {
            request()->validate(['body' => ['required']]);
            $toRoute = route('campaigns.create', ['tab' => 'schedule']);
        }

        if ($tab == 'schedule') {

            request()->validate(['sent_at' => ['required', 'date']]);
            // $toRoute = route('campaigns.index');
        }

        // Garante que a sessão tem todas as chaves
        $session = session('campaigns::create', []);
        $defaults = [
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'sent_at' => null,
        ];

        // Preenche chaves ausentes na sessão
        $session = array_merge($defaults, $session);

        foreach ($session as $key => $value) {
            $newValue = data_get($map, $key);
            if (filled($newValue)) {
                $session[$key] = $newValue;
            }
        }

        session()->put('campaigns::create', $session);

        return redirect($toRoute);
    }



    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return back()->with('message', __('Campaign successfully deleted!'));
    }

    public function restore(Campaign $campaign)
    {
        $campaign->restore();
        return back()->with('message', __('Campaign successfully restored!'));
    }
}
