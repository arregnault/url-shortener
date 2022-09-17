<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Docs\LinkController as LinkControllerDoc;
use App\Shared\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Links\StoreLinkRequest;
use App\Http\Requests\Links\UpdateLinkRequest;
use App\Http\Resources\Links\LinkCollection;
use App\Http\Resources\Links\LinkResource;
use App\Http\Services\LinkService;
use LDAP\Result;

class LinkController extends Controller implements LinkControllerDoc
{
    use HttpResponse;

    /**
     * LinkService instance.
     *
     * @var \App\Http\Services\LinkService
     */
    private $service;


    /**
     * LinkController constructor.
     *
     * @param \App\Http\Services\LinkService $service
     *
     * @return void
     */
    public function __construct(LinkService $service)
    {
        $this->service = $service;

    }//end __construct()


    /**
     * Display a listing of  Link.
     *
     * @param \App\Http\Requests\GetCollectionRequest $request Form request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters  = $request->only(["search"]);
        $response = $this->service->getLinkCollection($filters, $request->orderBy, $request->orderType);
        return $this->successResponse(new LinkCollection($response));

    }//end index()


    /**
     * Display the specified  Link.
     *
     * @param int $id Link ID
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data     = $request->only([]);
        $response = $this->service->getLink($id, $data);
        return $this->successResponse(new LinkResource($response));

    }//end show()


    /**
     * Store a newly created  Link.
     *
     * @param App\Http\Requests\Links\StoreLinkRequest $request Form request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLinkRequest $request)
    {
        $data     = $request->only(["url"]);
        $response = $this->service->createLink($data);
        return $this->successResponse(new LinkResource($response), Response::HTTP_CREATED);

    }//end store()


    /**
     * Update the specified  Link.
     *
     * @param App\Http\Requests\Links\UpdateLinkRequest $request Form request
     * @param int                                       $id      Link ID
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLinkRequest $request, $id)
    {
        $data     = $request->only(["url"]);
        $response = $this->service->updateLink($id, $data);
        return $this->successResponse(new LinkResource($response));

    }//end update()


    /**
     * Remove the specified  Link.
     *
     * @param int $id Link ID
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->service->deleteLink($id);
        return $this->successResponse(new LinkResource($response));

    }//end destroy()


    /**
     * Redirect to original url from link code
     *
     * @param string $code Link unique code
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect($code)
    {
        return $this->service->redirectTotLink($code);

    }//end redirect()


}//end class
