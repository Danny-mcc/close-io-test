<?php

namespace App\Http\Controllers;

use App\Close\CloseIO;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function show()
    {
        return view('create');
    }


    public function store(Request $request)
    {
        // Validate email address
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $email = $request->get('email');

        $closeIO = new CloseIO(
            config('closeio.key'),
            config('closeio.organization_id')
        );

        $lead = $closeIO->findOrUpdateLead($email);

        $message = $lead->isNew() ? 'New lead added.' : 'Lead already exists.';

        return redirect()->back()->with('message', $message);
    }
}
