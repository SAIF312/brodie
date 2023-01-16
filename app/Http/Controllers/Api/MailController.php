<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Mail;

class MailController extends Controller
{
    public function data_to_pdf(Request $request)
    {

        $pdf_data["business_name"] = $request->business_Name["businessName"];
        $pdf_data["No_of_items"] = $request->itemCount;
        $pdf_data["customer_name"] = $request->customerDetails["customerName"];
        $pdf_data["customer_email"] = $request->customerDetails["email"];
        $pdf_data["customer_date"] = $request->date;
        $pdf_data["installer_name"] = $request->installer["installerName"];
        $pdf_data["installer_note"] = ($request->installer["notes"]) ? $request->installer["notes"] : "Null";
        $item_details = [];
        foreach ($request->item_details as $key => $item) {
            $item_details[$key]["item"] = $item["item"];
            $item_details[$key]["count"] = $item["count"];
            $item_details[$key]["notes"] = ($item["note"]) ? $item["note"]["note"] : "Null";
        }

        $img = str_replace('data:image/png;base64,', '', $request->customer_signature);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $filename = uniqid() . '.png';
        $file = public_path() . '/admin/brodie/signatures/' . $filename;
        $success = file_put_contents($file, $data);


        $company_data = [
            'title' => 'Customer Signup',
            'email' => 'humaraja42@gmail.com',
        ];

        $customer_data = [
            'name' => $pdf_data["customer_name"],
            'title' => 'Signup Acknowledge',
            'email' => $pdf_data["customer_email"],
        ];


        $path = 'https://globaltechnologia.org/webAdmin/public/admin/brodie/signatures/' . $filename;

        $pdf_data["sign"] = $path;

        $pdf = PDF::loadView('admin.brodie.brodie', compact('pdf_data', 'item_details'));

        $pdf_name = "brodie_" . time() . ".pdf";

        try {
            // for company
            Mail::send('mail.brodie', $company_data, function ($message) use ($company_data, $pdf, $pdf_name) {

                $message->to($company_data["email"], $company_data["email"])

                    ->subject($company_data["title"])

                    ->attachData($pdf->output(), $pdf_name);
            });
            // for customer 
            Mail::send('mail.brodie_customer', $customer_data, function ($message) use ($customer_data, $pdf, $pdf_name) {

                $message->to($customer_data["email"], $customer_data["email"])

                    ->subject($customer_data["title"])

                    ->attachData($pdf->output(), $pdf_name);
            });

            return response()->json([
                "message" => "your mail is successfully sent",
                "status" => "200",
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
