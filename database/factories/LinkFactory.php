<?php

namespace Database\Factories;

use App\Models\Link;
use App\Shared\Consts\Entities\LinkConsts;
use App\Shared\Helpers\LinkHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string|null
     */
    protected $model = Link::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            LinkConsts::URL  => $this->faker->url(),
            LinkConsts::CODE => LinkHelper::generateCode(),
        ];

    }//end definition()


}//end class
