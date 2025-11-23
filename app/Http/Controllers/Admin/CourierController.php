<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Courier\CourierFactory;
use Illuminate\Validation\ValidationException;

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
            dd($request->all(), $orderResponse);

            return response()->json([
                'status' => 'success',
                'data' => $orderResponse,
            ], 201);
        } catch (ValidationException $ve) {
            return response()->json([
                'status' => 'fail',
                'errors' => $ve->errors(),
            ], 422);
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
        // Log error, etc. here if you want

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage() ?: 'Something went wrong',
        ], 500);
    }



    public function createOrderStore(Request $request, string $courier)
    {
        // step 1: call service
        $service = CourierFactory::make($courier);
        $response = $service->createOrder($request->all());

        // step 2: save response
        $saved = CourierOrder::create([
            'provider'           => $courier,
            'provider_order_id'  => $response['order_id'] ?? null,
            'merchant_order_id'  => $request->merchant_order_id,

            'recipient_name'     => $request->recipient_name,
            'recipient_phone'    => $request->recipient_phone,
            'recipient_address'  => $request->recipient_address,

            'city_id'            => $request->city_id,
            'zone_id'            => $request->zone_id,
            'area_id'            => $request->area_id,

            'item_quantity'      => $request->item_quantity,
            'item_weight'        => $request->item_weight,
            'item_type'          => $request->item_type,
            'delivery_type'      => $request->delivery_type,
            'amount_to_collect'  => $request->amount_to_collect,
            'item_description'   => $request->item_description,

            'status'             => 'created',
            'provider_response'  => $response,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Order created and saved successfully!',
            'data' => $saved
        ]);
    }
}
