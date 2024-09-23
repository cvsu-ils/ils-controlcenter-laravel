<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use Illuminate\Http\Request;
use App\Events\SendNotifications;


class NotificationsController extends Controller
{
   public function sendNotification(Request $request){

        $type = $request->input('type');
        $message = $request->input('message');

        event(new SendNotifications($message));

        $notification = new Notifications;
        $notification->user_id = 1;
        $notification->message = $message;
        $notification->notifications_type_id = $type;
        $notification->has_read = 0;
        $notification->save();


        return response()->json(['success' => true]);


   }
   public function getUnreadNotificationCount()
   {
       $count = Notifications::where('has_read', 0)->count();
       $notifications = Notifications::limit(5)->orderBy('created_at', 'desc')->get();
   
       return response()->json(['count' => $count, 'notifications' => $notifications]);
   }

   public function markAsRead()
   {
       Notifications::where('has_read', 0)->update(['has_read' => 1]);
   
       return response()->json(['message' => 'Notifications marked as read']);
   }

   public function getAllNotificationCount(){
    $notifications = Notifications::orderBy('created_at', 'desc')->get();

    return response()->json($notifications);
   }
   

}
