<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddFavourite;
use App\Models\Favourite;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    // fetch favourites
    public function fetchFavourites()
    {
        try {
            $user = Auth::user();
            $favourite = Favourite::where('user_id', '=', $user->id)->with(['service'])->get();
            return response(['success' => true, 'favourite' => $favourite]);
        } catch (Exception $e) {
            return response(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function addFavourite(AddFavourite $request)
    {

        try {
            $user = Auth::user();
            $data = $request->validated();
            $data['user_id'] = $user->id;
            Favourite::create($data);
            return response(['success' => true, 'msg' => 'This is service is added to your favourite list']);
        } catch (Exception $e) {
            return response(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function deleteFavourite(Request $request)
    {
        try {
            $user = Auth::user();
            $favourite = Favourite::query()->find($request['id']);
            if ($favourite['user_id'] == $user->id) {
                $favourite->delete();
            } else {
                return response(['success' => false, 'msg' => 'You are not allowed to DELETE!']);
            }
            return response(['success' => true, 'msg' => 'Deleted successfully']);
        } catch (Exception $e) {
            return response(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
