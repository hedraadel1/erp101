<?php
namespace App\Http\Controllers;

use App\Models\QueryLog;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    public function index(Request $request)
    {
        // Get all the query logs from the database
        $queries = QueryLog::all();

        return view('query.index', compact('queries'));
    }
}