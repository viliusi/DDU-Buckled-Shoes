<?php

class Channel
{
    private $_name,
        $_description,
        $_channel_id;

    public static function getChannels()
    {
        $channels = Database::getInstance()->get('channels', array('channel_id', '>', '0'));
        //return list of channels
        return $channels;
    }

    public static function getChannel($id)
    {
        $ret = Database::getInstance()->get('channels', array('channel_id', '=', $id));

        if ($ret->count()) {
            return $ret->first();
        }
    }
}
