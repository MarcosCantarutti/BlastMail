<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {

        $tab = $this->route('tab');

        $rules = [];


        $map = array_merge([
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'send_at' => null,
        ], request()->all());



        if (blank($tab)) {
            $rules = [
                'name' => ['required', 'max:255'],
                'subject' => ['required', 'max:40'],
                'email_list_id' => ['nullable'],
                'template_id' => ['nullable'],
                'track_click' => ['nullable'],
                'track_open' => ['nullable'],
                'send_at' => ['nullable'],
            ];
        }
        // dd($tab);
        if ($tab == 'template') {
            $rules = ['body' => ['required']];
        }

        if ($tab == 'schedule') {

            $rules = ['send_at' => ['required', 'date']];
        }

        // Garante que a sessão tem todas as chaves
        $session = session('campaigns::create', $map);

        foreach ($session as $key => $value) {
            $newValue = data_get($map, $key);

            if (filled($newValue)) {
                $session[$key] = $newValue;
            }
        }


        session()->put('campaigns::create', $session);

        return $rules;
    }

    public function getData()
    {
        $session = session()->get('campaigns::create');
        unset($session['_token']);
        return $session;
    }

    public function getToRoute()
    {
        $tab = $this->route('tab');

        if (blank($tab)) {
            return route('campaigns.create', ['tab' => 'template']);
        }

        if ($tab == 'template') {
            return route('campaigns.create', ['tab' => 'schedule']);
        }


        return route('campaigns.index');
    }
}
