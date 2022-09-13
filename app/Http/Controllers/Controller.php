<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(title="URL Shortener API", description="Demo URL Shortener API", version="1.0")
 * 
 * 
 *   |--------------------------------------------------------------------------
 *   | Parameters
 *   |--------------------------------------------------------------------------
 *
 * @OA\Parameter(
 *    name="id", in="path",
 *    description="Identifier of the record",
 *    required=true, 
 *    @OA\Schema(type="string"),
 *    @OA\Examples(example="int", value="1", summary="An int value"),
 *    @OA\Examples(example="uuid", value="0006faf6-7a61-426c-9034-579f2cfcfa83", summary="An UUID value"),
 * ),
 * @OA\Parameter(
 *    name="search", in="query",
 *    description="Search text",
 *    required=false,
 *    @OA\Schema(type="string")
 * ),
 * @OA\Parameter(
 *      name="orderBy", in="query",
 *      description="Field name that sorts the records.",
 *      required=false,
 *      @OA\Schema(type="string"),
 *      @OA\Examples(example="id", value="id", summary="By Identifier"),
 *      @OA\Examples(example="created_at", value="created_at", summary="By Date of creation"),
 *      @OA\Examples(example="updated_at", value="0", summary="By Date of last update"),
 * ),
 * @OA\Parameter(
 *      name="orderType", in="query",
 *      description="Sort type  <br>- `1`: Descending <br>- `0`: Ascending <br>- `desc`: Descending <br>- `asc`: Ascending",
 *      required=false,
 *      @OA\Examples(example="true", value="1", summary="Descending with bool/int value"),
 *      @OA\Examples(example="desc", value="desc", summary="Descending with string value"),
 *      @OA\Examples(example="false", value="0", summary="Ascending with bool/int value"),
 *      @OA\Examples(example="asc", value="asc", summary="Ascending with string value"),
 * ),
 * @OA\Parameter(
 *      name="_method", in="query",
 *      description="PUT method declaration for multipart/form-data form support.",
 *      required=true, example="PUT",
 *      @OA\Schema(type="string", enum={"PUT"})
 * ),
 * 
 * 
 *   |--------------------------------------------------------------------------
 *   | Success Responses
 *   |--------------------------------------------------------------------------
 *
 * @OA\Response(response="record_deleted",
 *      description="Record deleted successfully.",
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(    
 *              @OA\Property(description="Response data.", property="data", type="string", example="Record deleted successfully.") 
 *          )
 *     )
 * ),
 * 
 * 
 *   |--------------------------------------------------------------------------
 *   | Error Responses
 *   |--------------------------------------------------------------------------
 *
 * @OA\Response(response="5XX", description="Unexpected Error",
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *              @OA\Property(description="Status", property="status", type="string", example="error"),
 *              @OA\Property(description="Message(s)", property="error", type="string", example="Unexpected error. Try later"),
 *              @OA\Property(description="Code", property="code", type="integer", example="500"),
 *          )
 *     )
 * ),
 * @OA\Response(response="validation_failure",
 *      description="Form validation failed. Please check the information and try again.",
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Examples(example="ValidationError", summary="Validation Error", value={"status": "error", "code": 422, "error": {"attribute": {"The attribute field is required."}},"message": {"The attribute field is required."}})
 *     )
 * ),
 * @OA\Response(response="record_not_found", description="Record not found",
 *      @OA\MediaType(mediaType="application/json",
 *          @OA\Schema(
 *              @OA\Property(description="Status", property="status", type="string", example="error"),
 *              @OA\Property(description="Message(s)", property="error", type="string", example="The record was not found"),
 *              @OA\Property(description="Code", property="code", type="integer", example="404"),
 *          )
 *     )
 * ),
 * 
 * 
 *   |--------------------------------------------------------------------------
 *   | Examples
 *   |--------------------------------------------------------------------------
 * @OA\Examples(example="EmptyArray", summary="Data Empty", value={"status": "success", "code": 200, "data": {}}),
 * @OA\Examples(example="Empty", summary="Data Empty", value={"status": "success", "code": 200, "data": null})
 * 
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
