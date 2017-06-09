<?php

namespace App\Foundation;

use Validator;

trait DataViewer {

    public function scopeSearchPaginateAndOrder($query)
    {
        $request = app()->make('request');

        $v = Validator::make($request->only([
            'column', 'direction','status'
        ]), [
            'column' => 'required|alpha_dash|in:'.implode(',', self::$columns),
            'direction' => 'required|in:asc,desc',
            'status' => 'alpha|in:'.implode(',', self::$statuses),
        ]);

        if($v->fails()) {
            throw new \Illuminate\Validation\ValidationException($v);
        }

        return $query
            ->orderBy($request->column, $request->direction)
            ->where(function($query) use ($request) {
                if($request->has('status') and $request->status !=='all')
                {
                    $query->whereStatus($request->status);
                }
            });
    }

}