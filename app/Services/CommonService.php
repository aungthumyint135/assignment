<?php

namespace App\Services;

use Illuminate\Http\Request;

class CommonService
{
    protected int $offset = 0;

    protected int $limit = 10;

    public function input(Request $request, array $fillable): array
    {
        return array_filter($request->only($fillable), fn($value) => $value != null);
    }

    public function params(Request $request, array $only = [], array $options = []): array
    {
        $search = $request->get('search');

        $params = [
            'search' => $search['value'] ?? null,
            'limit'  => !empty($request->get('limit')) ? (int) $request->get('limit') : $this->limit,
            'offset' => !empty($request->get('offset')) ? (int) $request->get('offset') : $this->offset,
        ];

        if (!empty($only)) {
            $params = collect($params)->only($only)->toArray();
        }

        if (!empty($options)) {
            $params = array_merge($params, $options);
        }

        return $params;
    }

    public function currentGuard()
    {
        $guards = collect(array_values(config('helper.guards')));

        return $guards->first(fn($guard) => auth($guard)->check());
    }

    public function dtParams($request, $allow = null, array $options = []): array
    {
        $search = $request->get('search');
        $searchVal = $search['value'] ?? null;
        $limit = $request->get('length') ?? $this->limit;
        $offset = $request->get('start') ?? $this->offset;

        $params = ['limit' => $limit, 'offset' => $offset];

        if (!empty($allow)) {

            if (is_array($allow)) {
                foreach ($allow as $value) {
                    $params[$value] = $request->get($value);
                }
            } else {
                $params[$allow] = $request->get($allow);
            }
        }

        if (!empty($searchVal)) {
            $params['search'] = $searchVal;
        }

        if (!empty($options)) {
            $params = array_merge($params, $options);
        }

        return $params;
    }
}
