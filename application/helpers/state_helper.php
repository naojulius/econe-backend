<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('GET_STATE_ID')) 
{
    function GET_STATE_ID($status)
    {
        switch ($status) {
			case StateEnum::PAYED_NOT_EXPIRED:
				return '5A2D6413-37E5-70CC-D2BF-0BE2F7E26BE2';
				break;
			case StateEnum::PAYED_EXPIRED:
				return "AF501735-781A-F3FF-FA23-153ADEAB3217";
				break;
			case StateEnum::EXPIRED_NOT_PAYED:
				return "2E91A75B-D204-7186-743F-9BCFA91FDF55";
				break;
			case StateEnum::NOT_PAYED_NOT_EXPIRED:
				return "4E91B75B-D204-7186-744F-9BCFA91FDF55";
				break;

		}
    }
}