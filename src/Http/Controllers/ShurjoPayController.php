<?php

namespace Yahrdy\Shurjopay\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yahrdy\Shurjopay\Shurjopay;

class ShurjoPayController extends Controller
{
    public function initiatePayment()
    {
        $client = new Shurjopay(500, route('shurjopay.response'));

        return $client->initiatePayment();
    }

    /**
     * Handle a response coming from ShurjoPay server
     * after a successful or failed transaction.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception|GuzzleException
     */
    public function response(Request $request)
    {
        $data = Shurjopay::decryptResponse($request->spdata);
        $txnId = $data->txID;
        $bankTxnId = $data->bankTxID;
        $amount = $data->txnAmount;
        $bankStatus = $data->bankTxStatus;
        $resCode = $data->spCode;
        $resCodeDescription = $data->spCodeDes;
        $paymentOption = $data->paymentOption;
        $res = [];

        switch ($resCode) {
            case '000':
                $status = 'Success';
                $res['message'] = 'Transaction attempt successful';
                break;
            default:
                $status = 'Failed';
                $res['message'] = 'Transaction attempt failed';
                break;
        }

        $redirectUrl = $request->get('success_url').
            "?status={$status}&msg={$res['message']}".
            "&tx_id={$txnId}&bank_tx_id={$bankTxnId}".
            "&amount={$amount}&bank_status={$bankStatus}&sp_code={$resCode}".
            "&sp_code_des={$resCodeDescription}&sp_payment_option={$paymentOption}";

        return redirect($redirectUrl);
    }

    public function verifyPayment()
    {
        $client = new Shurjopay(500, route('shurjopay.response'));

        return $client->verifyPayment();
    }
}
