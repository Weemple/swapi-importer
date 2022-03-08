<?php

namespace Weemple\SwapiImporter\Controllers;

use Illuminate\Http\Request;

use Weemple\SwapiImporter\Models\People;

class ApiController extends Controller
{
    public function getPeoples(Request $request)
    {
        $filter_field = $request->input('filter-field', null);
        $filter_value = $request->input('filter-value', null);

        $order_field = $request->input('order-field', null);
        $order_direction = $request->input('order-direction', 'asc');

        $peoples = People::query();

        if (!is_null($filter_field) && !is_null($filter_value)) {
            $peoples = $peoples->where($filter_field, 'LIKE', '%' . $filter_value . '%');
        }

        if (!is_null($order_field)) {
            $peoples = $peoples->orderBy($order_field, $order_direction);
        }
        
        $peoples = $peoples->paginate(15)
        ->onEachSide(2);

        return response()->json($peoples);
    }

    public function getPeople($id)
    {
        $people = People::where('id', $id)
        ->with('planet')
        ->first();

        return response()->json($people);
    }
}
