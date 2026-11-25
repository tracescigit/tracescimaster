<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CustomClasses\EmailProvider;
use Illuminate\Support\Facades\Http;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Log;

class Msg91TemplateController extends Controller
{
    public function syncTemplates(Request $request)
    {
        $templates = EmailTemplate::whereNull('msg91_template_id')
            ->get();

        if ($templates->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'All templates are already synced with MSG91.',
                'total' => 0,
                'success' => 0,
                'failed' => 0,
            ]);
        }

        $success = [];
        $failed = [];

        foreach ($templates as $template) {

            try {

                $payload = [
                    'name' => $template->slug,
                    'slug' => $template->slug,
                    'subject' => $template->subject,
                    'body' => $template->email_body,
                ];

                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'authkey' => config('services.msg91.auth_key'),
                ])
                    ->timeout(60)
                    ->post(
                        'https://control.msg91.com/api/v5/email/templates',
                        $payload
                    );

                $result = $response->json();

                // Check MSG91 response
                if (
                    $response->successful() &&
                    !empty($result['data']['id'])
                ) {

                    // Save MSG91 template ID
                    $template->msg91_template_id =
                        $result['data']['id'];

                    $template->save();

                    $success[] = [
                        'id' => $template->id,
                        'slug' => $template->slug,
                        'msg91_template_id' =>
                        $result['data']['id'],
                    ];
                } else {

                    $failed[] = [
                        'id' => $template->id,
                        'slug' => $template->slug,
                        'response' => $result,
                    ];

                    Log::error('MSG91 Template Creation Failed', [
                        'slug' => $template->slug,
                        'response' => $result,
                    ]);
                }
            } catch (\Throwable $e) {

                $failed[] = [
                    'id' => $template->id,
                    'slug' => $template->slug,
                    'error' => $e->getMessage(),
                ];

                Log::error('MSG91 Template Sync Exception', [
                    'slug' => $template->slug,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return response()->json([
            'status' => count($failed) === 0,
            'message' => 'MSG91 template synchronization completed.',
            'total' => $templates->count(),
            'success' => count($success),
            'failed' => count($failed),
            'successful_templates' => $success,
            'failed_templates' => $failed,
        ]);
    }
}
