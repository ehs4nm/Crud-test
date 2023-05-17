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

use OpenApi\Annotations as OA;

use Symfony\Component\HttpFoundation\Response;


/**
 * @OA\Info(
 *     title="Crud Test API",
 *     version="1.0.0",
 *     description="API documentation for My Laravel Crud Test project",
 *     @OA\Contact(
 *         email="mohiti.ehsan@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *  * @OA\Server(
 *     url="http://localhost",
 *     description="API server"
 * )
 */

 
class CustomerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/customers",
     *     tags={"customers"},
     *     summary="Get all customers",
     *     description="Get all customers list",
     *     operationId="index",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json((new FindAllCustomersQuery())->handle());
    }

    /**
     * @OA\Get(
     *     path="/api/customers/{customer}",
     *     tags={"customers"},
     *     summary="Get single customer",
     *     description="Get single customer",
     *     operationId="show",
     *       @OA\Parameter(
     *         name="customer",
     *         in="path",
     *         description="ID of customer to return",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $customer = (new FindCustomerByIdQuery($id))->handle();
        return response()->json($customer);
    }

    /**
     * @OA\Post(
     *     path="/api/customers",
     *     tags={"customers"},
     *     summary="Add new customer in database",
     *     operationId="store",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             type="object",
     *            @OA\Property(property="first_name", type="string", example="John"),
     *            @OA\Property(property="last_name", type="string", example="Doe"),
     *            @OA\Property(property="date_of_birth", type="string", format="date", example="1990-01-01"),
     *            @OA\Property(property="phone_number", type="string", example="+18026872706"),
     *            @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *            @OA\Property(property="bank_account_number", type="string", example="NL10NGKK6133690858")
     *           )
     *          )
     *     ),
     *
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $newCustomer = CustomerMapper::fromRequest($request);
        $customer = (new StoreCustomerCommand($newCustomer))->execute();
        return response()->json($customer, Response::HTTP_CREATED);
    }

    /**
     * @OA\Patch(
     *     path="/api/customers/{customer}",
     *     tags={"customers"},
     *     summary="update existing customer on database",
     *     operationId="update",
     *
     *
     *     @OA\Parameter(
     *         name="customer",
     *         in="path",
     *         description="customer id",
     *         required=true,
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             type="object",
     *            @OA\Property(property="first_name", type="string", example="John"),
     *            @OA\Property(property="last_name", type="string", example="Doe"),
     *            @OA\Property(property="date_of_birth", type="string", format="date", example="1990-01-01"),
     *            @OA\Property(property="phone_number", type="string", example="+18026872706"),
     *            @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *            @OA\Property(property="bank_account_number", type="string", example="NL10NGKK6133690858")
     *           )
     *          )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Customer updated successfully"
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Item not found"
     *     ),
     *
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     * )
     */
    public function update(int $customer_id, Request $request): JsonResponse
    {
        $customer = CustomerDTO::fromRequest($request, $customer_id);
        (new UpdateCustomerCommand($customer))->execute();
        return response()->json($customer);
    }

     /**
     * @OA\Delete(
     *     path="/api/customers/{customer}",
     *     tags={"customers"},
     *     summary="Deletes a customer",
     *     operationId="destroy",
     *     @OA\Parameter(
     *         name="customer",
     *         in="path",
     *         description="customer to delete",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer deleted successfully",
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="customer not found",
     *     ),
     * )
     */
    public function destroy(int $customer_id): JsonResponse
    {
        (new DestroyCustomerCommand($customer_id))->execute();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}