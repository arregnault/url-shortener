<?php

namespace App\Http\Contracts\Repositories;

use App\Shared\Consts\Entities\LinkConsts;

interface LinkRepository
{


    /**
     * Create record at link DB table
     *
     * @param array $data Record data
     *
     * @return \App\Models\Link|object|static|null
     */
    public function createLink(array $data);


    /**
     * Delete record by id from links DB table
     *
     * @param string $primaryKey Record unique ID
     *
     * @return bool Deletion success
     */
    public function deleteLink($primaryKey): bool;


    /**
     * Get record by id from links DB table
     *
     * @param string $primaryKey Record unique ID
     *
     * @return \App\Models\Link|object|static|null
     */
    public function getLink($primaryKey);


    /**
     * Get record by code from links DB table
     *
     * @param string $code Record unique code
     *
     * @return \App\Models\Link|object|static|null
     */
    public function getLinkByCode($code);


    /**
     * Get record list from links DB table
     *
     * @param array  $filters   Filters
     * @param string $orderBy   Order by colunm name
     * @param bool   $orderType Order type (true: desc | false: asc)
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getLinkCollection(array $filters, string $orderBy=LinkConsts::CREATED_AT, bool $orderType=false);


    /**
     * Update record by id from links DB table
     *
     * @param string $primaryKey   Record unique ID
     * @param array  $data Record data
     *
     * @return \App\Models\Link|object|static|null
     */
    public function updateLink($primaryKey, array $data);


}//end interface
