<?php

namespace Tests\Unit\Http\Repositories\DB;

use App\Http\Repositories\Links\DB\LinkRepository;
use App\Shared\Consts\Entities\LinkConsts;
use Tests\Unit\Http\Repositories\LinkRepositoryUnitTest as LinkRepositoryBaseUnitTest;

class LinkRepositoryUnitTest extends LinkRepositoryBaseUnitTest
{
    

    protected function getTableName()
    {
        return  LinkConsts::TABLE_NAME;
    }//end getTable()

    protected function getUnit()
    {
        return  new LinkRepository();
    } //end getUnit()


}//end class
