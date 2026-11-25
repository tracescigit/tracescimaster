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
use Illuminate\Support\Facades\Http;

class SandEmail
{
	protected static function sendold($slug, $input)
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
	public static function sendEmailold($input)
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

	protected static function send($slug, $input)
	{
		try {

			$input = (array) $input;

			$template = EmailTemplate::whereSlug($slug)->first();

			if (!$template) {
				Log::error('Email Template Not Found', [
					'slug' => $slug
				]);

				return false;
			}

			if (empty($template->msg91_template_id)) {
				Log::error('MSG91 Template ID Missing', [
					'slug' => $slug
				]);

				return false;
			}

			// Basic application variables
			$input['app_name'] = config('app.name');
			$input['app_url'] = url('/');

			// Prepare URL variables
			if (isset($input['url']) && is_array($input['url'])) {
				foreach ($input['url'] as $key => $url) {
					$input[$key] = $input['app_url'] . $url;
				}
			}

			// Read dynamic variable names
			$dynamicValues = array_filter(
				array_map('trim', explode(',', $template->text_tag ?? ''))
			);

			$dynamicValues = array_unique(array_merge(
				$dynamicValues,
				['app_name', 'app_url']
			));

			// Prepare MSG91 variables
			$variables = [];

			foreach ($dynamicValues as $key) {
				$variables[$key] = $input[$key] ?? '';
			}

			$arrayData = [
				'email' => $input['email'],
				'template_id' => $template->msg91_template_id,
				'variables' => $variables,
			];

			// Optional CC and BCC
			if (!empty($input['cc'])) {
				$arrayData['cc'] = $input['cc'];
			}

			if (!empty($input['bcc'])) {
				$arrayData['bcc'] = $input['bcc'];
			}

			return self::sendEmail($arrayData);
		} catch (\Throwable $e) {

			Log::error('Email Processing Failed', [
				'slug' => $slug,
				'message' => $e->getMessage()
			]);

			return false;
		}
	}

	public static function sendEmail($input)
	{
		try {

			$templateId = $input['template_id'];

			$payload = [
				'recipients' => [
					[
						'to' => [
							[
								'email' => $input['email']
							]
						],
						'variables' => $input['variables'] ?? []
					]
				],

				'from' => [
					'name' => config('services.msg91.from_name'),
					'email' => config('services.msg91.from_email')
				],

				'domain' => config('services.msg91.email_domain'),

				'template_id' => (string) $input['template_id'],
			];

			// Optional CC
			if (!empty($input['cc'])) {
				$payload['recipients'][0]['cc'] = collect(
					(array) $input['cc']
				)->map(function ($email) {
					return ['email' => $email];
				})->values()->all();
			}

			if (!empty($input['bcc'])) {
				$payload['recipients'][0]['bcc'] = collect(
					(array) $input['bcc']
				)->map(function ($email) {
					return ['email' => $email];
				})->values()->all();
			}

			$response = Http::withHeaders([
				'accept' => 'application/json',
				'authkey' => config('services.msg91.auth_key'),
				'content-type' => 'application/json',
			])->post(
				'https://control.msg91.com/api/v5/email/send',
				$payload
			);

			$result = $response->json();

			if (
				$response->successful() &&
				isset($result['status']) &&
				$result['status'] === 'success' &&
				empty($result['hasError'])
			) {

				Log::info('MSG91 Email Sent', [
					'email' => $input['email'],
					'response' => $result
				]);

				return true;
			}

			Log::error('MSG91 Email Failed', [
				'email' => $input['email'],
				'status_code' => $response->status(),
				'response' => $result
			]);

			return false;
		} catch (\Throwable $e) {

			Log::error('MSG91 Email Exception', [
				'message' => $e->getMessage(),
				'file' => $e->getFile(),
				'line' => $e->getLine()
			]);

			return false;
		}
	}

	public static function createMsg91Template($input)
	{
		try {

			$payload = [
				'name' => $input['name'],
				'slug' => $input['slug'],
				'subject' => $input['subject'],
				'body' => $input['body'],
			];

			$response = Http::withHeaders([
				'accept' => 'application/json',
				'authkey' => config('services.msg91.auth_key'),
				'content-type' => 'application/json',
			])->post(
				'https://control.msg91.com/api/v5/email/templates',
				$payload
			);

			Log::info('MSG91 Template Creation Response', [
				'response' => $response->json()
			]);

			return $response->json();
		} catch (\Throwable $e) {

			Log::error('MSG91 Template Creation Failed', [
				'message' => $e->getMessage()
			]);

			return false;
		}
	}
}
