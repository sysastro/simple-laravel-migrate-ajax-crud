<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class NewsController extends Controller
{
    /*
     * Show page list all news data
     * @return view index
     */
    public function index()
    {
        return View::make('news.index');
    }

    /*
     * Get data news from database to show in list news
     * @return json data news
     */
    public function data()
    {
        // Get all data news from database
        $news = News::all();

        // Set array data into json format
        $news->toJson();
        return $news;
    }

    /*
     * Save submitted data into database
     * $param $request = form post params name
     * @return json status saving data
     */
    public function create(Request $request)
    {
        // Add validation input
        $rules = array(
            'uuid' => 'required|unique:news',
            'title' => 'required',
            'slug' => 'required',
            'content' => 'required',
            'visitor' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // Check validation if it is failed
        if ($validator->fails())
        {
            return Response::json(array(
                'status' => 'error',
                'message' => 'All field is required !!!'
            ), 200);
        }

        // Add initialize News model
        $news = new News();
        $news->uuid = $request->input('uuid');
        $news->title = $request->input('title');
        $news->slug = $request->input('slug');
        $news->content = $request->input('content');
        $news->visitor = $request->input('visitor');
        $news->is_active = $request->input('is_active');

        // Check if data saved
        if($news->save())
        {
            return Response::json(array(
                'status' => 'success',
                'message' => 'News successfully saved.'
            ), 200);
        }
        else
        {
            return Response::json(array(
                'status' => 'error',
                'message' => 'News failed saved.'
            ), 200);
        }
    }

    /*
     * Update submitted data into database
     * $param $request = form post params name
     * @return json status update data
     */
    public function update(Request $request)
    {
        // Add validation input
        $rules = array(
            'id' => 'required',
            'title' => 'required',
            'slug' => 'required',
            'content' => 'required',
            'visitor' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // Check validation if it is failed
        if ($validator->fails())
        {
            return Response::json(array(
                'status' => 'error',
                'message' => 'All field is required !!!'
            ), 200);
        }

        // Add initialize News model
        $news = News::find($request->input('id'));
        if(!empty($news))
        {
            $news->id = $request->input('id');
            $news->title = $request->input('title');
            $news->slug = $request->input('slug');
            $news->content = $request->input('content');
            $news->visitor = $request->input('visitor');
            $news->is_active = $request->input('is_active');

            // Check if data saved
            if($news->save())
            {
                return Response::json(array(
                    'status' => 'success',
                    'message' => 'News successfully update.'
                ), 200);
            }
        }

        return Response::json(array(
            'status' => 'error',
            'message' => 'News failed update.'
        ), 200);

    }

    /*
     * Get one data news by uuid
     * @return json data news by uuid
     */
    public function get(Request $request, $uuid)
    {
        // Get all data news from database
        $news = News::where('uuid', base64_decode($uuid))->first();

        // Set array data into json format
        $news->toJson();
        return $news;
    }

    /*
     * Delete one data news by uuid
     * @return json status delete data
     */
    public function delete(Request $request, $uuid)
    {
        // Get one data news from database
        $news = News::where('uuid', $uuid)->first();

        // Check if data delete
        if($news->delete())
        {
            return Response::json(array(
                'status' => 'success',
                'message' => 'News successfully delete.'
            ), 200);
        }
        else
        {
            return Response::json(array(
                'status' => 'error',
                'message' => 'News failed delete.'
            ), 200);
        }
    }

}
