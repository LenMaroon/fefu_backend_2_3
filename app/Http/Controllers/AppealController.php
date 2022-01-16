<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appeal;
use App\Http\Requests\AppealPostRequest;
use App\Sanitizers\PhoneSanitizer;

class AppealController extends Controller
{
    //
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if($request->isMethod('POST')) {
            $validate = $request->validate(AppealPostRequest::rules());

            $appeal = new Appeal();
            $appeal->name = $validate['name'];
            $appeal->surname = $validate['surname'];
            $appeal->patronymic = $validate['patronymic'];
            $appeal->age = $validate['age'];
            $appeal->gender = $validate['gender'];
            $appeal->phone = PhoneSanitizer::num_sanitize($validate['phone']);
            $appeal->email = $validate['email'];
            $appeal->message = $validate['message'];
            $appeal->save();

            return redirect()
                ->route('appeal');
        }

        return view('appeal');
    }
}
