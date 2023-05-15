<?php

namespace App\Http\Controllers;

use App\Application\Mappers\CustomerMapper;
use App\Application\UseCases\Customer\Commands\DestroyCustomerCommand;
use App\Application\UseCases\Customer\Commands\StoreCustomerCommand;
use App\Application\UseCases\Customer\Commands\UpdateCustomerCommand;
use App\Application\UseCases\Customer\Queries\FindAllCustomersQuery;
use App\Application\UseCases\Customer\Queries\FindCustomerByIdQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Application\DTO\CustomerDTO;

use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{

    public function index(): JsonResponse
    {
        return response()->json((new FindAllCustomersQuery())->handle());
    }

    public function show(int $id): JsonResponse
    {
        $customer = (new FindCustomerByIdQuery($id))->handle();
        return response()->json($customer);
    }

    public function store(Request $request): JsonResponse
    {
        $newCustomer = CustomerMapper::fromRequest($request);
        $customer = (new StoreCustomerCommand($newCustomer))->execute();
        return response()->json($customer, Response::HTTP_CREATED);
    }

    public function update(int $customer_id, Request $request): JsonResponse
    {
        $customer = CustomerDTO::fromRequest($request, $customer_id);
        (new UpdateCustomerCommand($customer))->execute();
        return response()->json($customer);
    }

    public function destroy(int $customer_id): JsonResponse
    {
        (new DestroyCustomerCommand($customer_id))->execute();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}