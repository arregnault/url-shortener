<?php

namespace App\Http\Repositories\Links\DB;

use App\Http\Contracts\Repositories\LinkRepository as LinkRepositoryContract;
use App\Shared\Consts\Data\DateFormatConsts;
use App\Shared\Consts\Entities\LinkConsts;
use App\Shared\Helpers\UuidHelper;
use Illuminate\Support\Facades\DB;

class LinkRepository implements LinkRepositoryContract
{


    /**
     * Get Query builder from links DB table instance
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function query()
    {
        return DB::table(LinkConsts::TABLE_NAME);

    }//end query()


    public function createLink(array $data)
    {
        $data = collect($data)->only([LinkConsts::CODE, LinkConsts::URL])->all();
        $data[LinkConsts::ID]         = UuidHelper::generateUuidV4();
        $data[LinkConsts::CREATED_AT] = date(DateFormatConsts::DB_DATE_FORMAT);
        $data[LinkConsts::UPDATED_AT] = date(DateFormatConsts::DB_DATE_FORMAT);
        $this->query()->insert($data);
        return $this->query()->find($data[LinkConsts::ID]);

    }//end createLink()


    public function deleteLink($primaryKey): bool
    {
        return $this->query()->where(LinkConsts::ID, $primaryKey)->delete();

    }//end deleteLink()


    public function getLink($primaryKey)
    {
        return $this->query()->where(LinkConsts::ID, $primaryKey)->first();

    }//end getLink()


    public function getLinkByCode($code)
    {
        return $this->query()->whereCode($code)->first();

    }//end getLinkByCode()


    public function getLinkCollection(array $filters=[], string $orderBy=LinkConsts::CREATED_AT, bool $orderType=false)
    {
        $search    = $filters['search'] ?? null;
        $orderType = $orderType ? 'desc' : 'asc';
        return $this->query()->when(
            $search,
            function ($query, $search) {
                $query->where(LinkConsts::URL, "like", "%{$search}%");
            }
        )
        ->orderBy($orderBy, $orderType)->get();

    }//end getLinkCollection()


    public function updateLink($primaryKey, array $data)
    {
        $data = collect($data)->only([LinkConsts::CODE, LinkConsts::URL])->all();
        $data[LinkConsts::UPDATED_AT] = date(DateFormatConsts::DB_DATE_FORMAT);
        return $this->query()->where(LinkConsts::ID, $primaryKey)->update($data);

    }//end updateLink()


}//end class
