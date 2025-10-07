<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Laravel 12 Swagger Demo",
 *     version="1.0.0",
 *     description="مستندات تست Swagger"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/users",
     *   summary="لیست کاربران",
     *   tags={"Users"},
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        description="for serach users optional",
     *        required=false,
     *        @OA\Schema (type="string" ,  example="جستجوی براساس نام کاربر")
     *   ),
     *        @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="for serach users optional",
     *         required=false,
     *         @OA\Schema (type="string" ,  example="جستجوی براساس ایمیل")
     *    ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       @OA\Property(property="status", type="boolean", example=true),
     *       @OA\Property(
     *         property="data", type="array",
     *         @OA\Items(
     *           @OA\Property(property="id", type="integer", example=1),
     *           @OA\Property(property="name", type="string", example="Amin"),
     *           @OA\Property(property="email", type="string", example="exmaple@gmai.com")
     *         )
     *       )
     *     )
     *   )
     * )
     */
    public function index(Request $request)
    {

       $query = User::query();

        $query->when($request , function($q) use ($request){
            return $q->where('name','like','%'.$request->name.'%');
         });
        $reuslt = $query->get();

        return response()->json(['status' => true, 'data' =>$reuslt]);
    }

    /**
     * @OA\Post(
     *   path="/api/users",
     *   summary="create users",
     *   tags={"Users"} ,
     *   @OA\RequestBody(
     *      required=true,
     *      description="add  new users",
     *      @OA\JsonContent(
     *          required={"name","email"},
     *            @OA\Property(property="name", type="string", example="Amin"),
     * *           @OA\Property(property="email", type="string", example="exmaple@gmai.com")
     *      )
     *   ),
     *   @OA\Response(
     *       response=200,
     *        description="add  new users",
     *     @OA\JsonContent(
     *        @OA\Property(property="name", type="string", example="Amin"),
     *        @OA\Property(property="email", type="string", example="exmaple@gmai.com"),

     *      )
     *   )
     * )
     *
     */
    public function store(Request $request)
    {

        $user = User::create([
            'name'=> $request['name'],
             'email' => $request['email'],

        ]);

        if($user){
            return response()->json(['status' => true, 'data' =>$user]);
        }
        return response()->json(['status' => false]);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
