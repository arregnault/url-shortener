<?php

namespace App\Http\Services;

use App\Exceptions\RecordNotFoundException;
use App\Http\Contracts\Repositories\LinkRepository;
use App\Shared\Consts\Entities\LinkConsts;
use App\Shared\Helpers\LinkHelper;

class LinkService
{

    /**
     * Link repository instance
     *
     * @var \App\Http\Contracts\Repositories\LinkRepository
     */
    protected $repository;


    /**
     * LinkService constructor.
     *
     * @return void
     */
    public function __construct(LinkRepository $repository)
    {
        $this->repository = $repository;

    }//end __construct()


    public function createLink(array $data)
    {
        $data[LinkConsts::CODE] = LinkHelper::generateCode();
        return $this->repository->createLink($data);

    }//end createLink()


    public function deleteLink(string $id)
    {
        $recordToDelete = $this->repository->getLink($id);
        if (empty($recordToDelete)) {
            throw new RecordNotFoundException($id, "Link");
        }

        $this->repository->deleteLink($id);
        return $recordToDelete;

    }//end deleteLink()


    public function getLinkCollection(array $filters=[], ?string $orderBy=LinkConsts::CREATED_AT, $orderType=false)
    {
        $orderBy   = $orderBy ? $orderBy : LinkConsts::CREATED_AT;
        $orderType = filter_var($orderType, FILTER_VALIDATE_BOOL);
        return $this->repository->getLinkCollection($filters, $orderBy, $orderType);

    }//end getLinkCollection()


    public function getLink(string $id)
    {
        $recordToGet = $this->repository->getLink($id);
        if (empty($recordToGet)) {
            throw new RecordNotFoundException($id, "Link");
        }

        return $recordToGet;

    }//end getLink()


    public function redirectTotLink($code)
    {
        $link = $this->repository->getLinkByCode($code);
        return  LinkHelper::redirectTo($link);

    }//end redirectTotLink()


    public function updateLink(string $id, array $data)
    {
        $recordToUpdate = $this->repository->getLink($id);
        if (empty($recordToUpdate)) {
            throw new RecordNotFoundException($id, "Link");
        }

        $this->repository->updateLink($id, $data);
        
        return $this->repository->getLink($id);

    }//end updateLink()


}//end class
