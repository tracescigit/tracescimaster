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
			'demo-schedule-email'				=> 'demo-schedule-email',
		];
	}

	public static function sendMail($slug, $input = array())
	{
		$callback = lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $slug))));

		if (method_exists(self::class, $callback)) {
			self::$callback(self::getSlug($slug), $input);
		} else {
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

	private static function demoScheduleEmail($slug, $input)
	{
		$template = \App\Models\EmailTemplate::whereSlug($slug)->first();

		$email_subject = $template->subject;
		$email_body    = $template->email_body;

		$input['app_name'] = env('APP_NAME', 'TRACESCI');
		$input['app_url']  = url('/');

		$dynamic_values = array_map('trim', explode(',', $template->text_tag));
		$dynamic_values = array_merge($dynamic_values, ['app_name', 'app_url']);

		foreach ($dynamic_values as $tag) {
			$email_subject = str_replace('{{' . $tag . '}}', $input[$tag] ?? '', $email_subject);
			$email_body    = str_replace('{{' . $tag . '}}', $input[$tag] ?? '', $email_body);
		}

		Mail::send('emails.email', ['email_body' => $email_body], function ($message) use ($email_subject, $input) {
			$message->to($input['email'], env('APP_NAME', 'TRACESCI'))
				->subject($email_subject);

			if (!empty($input['cc'])) {
				$message->cc($input['cc']);
			}
		});
	}
}
