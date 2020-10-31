<?php


namespace App\Http\Controllers;


use App\Model\Format;

class FormatsController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $formats = Format::all();
        return response()->json(['data' => $formats->toArray()], 200);
    }
}
