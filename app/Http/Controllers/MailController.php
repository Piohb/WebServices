<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Shop;
use Illuminate\Http\Request;

class MailController extends Controller
{
    /**
     * Send a Mail to Shop
     *
     * @OA\Post(
     *     path="/mail_shop/{id}",
     *     tags={"Mail"},
     *     summary="Send a Mail to Shop",
     *     @OA\Parameter(
     *         description="shop id",
     *         in="path",
     *         name="id",
     *     ),
     *     @OA\RequestBody(
     *          description= "Provide product informations",
     *          @OA\JsonContent(
     *              type="object",
     *     			@OA\Property(property="subject", type="string", example="subject"),
     *     			@OA\Property(property="message", type="string", example="message"),
     *              @OA\Property(property="name", type="string", example="name"),
     *              @OA\Property(property="mail", type="email", example="mail")
     *          )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="mail sended",
     *          @OA\JsonContent(ref="#/components/schemas/Shop")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error",
     *      )
     *    )
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function mail($id){

        $this->validate(request(), [
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
            'mail' => ['required', 'email'],
            'name' => ['required', 'string']
        ]);

        $subject = request('subject');
        $message = request('message');
        $sender = request('mail');
        $name = request('name');

        $shop = Shop::findOrFail($id);
        $to_email = $shop->email;

        $data = array(
            "msg" => $message,
            "name" => $name,
            "mail" => $sender
        );

        Mail::send('mail', $data, function($mail) use ($to_email, $sender, $subject) {
            $mail->to($to_email)
                ->from($sender)
                ->subject($subject);
        });

        return response()->json(array('message' => $message));
    }
}
