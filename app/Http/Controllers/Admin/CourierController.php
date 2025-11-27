<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Services\Courier\CourierFactory;
use Illuminate\Validation\ValidationException;
use stdClass;

class CourierController extends Controller
{
    protected $factory;

    public function __construct(CourierFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Get list of cities for the given courier
     */
    public function getCities(string $courierSlug)
    {
        try {
            $courier = $this->factory->make($courierSlug);
            $cities = $courier->getCities();

            return response()->json([
                'status' => 'success',
                'data' => $cities,
            ]);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Get zones for a city for the given courier
     */
    public function getZones(string $courierSlug, int $cityId)
    {
        try {
            $courier = $this->factory->make($courierSlug);
            $zones = $courier->getZones($cityId);

            return response()->json([
                'status' => 'success',
                'data' => $zones,
            ]);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Get areas for a zone for the given courier
     */
    public function getAreas(string $courierSlug, int $zoneId)
    {
        try {
            $courier = $this->factory->make($courierSlug);
            $areas = $courier->getAreas($zoneId);

            return response()->json([
                'status' => 'success',
                'data' => $areas,
            ]);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Create a new order with the courier
     */
    public function createOrder(Request $request, string $courierSlug)
    {
        try {
            $courier = $this->factory->make($courierSlug);

            $validatedData = $this->validateOrderData($request);
            $orderResponse = $courier->createOrder($validatedData);
            if(isset($orderResponse['code']) && $orderResponse['code'] != 200){
                throw new Exception($orderResponse['message'] ??"Something went wrong", 500);
            }
            $resp = new stdClass();

            $resp->consignment_id     = $orderResponse["data"]['consignment_id'];
            $resp->provider           = $courierSlug;
            $resp->request_payload    = $validatedData;
            $resp->response_payload   = $orderResponse["data"];
            $resp->merchant_order_id  = $orderResponse['data']['consignment_id'];

            // Better value for order_status (consignment_id is not a status!)
            $resp->order_status       = $orderResponse['data']['status']
                ?? $orderResponse['data']['order_status']
                ?? 'created'; // or 'pending', 'booked', etc.

            // Optional: make it clean and safe
            $resp->consignment_id ??= null; // in case key doesn't exist
            $this->createOrderStore($request, $resp);

            return back()->with('success', 'Order created successfully!');
        } catch (ValidationException $ve) {
            return back()->withErrors($ve->errors())->withInput();
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Validate the order request data
     */
    protected function validateOrderData(Request $request)
    {
        return $request->validate([
            'store_id' => 'required|integer',
            'merchant_order_id' => 'sometimes|string|max:100',
            'recipient_name' => 'required|string|min:3|max:100',
            'recipient_phone' => 'required|string|size:11',
            'recipient_secondary_phone' => 'nullable|string|size:11',
            'recipient_address' => 'required|string|min:10|max:220',
            'recipient_city' => 'nullable|integer',
            'recipient_zone' => 'nullable|integer',
            'recipient_area' => 'nullable|integer',
            'delivery_type' => 'required|integer|in:12,48',
            'item_type' => 'required|integer|in:1,2',
            'special_instruction' => 'nullable|string|max:255',
            'item_quantity' => 'required|integer|min:1',
            'item_weight' => 'required|numeric|min:0.5|max:10',
            'item_description' => 'nullable|string|max:500',
            'amount_to_collect' => 'required|integer|min:0',
        ]);
    }

    /**
     * Handle exceptions and format response
     */
    protected function handleException(\Exception $e)
    {

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage() ?: 'Something went wrong',
        ], 500);
    }



    public function createOrderStore(Request $request, $response)
    {
        try{

            $order=\DB::table('orders')->where('id', $request->order_id)->update([
                'courier_name'=>$response->provider,
                'courier_tracking_id'=>$response->consignment_id
            ]);

            $saved = \DB::table('courier_orders')->insert([
                'courier'           => $response->provider,
                'order_id'  => $request->order_id,
                'consignment_id'  => $response->consignment_id,
                'status'             => $response->order_status,
                'request_payload'             => json_encode($response->request_payload),
                'response_payload'             => json_encode($response->response_payload),
                'sent_at'  => now(),
            ]);
            return $saved;
        }catch (\Exception $e){
            throw $e;
        }
    }
}
// for testing
// PATHAO_CLIENT_ID=pmbk7XEbzJ
// PATHAO_CLIENT_SECRET=CPExGvdwHKEQi8RHDzSIJPgt5HUvObns3qHMjlPC
// PATHAO_USERNAME=pulakbala1082@gmail.com
// PATHAO_PASSWORD=@Gmail.com1082&
// PATHAO_BASE_URL=https://merchant.pathao.com/api
// PATHAO_ENV=live
// PATHAO_STORE_ID=347940

// live server
// PATHAO_CLIENT_ID=7N1aMJQbWm
// PATHAO_CLIENT_SECRET=wRcaibZkUdSNz2EI9ZyuXLlNrnAv0TdPUPXMnD39
// PATHAO_USERNAME=test@pathao.com
// PATHAO_PASSWORD=lovePathao
// PATHAO_BASE_URL=https://courier-api-sandbox.pathao.com
// PATHAO_ENV=live
// PATHAO_STORE_ID=149046
