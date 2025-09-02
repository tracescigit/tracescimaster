<?php 
namespace App\CustomClasses;

use Mail;
use App\CustomClasses\SandEmail as Email;

class EmailProvider extends Email
{
	public static function emailSlugs()
	{
		// Keys are fixed 					# Changable
		return [		
			'user-welcome-mail'					=> 'user-welcome-mail',
			'user-forgot-password-mail'			=> 'user-forgot-password-mail',
			'add-user-mail'						=> 'add-user-mail',
			'user-profile-approval-mail'		=> 'user-profile-approval-mail',
			'buy-credit-mail'					=> 'buy-credit-mail',
			'transaction-mail'					=> 'transaction-mail',
			'invoice-generation-mail'			=> 'invoice-generation-mail',
		];
	}

	public static function sendMail($slug, $input = array())
	{
		$callback = lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $slug))));
		
		if(method_exists(get_class(), $callback)){
			self::$callback(self::getSlug($slug), $input);
		}else{
			parent::send($slug, $input);
		}
	}

	public static function getSlug($key)
	{
		return self::emailSlugs()[$key];
	}

	private static function userWelcomeMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	private static function forgotPasswordMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	private static function addUserMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	private static function userProfileApprovalMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}
	private static function buyCreditMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	private static function transactionMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}
	private static function invoiceGenerationMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}


}