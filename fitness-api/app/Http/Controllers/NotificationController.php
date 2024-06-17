<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display the specified resource.
     * @param string $id
     * @return mixed
     */
    public function show(string $id)
    {
        try{
            $user = User::findOrFail($id);
            $notifications = $user->notifications()->get();
            return response()->json($notifications);
        } catch(Exception) {
            return response()->json([
                'error' => true,
                'message' => 'Failed'
            ]);
        }    
    }
    
    /**
     * mask All notification Read
     * @param $request
     * @return mixed
     */
    public function maskAsRead(Request $request) {
        try {
            $user = $request->user();
            $user->unreadNotifications->each(function ($notification) {
                $notification->markAsRead();
            });
            return response() -> json(['message' => 'success']);
        } catch(Exception) {
            return response()->json([
                'error' => true,
                'message' => 'Failed'
            ]);
        }
    }
}
