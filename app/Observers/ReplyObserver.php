<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;
use Auth;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function created(Reply $reply)
    {
        if (! app()->runningInConsole() && $reply->topic->user->id != Auth::id()) {    //不要通知话题的作者本人
            if (method_exists(TopicReplied::class, 'toDatabase')) {
                $reply->topic->user->increment('notification_count');   //只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
            }
            $reply->topic->user->notify(new TopicReplied($reply));
        }
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
    }
}
