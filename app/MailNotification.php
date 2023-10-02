<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class MailNotification extends Model
{
    //For 
	protected $table = 'tbl_mail_notifications';

	protected $fillable = ['notification_label','notification_for','notification_text','subject','send_from','status','is_send','description_of_mailformate'];
}
