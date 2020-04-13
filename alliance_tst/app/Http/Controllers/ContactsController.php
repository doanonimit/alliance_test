<?php

namespace App\Http\Controllers;

use App\SourceContact;
use Illuminate\Http\Request;
use DateTime;

class ContactsController extends Controller
{

    public function save(Request $request) {
        $source_id = $request->input('source_id');
        $items = $request->input('items');

        if (empty($source_id) || empty($items)) {
            return 0;
        }

        foreach ($items as $item) {
            if (!$this->validateItem($item)) {
                return 0;
            }
        }

        $last_contact_created_at = SourceContact::where('source_id', $source_id)
            ->orderBy('created_at', 'desc')
            ->first();
        if (!empty($last_contact_created_at) && date_diff(new DateTime(), new DateTime($last_contact_created_at->created_at))->days < 1) {
            return 0;
        }

        foreach ($items as $item) {
            $contact = new SourceContact();

            $contact->source_id = $source_id;
            $contact->name = $item['name'];
            $contact->phone = substr($item['phone'], -10);
            $contact->email = $item['email'];

            $contact->save();
        }

        return count($items);
    }

    public function show(Request $request) {
        $this->validate($request, [
            'phone' => 'required'
        ]);

        $response = [];
        $contacts = SourceContact::where('phone', $request->input('phone'))
            ->get();

        foreach ($contacts as $contact) {
            $response[] = [
                'name' => $contact->name,
                'phone' => $contact->phone,
                'email' => $contact->email
            ];
        }

        return $response;
    }

    private function validateItem($item) {
        $required_fields = [
            'name', 'phone', 'email'
        ];
        $fields_validators = [
            'phone' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/',
            'email' => '/.+@.+\..+/'
        ];

        foreach ($required_fields as $field){
            if (isset($item[$field]) && !empty($item[$field])) {
                if (isset($fields_validators[$field]) && preg_match($fields_validators[$field], $item[$field]) === 0) {
                    return false;
                }
            } else {
                return false;
            }
        }

        return true;
    }
}
