<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFriendListRequest;
use App\Http\Requests\UpdateFriendListRequest;
use App\Models\FriendList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\Friendrequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class FriendListController extends Controller
{
    public function friendList()
    {
        $user = Auth::user();

        $data = FriendList::where('user_id', $user->id)
            ->orderby('id', 'desc')
            ->paginate(5);

        return view('list')->with(array('data' => $data));
    }

    public function removeFriend(Request $request)
    {
        FriendList::where('id', $request->id)
            ->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Login Succesfully.',
            "redirect_location" => url("friend-list")
        ]);
    }

    public function searchbyName(Request $request)
    {
        $user = Auth::user();

        $data = FriendList::where('user_id', $user->id)
            ->where('name', 'LIKE', "%{$request->friendName}%")
            ->orderby('id', 'desc')
            ->paginate(5);

        return view('list')->with(array('data' => $data));
    }

    public function sendRequest(Request $request)
    {
        $validate = validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validate->fails()) {

            return response()->json([
                'status' => 400,
                'validate' => $validate->messages(),
            ]);
        } else {
            $user = Auth::user();

            $data['user_id'] = $user->id;
            $data['email'] = $request->email;
            FriendList::create($data);

            $friend = FriendList::where($data)
                ->get();

            foreach ($friend as $friend) {
                $url = route('make.friend', ['user_id' => $friend->user_id, 'friend_id' => $friend->id]);
            }
            $mailData = [
                'url' => $url
            ];

            Mail::to($request->email)->send(new Friendrequest($mailData));
            return response()->json([
                'status' => 200,
                'message' => 'Invitation Send.',
            ]);
        }
    }

    public function inviteFriends(Request $request)
    {
        $data['user_id'] = $request->user_id;
        $data['id'] = $request->friend_id;
        $data['invitation_type'] = 'sent';

        $friend = FriendList::where($data)
            ->get();
        if (sizeof($friend)) {

            $user_id['user_id'] = $request->user_id;
            $id['id'] = $request->friend_id;

            return view('confirminvitation')->with(array('user_id' => $user_id, 'id' => $id));
        } else {
            $data1['user_id'] = $request->user_id;

            return view('newfriends')->with(array('data' => $data1));
        }
    }

    public function confirmInvitation(Request $request)
    {
        $validate = validator::make($request->all(), [
            'name' => 'required|min:5|max:255',
            'email' => 'required|email',
        ]);

        if ($validate->fails()) {

            return response()->json([
                'status' => 400,
                'validate' => $validate->messages(),
            ]);
        } else {
            $data['user_id'] = $request->user_id;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['invitation_type'] = 'confirmed';

            $friend = FriendList::create($data);
            return response()->json([
                'status' => 200,
            ]);
        }
    }

    public function acceptInvitation(Request $request)
    {
        $validate = validator::make($request->all(), [
            'name' => 'required|min:5|max:255',
        ]);


        if ($validate->fails()) {

            return response()->json([
                'status' => 400,
                'validate' => $validate->messages(),
            ]);
        } else {
            $data['user_id'] = $request->user_id;
            $data['id'] = $request->id;

            $update['name'] = $request->name;
            $update['invitation_type'] = 'confirmed';

            FriendList::where($data)
                ->update($update);
            return response()->json([
                'status' => 200,
            ]);
        }
    }
}
