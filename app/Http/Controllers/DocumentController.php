<?php

namespace App\Http\Controllers;

use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        // $this->apiKey = 'MGIwZDNmNzUtYWVmNi00ZDcyLTlmODYtNjNjMTk0MGM3Nzc0'; //pooja
        $this->apiKey = 'NWIzNDA1MGQtMjViNy00YTI0LWJiYjEtYTc5OWZmZTE1MTUy'; //dhara
        // $this->apiKey = 'Y2I3M2E3NjAtNzNiMy00ZmQyLThmZjgtNmQyYTA4YjNjMWQ2'; //sweety
    }
    public function showSendDocumentForm()
    {
        return view('document.send');
    }
    public function sendDocument(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $OnBehalfOf = $request->input('OnBehalfOf');
        $url = 'https://api.boldsign.com/v1/document/send';
        $filePath = public_path('pdfs/leave_policy.pdf');
        // $pageCount = $this->getPageCount($filePath);
        $pageCount = $this->count($filePath);
        // dd($pageCount);
        $signer = array(
            'name' => $name,
            'emailAddress' =>  $email,
            'signerType' => 'Signer',
            'authenticationType' => 'AccessCode',
            'authenticationCode' => '123',
            'formFields' => array(
                array(
                    'id' => 'string',
                    'name' => 'string',
                    'fieldType' => 'Signature',
                    'pageNumber' => $pageCount,
                    'bounds' => array(
                        'x' => 500,
                        'y' => 500,
                        'width' => 200,
                        'height' => 25,
                    ),
                    'isRequired' => true,
                ),
            ),
            'locale' => 'EN',
        );
        //sytm33@gmail.com,  ankita.hirpara56@gmail.com, pooja.solapurmath461@gmail.com,
        //arshdeepjhagra@gmail.com, arshdeep.singh@theknowledgeacademy.com
        $emailString = "pooja.solapurmath461@gmail.com";
        $emails = array_map('trim', explode(',', $emailString));
        $uniqueEmails = array_unique($emails);

        $ccRecipients = array_map(function ($email) {
            return array('emailAddress' => $email);
        }, $uniqueEmails);

        foreach ($ccRecipients as $ccRecipient) {
            if ($ccRecipient['emailAddress'] === $signer['emailAddress']) {
                continue;
            }
            $ccFormData[] = [
                'name' => 'cc[]',
                'contents' => json_encode($ccRecipient),
            ];
        }

        $ccValues = [];
        foreach ($ccFormData as $index => $ccRecipient) {
            $ccValues[] = $ccRecipient['contents'];
        }

        $postData = array(
            'AutoDetectFields' => 'true',
            // 'allowConfigureFields'=> 'false',
            'Message' => 'sign the document',
            'OnBehalfOf' => $OnBehalfOf,
            'Signers' => json_encode($signer),
            // 'disableEmails' => 'true',
            'cc' => $ccValues,
            'Files' => new CURLFile($filePath, 'application/pdf', 'leave_policy.pdf'),
            'Title' => 'eSign Document',

        );

        $headers = array(
            'X-API-KEY: ' . $this->apiKey,
            'Content-Type: multipart/form-data'
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Curl error:' . curl_error($ch);
        }
        curl_close($ch);
        echo $response;
        $responseData = json_decode($response, true);
        // $documentId = $responseData['documentId'];
        // echo '<a href="' . route('generate-link', ['documentId' => $documentId, 'email' => $email]) . '">Generate Link</a>';

        return "Mail sent to $name ($email)";
    }
    function count($pdfFilePath)
    {
        $pdf = file_get_contents($pdfFilePath);
        $pageCount = preg_match_all("/\/Page\W/", $pdf);
        return $pageCount;
    }
    public function listDocument()
    {
        $url = 'https://api.boldsign.com/v1/document/list';
        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
        ])->get($url, [
            'page' => 1,
            'pagesize' => 30,
        ]);
        return view('document.list', ['response' => json_decode($response)]);
    }
    public function downloadPdf(Request $request)
    {
        // $documentId = $request->input('documentId');
        $documentId = '826a40ae-c2ce-419c-8129-75426f7416ea';
        $onBehalfOf = 'dharakadivar25@gmail.com';
        $apiUrl = "https://api.boldsign.com/v1/document/download?documentId=$documentId&OnBehalfOf=$onBehalfOf";

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'X-API-KEY' => $this->apiKey,
        ])->get($apiUrl);

        if ($response->successful()) {
            $pdfContent = $response->body();
            Storage::disk('pdfs')->put("document_$documentId.pdf", $pdfContent);
            return response()->json(['message' => 'PDF downloaded and stored successfully']);
        } else {
            return response()->json(['error' => 'Failed to download PDF'], $response->status());
        }
    }
    public function sendRemind(Request $request)
    {
        $documentId = $request->input('documentId');
        $url = "https://api.boldsign.com/v1/document/remind?documentId=$documentId";

        $response = Http::withHeaders([
            'accept' => '*/*',
            'X-API-KEY' => $this->apiKey,
            'Content-Type' => 'application/json'
        ])->post($url, [
            "message" => "Reminder to sign the document",
        ]);

        if ($response->failed()) {
            return 'HTTP request failed: ' . $response->body();
        }
        return "Reminder sent.";
    }
    public function revokeDocument(Request $request)
    {
        $documentId = $request->input('documentId');

        $message = 'Document is revoked';

        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("https://api.boldsign.com/v1/document/revoke?documentId=$documentId", [
            'message' => $message,
            'onBehalfOf' => 'dhara.patel@theknowledgeacademy.com'
        ]);
        // return redirect()->back()->with('success', json_decode($response->getBody(), true));

        // return response()->json($response->body());
        return redirect()->back()->with('success', 'Document Revoked');
    }
    public function extendExpiry(Request $request)
    {
        $documentId = $request->input('documentId');
        $url = "https://api.boldsign.com/v1/document/extendExpiry?documentId=$documentId";

        $postData = [
            'newExpiryValue' => '2024-06-15'
        ];

        $headers = [
            'X-API-KEY' => $this->apiKey,
            'Content-Type' => 'application/json',
        ];

        $response = Http::withHeaders($headers)
            ->patch($url, $postData);
        return $response->json();
    }
    public function behalfList()
    {
        $url = 'https://api.boldsign.com/v1/document/behalfList';
        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
        ])->get($url, [
            'page' => 1,
            'PageType' => 'BehalfOfOthers',
        ]);
        return view('behalf.list', ['response' => json_decode($response)]);
    }
    public function createIdentityForm()
    {
        return view('identity.create');
    }
    public function createIdentity(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        // $name = 'dhara';
        // $email = 'dhara.patel@theknowledgeacademy.com';
        $url = 'https://api.boldsign.com/v1/senderIdentities/create';

        Http::withHeaders([
            'accept' => '*/*',
            'X-API-KEY' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($url, [
            'name' => $name,
            'email' => $email,
        ]);
        return redirect('/listIdentity');
    }
    public function listIdentity()
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'X-API-KEY' => $this->apiKey,
        ])->get('https://api.boldsign.com/v1/senderIdentities/list', [
            'PageSize' => 10,
            'Page' => 1,
        ]);
        return view('identity.list', ['response' => json_decode($response)]);
    }
    public function deleteIdentity($email)
    {
        $url = 'https://api.boldsign.com/v1/senderIdentities/delete?email=' . urlencode($email);
        $response = Http::withHeaders([
            'accept' => '*/*',
            'X-API-KEY' => $this->apiKey,
        ])->delete($url, [
            'email' => $email,
        ]);
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Identity deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete identity');
        }
    }
    public function embeddedSigningLink($documentId, $email)
    {
        $redirectURL = 'http://127.0.0.1:8000/welcome';
        $url = "https://api.boldsign.com/v1/document/getEmbeddedSignLink?documentId=$documentId&signerEmail=$email&redirectUrl=$redirectURL";

        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
        ])->get($url);

        if ($response->successful()) {
            echo $response->body();
        } else {
            return 'HTTP request failed with status code ' . $response->status() . ': ' . $response->body();
        }
    }
    public function downloadAudittrail(Request $request)
    {
        $documentId = $request->input('documentId');
        $apiUrl = "https://api.boldsign.com/v1/document/downloadAuditLog?documentId=$documentId";

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'X-API-KEY' => $this->apiKey,
        ])->get($apiUrl);

        if ($response->successful()) {
            $pdfContent = $response->body();
            Storage::disk('audit-pdfs')->put("audit-trail_$documentId.pdf", $pdfContent);
            return response()->json(['message' => 'PDF downloaded and stored successfully']);
        } else {
            return response()->json(['error' => 'Failed to download PDF'], $response->status());
        }
    }
    public function apiCreditsCount()
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'X-API-KEY' => $this->apiKey,
        ])
            ->get('https://api.boldsign.com/v1/plan/apiCreditsCount');
        return $response->json();
    }
}
