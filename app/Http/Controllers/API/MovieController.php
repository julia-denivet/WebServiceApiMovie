<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Middleware\iSLoggedIn;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

/**
 * @group Movies
 *
 * APIs for managing movies
 */

class MovieController extends Controller
{


    public function __construct()
    {
        $this->middleware(iSLoggedIn::class, ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $movie = Movie::with("categories")->paginate(1);
        return $movie;

        if ($movie->count() > 0) {
            return response(["code" => 200, "data" => $movie], 200);
        } else {
            return response(["code" => 404, "message" => 'MOVIE NOT FOUND'], 404);
        }
    }

    public function search()
    {

        $params = request()->query();

        $movie = Movie::query();
        $movie->when(
            isset($params["name"]),
            function ($q) {
                return $q->orWhere('name', 'LIKE',  "%" . request()->query('name') . "%");
            }
        );
        $movie->when(
            isset($params["description"]),
            function ($q) {
                return $q->orWhere('description', 'LIKE',  "%" . request()->query('description') . "%");
            }
        );

        return $movie->get();
    }


    /**
     *
     * @bodyParam name string required Example: Toy Story
     * @bodyParam description string required Example: L'infini et l'au delà
     * @bodyParam date date required Example: 10/02/2022
     * @bodyParam note smallInt required Example: 4
     *
     * 
     **/
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'description' => 'required|string',
            'note' => 'int|between:0,5',
            'category_id' => 'required|int',
        ]);
        $movie = Movie::create([
            'name' => $request->name,
            'description' => $request->description,
            'note' => $request->note,
            'category_id' => $request->category_id,
        ]);

        return response(["code" => 201, "data" => $movie], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        return response(["code" => 200, "data" => $movie], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    /**
     *
     * @bodyParam name string required Example: Toy Story
     * @bodyParam description string required Example: L'infini et l'au delà
     * @bodyParam date date required Example: 10/02/2022
     * @bodyParam note smallInt required Example: 4
     *
     * 
     **/
    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'description' => 'required|string',
            'note' => 'int|between:0,5',
            'category_id' => 'required|int',
        ]);
        $movie->update([
            'name' => $request->name,
            'description' => $request->description,
            'note' => $request->note,
            'category_id' => $request->category_id,
        ]);

        return response(["code" => 200, "data" => Movie::find($movie->id)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        if ($movie->delete()) {
            return response(["code" => 200, "deleted" => true], 200);
        }
    }
}
