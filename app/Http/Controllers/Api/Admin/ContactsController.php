<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactU;
use Illuminate\Http\Request;

class ContactsController extends Controller
{


    public function getContacts()
    {
        $contactSolved = ContactU::where('status','solved')->get();
        $contactUnsolved = ContactU::where('status','unsolved')->get();

        $data =[
            'solved'=> $contactSolved,
            'unsolved'=> $contactUnsolved
        ];

        return response()->json($data);
    }
}
