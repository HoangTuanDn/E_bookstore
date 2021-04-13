<?php

namespace App\Http\Controllers\fontend;


use App\Http\Requests\EmailContactRequest;
use App\Models\EmailContact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    private $emailContact;

    /**
     * HomeController constructor.
     * @param $emailContact
     */
    public function __construct(EmailContact $emailContact)
    {
        $this->emailContact = $emailContact;
    }

    public function index()
    {
        return view('fontend.contact');
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
