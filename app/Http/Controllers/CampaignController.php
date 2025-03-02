<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignStoreRequest;
use App\Jobs\SendEmailCampaign;
use App\Mail\EmailCampaign;
use App\Models\Campaign;
use App\Models\EmailList;
use App\Models\Template;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Traits\Conditionable;

class CampaignController extends Controller
{

    use Conditionable;
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

    //region metodos separados
    // public function showStatistics(Campaign $campaign)
    // {

    //     return view('campaigns.show.statistics');
    // }

    // public function showOpen(Campaign $campaign)
    // {

    //     return view('campaigns.show.open');
    // }

    // public function showClicked(Campaign $campaign)
    // {

    //     return view('campaigns.show.clicked');
    // }
    //endregion

    public function show(Campaign $campaign, ?string $what = null)
    {

        // $what = $what ?: 'statistics';

        //abordagem melhor para vir selecionado
        if (is_null($what)) {
            return to_route('campaigns.show', ['campaign' => $campaign, 'what' => 'statistics']);
        }

        abort_unless(in_array($what, ['statistics', 'open', 'clicked']), 404);


        //implementação
        $search = request()->search;


        return view('campaigns.show', [
            'campaign' => $campaign,
            'what' => $what,
            'search' => $search
        ]);
    }



    public function create(?string $tab = null)
    {
        // session()->forget('campaigns::create');

        $data = session()->get('campaigns::create', [
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => 0,
            'track_open' => 0,
            'send_at' => null,
            'send_when' => 'now',
        ]);

        return view(
            'campaigns.create',
            array_merge(
                $this->when(blank($tab), function () {
                    return [
                        'emailLists' => EmailList::query()->select(['id', 'title'])->orderBy('title')->get(),
                        'templates' => Template::query()->select(['id', 'name'])->orderBy('name')->get(),
                    ];
                }, fn() => []),
                $this->when($tab == 'schedule', fn() => [
                    'countEmails' => EmailList::find($data['email_list_id'])->subscribers()->count(),
                    'template' => Template::find($data['template_id'])->name,
                ], fn() => []),
                [
                    'tab' => $tab,
                    'form' => match ($tab) {
                        'template' => '_template',
                        'schedule' => '_schedule',
                        default => '_config'
                    },

                    'data' => $data
                ]
            )
        );
    }

    public function store(CampaignStoreRequest $request, ?string $tab = null)
    {

        $data = $request->getData();
        $toRoute = $request->getToRoute();

        // dd($data);

        if ($tab == 'schedule') {
            $campaign = Campaign::create($data);


            // não travar nesse loop, usando job e o método dispatch de aguardar o response
            SendEmailCampaign::dispatchAfterResponse($campaign);
        }

        return response()->redirectTo($toRoute);
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
