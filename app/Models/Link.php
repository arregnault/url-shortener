<?php

namespace App\Models;

use App\Shared\Consts\{
    Data\DataTypeConsts,
    Entities\LinkConsts
};
use App\Shared\Traits\Models\Attributes\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use Uuid, HasFactory;

    /**
     * Database table name
     *
     * @var string
     */
    protected $table = LinkConsts::TABLE_NAME;

    /**
     * The attributes that should be dates.
     *
     * @var string[]
     */
    protected $dates = [
        LinkConsts::CREATED_AT,
        LinkConsts::UPDATED_AT,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        LinkConsts::CODE,
        LinkConsts::URL,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        LinkConsts::ID   => DataTypeConsts::STRING_TYPE,
        LinkConsts::CODE => DataTypeConsts::STRING_TYPE,
        LinkConsts::URL  => DataTypeConsts::STRING_TYPE,
    ];


    /**
     * Search records by text
     *
     * @param mixed   $query Eloquent Query
     * @param boolean $today Filter by today
     *
     * @return query $query Eloquent Query
     */
    public function scopeSearch($query, ?string $text)
    {
        if ($text != ''  && $text != null && is_string($text)) {
            $query->where(LinkConsts::URL, "like", "%{$text}%");
        }

    }//end scopeSearch()


}//end class
