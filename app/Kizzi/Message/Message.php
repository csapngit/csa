<?php namespace Biotrent\Message;
use App\Models\UserMessage;

class Message
{
	public static function count($from, $to, $status)
	{
        $result = UserMessage::select('user_messages.*', 'users.fullname', 'users.avatar')
            ->leftjoin('users', 'user_messages.from', '=', 'users.id');
        if($from != 0){
            $result = $result->where('user_messages.from', $from);
        }
        if($to != 0){
            $result = $result->where('user_messages.to', $to);
        }
        $result = $result->where('user_messages.status', $status)->count();
		return $result;
	}

	public static function getMessage($from, $to, $status)
    {
        $result = UserMessage::select('user_messages.*', 'users.fullname', 'users.avatar')
					->leftjoin('users', 'user_messages.from', '=', 'users.id');
        if($from != 0){
            $result = $result->where('user_messages.from', $from);
        }
        if($to != 0){
            $result = $result->where('user_messages.to', $to);
        }
        $result = $result->where('user_messages.status', $status)->get();
        return $result;
    }
}