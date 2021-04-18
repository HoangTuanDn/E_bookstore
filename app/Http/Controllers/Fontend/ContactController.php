<?php

namespace App\Http\Controllers\fontend;


use App\Http\Requests\EmailContactRequest;
use App\Models\EmailContact;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    private EmailContact $emailContact;
    private Setting $setting;

    /**
     * HomeController constructor.
     * @param EmailContact $emailContact
     * @param Setting $setting
     */
    public function __construct(EmailContact $emailContact, Setting $setting)
    {
        $this->emailContact = $emailContact;
        $this->setting = $setting;
    }

    public function index()
    {
        $settings = $this->setting->get(['config_key', 'config_value']);
        $data = [];
        foreach ($settings as $setting) {
            $data[$setting->config_key] = $setting->config_value;
        }

        return view('fontend.contact.contact', compact('data'));
    }

    public function register(EmailContactRequest $request)
    {

        $dataInsert = $request->only([
            'email',
        ]);

        try {
            $isCreated = true;
            $this->emailContact->create($dataInsert);

        } catch (\Exception $e) {
            $isCreated = false;
            Log::error('message: ' . $e->getMessage() . '--file : ' . $e->getFile() . '--Line : ' . $e->getLine());
        }

        if ($isCreated) {
            $json = [
                'success' => true,
                'data'    => [
                    'type'    => 'success',
                    'message' => __('register_contact_email_success'),
                ],
                'code'    => Response::HTTP_CREATED
            ];
        } else {
            $json = [
                'success' => false,
                'errors'  => [
                    [__('error_message')]
                ],
                'code'    => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
        return response()->json($json, $json['code']);

    }
}
