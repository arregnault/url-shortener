<?php

namespace App\Http\Repositories\Links\Eloquent;

use App\Http\Contracts\Repositories\LinkRepository as LinkRepositoryContract;
use App\Models\Link;
use App\Shared\Consts\Entities\LinkConsts;

class LinkRepository implements LinkRepositoryContract
{

    /**
     * Link model instance
     *
     * @var \App\Models\Link
     */
    protected $model;


    /**
     * LinkRepository constructor.
     *
     * @param \App\Models\Link $model
     *
     * @return void
     */
    public function __construct(Link $model)
    {
        $this->model = $model;

    }//end __construct()


    public function createLink(array $data)
    {
        $data = collect($data)->only([LinkConsts::CODE, LinkConsts::URL])->all();
        return $this->model::create($data);

    }//end createLink()


    public function deleteLink($primaryKey): bool
    {
        return $this->model::find($primaryKey)->delete();

    }//end deleteLink()


    public function getLink($primaryKey)
    {
        return $this->model::find($primaryKey);

    }//end getLink()


    public function getLinkByCode($code)
    {
        return $this->model::whereCode($code)->first();

    }//end getLinkByCode()


    public function getLinkCollection(array $filters=[], string $orderBy=LinkConsts::CREATED_AT, bool $orderType=false)
    {
        $search    = $filters['search'] ?? null;
        $orderType = $orderType ? 'desc' : 'asc';
        return $this->model::search($search)->orderBy($orderBy, $orderType)->get();

    }//end getLinkCollection()


    public function updateLink($primaryKey, array $data)
    {
        $data = collect($data)->only([LinkConsts::CODE, LinkConsts::URL])->all();
        return $this->model::find($primaryKey)->update($data);

    }//end updateLink()


}//end class
