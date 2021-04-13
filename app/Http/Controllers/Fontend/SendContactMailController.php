<?php

namespace App\Http\Controllers\Fontend;

use App\Http\Requests\ContactRequest;
use App\Mail\SendMail;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendContactMailController extends Controller
{
    private $mail;
    private $setting;

    /**
     * SendContactMailController constructor.
     * @param $setting
     */
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function send(ContactRequest $request)
    {
        $data = $request->only('name', 'subject', 'email', 'message');
        $setting = $this->setting->where('config_key', 'email')->first();

        try {
                Mail::to($setting->config_value)
                ->send(new SendMail($data['name'], $data['email'], $data['message'], $data['subject'] ));
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . 'Line : ' . $e->getLine());
            $isSuccess = false;
        }

        if (isset($isSuccess)) {
            return response()->json([
                'success' => false,
                'data'    => [
                    'type'    => 'error',
                    'message' => __('error_message'),
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'type'    => 'success',
                'message' => __('message_contact_success',['name' => $data['name']]),
            ]
        ]);
    }
}
