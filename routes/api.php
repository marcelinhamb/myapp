<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Article;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('articles', 'ArticleController@index', function() {
        // If the Content-Type and Accept headers are set to 'application/json', 
        // this will return a JSON structure. This will be cleaned up later.
        return Article::all();
    });
     
    Route::get('articles/{id}', 'ArticleController@show', function($id) {
        return Article::find($id);
    });

    Route::post('articles', 'ArticleController@store', function(Request $request) {
        return Article::create($request->all);
    });

    Route::put('articles/{id}', 'ArticleController@update', function(Request $request, $id) {
        $article = Article::findOrFail($id);
        $article->update($request->all());

        return $article;
    });

    Route::delete('articles/{id}', 'ArticleController@delete', function($id) {
        Article::find($id)->delete();

        return 204;
    });
});

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');