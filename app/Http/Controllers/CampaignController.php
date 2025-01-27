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
        return view('campaigns.create', [
            'tab' => $tab
        ]);
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
