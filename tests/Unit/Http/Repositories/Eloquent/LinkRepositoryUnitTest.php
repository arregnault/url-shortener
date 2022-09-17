<?php

namespace Tests\Unit\Http\Repositories\Eloquent;

use App\Http\Repositories\Links\Eloquent\LinkRepository;
use App\Models\Link;
use Tests\Unit\Http\Repositories\LinkRepositoryUnitTest as LinkRepositoryBaseUnitTest;

class LinkRepositoryUnitTest extends LinkRepositoryBaseUnitTest
{


    protected function getTableName()
    {
        return  (new Link())->getTable();
    } //end getTable()

    protected function getUnit()
    {
        return  new LinkRepository(new Link());
    } //end getUnit()

}//end class
