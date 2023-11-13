<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plan\CreatePlanRequest;
use App\Models\Plan;
use Illuminate\Http\Request;
use Stripe\Price;
use Stripe\Stripe;
use Stripe\StripeClient;

Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
class PlanController extends Controller
{
    public function fetchPlans()
    {
        $plan = Plan::query()->get();
        return response(['success' => true, 'plans' => $plan]);
    }


    public function createPlan(CreatePlanRequest $request)
    {
        try {
            $data = $request->validated();

            $stPlan = Price::create([
                'unit_amount' => $request->price * 100,
                'currency' => 'usd',
                'recurring' => [
                    'interval' => $request->interval,
                ],
                'product_data' => [
                    'name' => $request->name,
                ],
            ]);
            if ($stPlan && $stPlan->active) {
                $data['st_plan_id'] = $stPlan->id;
                $data['price'] = $request->price;
                $pl = Plan::create($data);
                return response(['success' => true, 'msg' => 'New Plan Created', 'data' => $pl]);
            } else return response(['success' => false, 'msg' => 'Something Went Wrong']);
        } catch (\Throwable $th) {
            return response(['success' => false, 'msg' => $th->getMessage()]);
        }
    }

    public function deletePlan(Request $request, string $id)
    {
        try {
            $findPlan = Plan::query()->find($id);
            if (!$findPlan->id) {
                return response(['success' => false, 'msg' => 'Not found!']);
            }
            Price::update($findPlan->st_plan_id, ['active' => false]);
            $findPlan->delete();
            return response(['success' => true, 'msg' => 'Deleted successfully']);
        } catch (\Throwable $th) {
            return response(['success' => false, 'msg' => $th->getMessage()]);
        }
    }
}
