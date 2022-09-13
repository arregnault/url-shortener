<?php

namespace App\Http\Docs;

use Illuminate\Http\Request;
use App\Http\Requests\Links\StoreLinkRequest;
use App\Http\Requests\Links\UpdateLinkRequest;

/**
 * @OA\Schema(schema="StoreLinkRequest",
 *   
 *      @OA\Property(description="URL", property="url", type="string", example="https://google.com"),
 * ),
 * @OA\Schema(schema="UpdateLinkRequest",
 *      @OA\Property(description="URL", property="url", type="string", example="https://google.com"),
 * ),
 */
interface LinkController
{


    /**
     * @OA\Get(
     *     tags={"Links"},
     *     path="/api/links",
     *     summary="Get Links",
     *     description="Returns a list of links records",
     *     @OA\Parameter(ref="#/components/parameters/search"),
     *     @OA\Parameter(ref="#/components/parameters/orderBy"),
     *     @OA\Parameter(ref="#/components/parameters/orderType"),
     *     @OA\Response(response="500", ref="#/components/responses/5XX"),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Examples(example="LinkCollection", ref="#/components/examples/LinkCollection"),
     *              @OA\Examples(example="Empty", ref="#/components/examples/EmptyArray"),
     *          ),
     *     )
     * )
     */
    public function index(Request $request);



    /**
     * @OA\Get(
     *     tags={"Links"},
     *     path="/api/links/{id}",
     *     summary="Get Link",
     *     description="Return a particular link record",
     *     @OA\Parameter(ref="#/components/parameters/id"),
     *     @OA\Response(response="500", ref="#/components/responses/5XX"),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Examples(example="LinkResource", ref="#/components/examples/LinkResource"),
     *              @OA\Examples(example="Empty", ref="#/components/examples/Empty"),
     *          ),
     *     )
     * )
     */
    public function show(Request $request, $id);



    /**
     * @OA\Post(
     *     tags={"Links"},
     *     path="/api/links",
     *     summary="Create Link",
     *     description="Stores a link record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/StoreLinkRequest")
     *         )
     *     ),
     *     @OA\Response(response="404", ref="#/components/responses/record_not_found"),
     *     @OA\Response(response="422", ref="#/components/responses/validation_failure"),
     *     @OA\Response(response="500", ref="#/components/responses/5XX"),
     *     @OA\Response(
     *         response=201,
     *         description="OK",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Examples(example="LinkResource", ref="#/components/examples/LinkResource"),
     *          ),
     *     )
     * )
     */
    public function store(StoreLinkRequest $request);

    /**
     * @OA\Post(
     *     tags={"Links"},
     *     path="/api/links/{id}",
     *     summary="Update Link",
     *     description="Update a link record",
     *     @OA\Parameter(ref="#/components/parameters/_method"),
     *     @OA\Parameter(ref="#/components/parameters/id"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/UpdateLinkRequest")
     *         )
     *     ),
     *     @OA\Response(response="404", ref="#/components/responses/record_not_found"),
     *     @OA\Response(response="422", ref="#/components/responses/validation_failure"),
     *     @OA\Response(response="500", ref="#/components/responses/5XX"),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Examples(example="LinkResource", ref="#/components/examples/LinkResource"),
     *          ),
     *     )
     * )
     */
    public function update(UpdateLinkRequest $request, $id);



    /**
     * @OA\Delete(
     *     tags={"Links"},
     *     path="/api/links/{id}",
     *     summary="Delete Link",
     *     description="Delete a link record",
     *     @OA\Parameter(ref="#/components/parameters/id"),
     *     @OA\Response(response="404", ref="#/components/responses/record_not_found"),
     *     @OA\Response(response="500", ref="#/components/responses/5XX"),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Examples(example="LinkResource", ref="#/components/examples/LinkResource"),
     *          ),
     *     )
     * )
     */
    public function destroy($id);


    public function redirect($code);
}//end interface
