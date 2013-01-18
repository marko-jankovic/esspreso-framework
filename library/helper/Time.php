<?php

class Espresso_Helper_Time{
	
	function timeAgo($time = null) {
			
		if (!empty($time)) {
		
			$seconds = time() - $time;
			$how_many = null;
			$of_what = null;
			
			// less than 1 minute
			if ($seconds < 60) {
				$how_many = $seconds;
				if ($seconds == 0) {
					$how_many = "just now";
				} else if ($seconds == 1) {
					$of_what = "second ago";
				} else {
					$of_what = "seconds ago";
				}
			// between one minute and one hour
			} elseif ($seconds > 60 && $seconds < 3600) {
				$how_many = floor($seconds/60);
				if ($how_many == 1) {
					$of_what = "minute ago";
				} else {
					$of_what = "minutes ago";
				}
			// between one hour and 24 hours
			} elseif ($seconds > 3600 && $seconds < 86400) {
				$how_many = floor($seconds/3600);
				if ($how_many == 1) {
					$of_what = "hour ago";
				} else {
					$of_what = "hours ago";
				}
			// between 1 day and 1 week (7 days)
			} elseif ($seconds > 86400 && $seconds < 604800) {
				$how_many = floor($seconds/86400);
				if ($how_many == 1) {
					$of_what = "day ago";
				} else {
					$of_what = "days ago";
				}
			// betwen 1 week and 1 month approximately
			// taking there are 31,556,926 seconds in a year
			// divided by 12 months
			} elseif ($seconds > 604800 && $seconds < 2629743) {
				$how_many = floor($seconds/604800);
				if ($how_many == 1) {
					$of_what = "week ago";
				} else {
					$of_what = "weeks ago";
				}
			// betwen 1 month and 1 year (24 months)
			} elseif ($seconds > 2629743 && $seconds < 31556926) {
				$how_many = floor($seconds/2629743);
				if ($how_many == 1) {
					$of_what = "month ago";
				} else {
					$of_what = "months ago";
				}
			// from 1 year upwards
			} elseif ($seconds > 31556926) {
				$how_many = floor($seconds/31556926);
				if ($how_many == 1) {
					$of_what = "year ago";
				} else {
					$of_what = "years ago";
				}
			}
			
			return 'Posted '.$how_many.' '.$of_what;
		
		}
		
	}
	
	
}