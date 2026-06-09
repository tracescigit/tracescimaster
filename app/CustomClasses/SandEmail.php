<?php
/*
*	Don't change this file
* 	if you need changes you can change in 
* 	namespace App\CustomClasses\EmailProvider
*/

namespace App\CustomClasses;

use Mail;
use App\Models\EmailTemplate;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail as FacadesMail;

class SandEmail
{
	protected static function send($slug, $input)
	{
		$input = (array) $input;

		$template  				= EmailTemplate::whereSlug($slug)->first();
		$email_subject   		= $template->subject;
		$email_body     		= $template->email_body;
		$dynamic_values			= $template->text_tag;
		// trim all array values
		$dynamic_values 		= array_map('trim', explode(',', $template->text_tag));


		// add basic app url to urls
		$input['app_name']		= env('APP_NAME', 'TRACESCI');
		$input['app_url']		= url('/');
		if (isset($input['url'])) {
			foreach ($input['url'] as $key => $url) {
				$input[$key]		= $input['app_url'] . $url;
			}
		}

		$email_subject			= str_replace('{{app_name}}', $input['app_name'], $email_subject);

		// Replace dynamic values in email body
		$dynamic_values = array_merge($dynamic_values, ['app_name', 'app_url']);

		foreach ($dynamic_values as $values) {
			$email_subject 		= str_replace('{{' . $values . '}}', $input[$values], $email_subject);
		}

		foreach ($dynamic_values as $values) {
			$email_body 		= str_replace('{{' . $values . '}}', $input[$values], $email_body);
		}

		$array_data = [
			'email_body' => $email_body,
			'email_subject' => $email_subject,
			'email' => $input['email'],
		];


		if (isset($input['attachment']) && $input['attachment'] != '') {
			$array_data['attachment'] = $input['attachment'];
		}
		log::info('Email Data', $array_data);
		$send_email = sendEmail($array_data);
	}
	public static function sendEmail($input)
	{
		try {

			FacadesMail::send(
				'emails.email',
				[
					'email_body' => $input['email_body']
				],
				function ($message) use ($input) {

					$message->to($input['email'])
						->subject($input['email_subject']);

					if (!empty($input['bcc'])) {
						$message->bcc($input['bcc']);
					}
				}
			);

			return true;
		} catch (\Exception $e) {

			Log::error('Mail Failed', [
				'message' => $e->getMessage()
			]);

			return false;
		}
	}
	public static function sendCustomMail($input)
	{
		$input = (array) $input;

		$email_subject  = $input['subject'];
		$email_body     = $input['body'];

		FacadesMail::send('emails.email', ['email_body' => $email_body], function ($message) use ($email_subject, $input) {
			$message->to($input['email'], env('APP_NAME', 'TRACESCI'))
				->subject($email_subject);
		});
	}
	public static function sendDirectMail($input)
	{
		try {

			FacadesMail::send('emails.email', [
				'email_body' => $input['email_body']
			], function ($message) use ($input) {

				$message->to($input['email'])
					->subject($input['email_subject']);

				if (!empty($input['bcc'])) {
					$message->bcc($input['bcc']);
				}

				if (!empty($input['cc'])) {
					$message->cc($input['cc']);
				}
			});

			return true;
		} catch (\Exception $e) {

			Log::error('Mail Sending Failed', [
				'message' => $e->getMessage(),
				'file' => $e->getFile(),
				'line' => $e->getLine(),
			]);

			return false;
		}
	}
}
