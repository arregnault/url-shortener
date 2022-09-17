<?php

namespace Tests\Unit\Http\Repositories;

use App\Models\Link;
use App\Shared\Consts\Entities\LinkConsts;
use App\Shared\Consts\Tests\ValueConsts;
use Tests\TestCase;

abstract class LinkRepositoryUnitTest extends TestCase
{


    abstract protected function getTableName();
    abstract protected function getUnit();

    /**
     * Test set-up.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->unitRepository = $this->getUnit();
        $this->record         = null;
        $this->records        = collect([]);
        $this->table          = $this->getTableName();
    } //end setUp()


    public function testGetLinkCollection()
    {

        $this->records = Link::factory(random_int(3, 5))->create();
        $response      = $this->unitRepository->getLinkCollection([]);
        $this->assertCount($this->records->count(), $response);
        $this->assertEquals($this->records->first()->id, $response->first()->id);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID => $response->first()->id,
                LinkConsts::URL => $response->first()->url,
                LinkConsts::CODE => $response->first()->code,
            ]
        );
        $this->assertDatabaseCount($this->table, $this->records->count());
    } //end testGetLinkCollectionWhenPaginated()


    public function testGetLinkCollectionWhenSearch()
    {

        $this->records = Link::factory(random_int(3, 5))->create();
        $this->record  = $this->records->shuffle()->first();
        $response      = $this->unitRepository->getLinkCollection(['search' => $this->record->url]);
        $this->assertCount(1, $response);
        $this->assertEquals($this->record->id, $response->first()->id);
        $this->assertEquals($this->record->url, $response->first()->url);
        $this->assertEquals($this->record->code, $response->first()->code);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID => $response->first()->id,
                LinkConsts::URL => $response->first()->url,
                LinkConsts::CODE => $response->first()->code,
            ]
        );
        $this->assertDatabaseCount($this->table, $this->records->count());
    } //end testGetLinkCollectionWhenSearch()


    public function testGetLinkCollectionWhenOrderByAsc()
    {

        $this->records = Link::factory(random_int(3, 5))->create();
        $this->record  = $this->records->shuffle()->first();
        $this->record->id = ValueConsts::FIRST_ID;
        $this->record->save();
        $response      = $this->unitRepository->getLinkCollection([], LinkConsts::ID, false);
        $this->assertCount($this->records->count(), $response);
        $this->assertEquals($this->record->id, $response->first()->id);
        $this->assertEquals($this->record->url, $response->first()->url);
        $this->assertEquals($this->record->code, $response->first()->code);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID => $response->first()->id,
                LinkConsts::URL => $response->first()->url,
                LinkConsts::CODE => $response->first()->code,
            ]
        );
        $this->assertDatabaseCount($this->table, $this->records->count());
    } //end testGetLinkCollectionWhenOrderByAsc()

    public function testGetLinkCollectionWhenOrderByDesc()
    {

        $this->records = Link::factory(random_int(3, 5))->create();
        $this->record  = $this->records->shuffle()->first();
        $this->record->id = ValueConsts::LAST_ID;
        $this->record->save();
        $response      = $this->unitRepository->getLinkCollection([], LinkConsts::ID, true);
        $this->assertCount($this->records->count(), $response);
        $this->assertEquals($this->record->id, $response->first()->id);
        $this->assertEquals($this->record->url, $response->first()->url);
        $this->assertEquals($this->record->code, $response->first()->code);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID => $response->first()->id,
                LinkConsts::URL => $response->first()->url,
                LinkConsts::CODE => $response->first()->code,
            ]
        );
        $this->assertDatabaseCount($this->table, $this->records->count());
    } //end testGetLinkCollectionWhenOrderByDesc()


    public function testGetLinkById()
    {

        $this->record = Link::factory()->create();
        $response     = $this->unitRepository->getLink($this->record->id);
        $this->assertEquals($this->record->id, $response->id);
        $this->assertEquals($this->record->url, $response->url);
        $this->assertEquals($this->record->code, $response->code);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID => $response->id,
                LinkConsts::URL => $response->url,
                LinkConsts::CODE => $response->code,
            ]
        );
        $this->assertDatabaseCount($this->table, 1);
    } //end testGetLink()

    public function testGetLinkByCode()
    {

        $this->record = Link::factory()->create();
        $response     = $this->unitRepository->getLinkByCode($this->record->code);
        $this->assertEquals($this->record->id, $response->id);
        $this->assertEquals($this->record->url, $response->url);
        $this->assertEquals($this->record->code, $response->code);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID => $response->id,
                LinkConsts::URL => $response->url,
                LinkConsts::CODE => $response->code,
            ]
        );
        $this->assertDatabaseCount($this->table, 1);
    } //end testGetLinkByCode()

    public function testCreateLink()
    {
        $this->record = Link::factory()->make()->toArray();
        $response         = $this->unitRepository->createLink($this->record);
        $this->assertEquals($this->record[LinkConsts::URL], $response->url);
        $this->assertEquals($this->record[LinkConsts::CODE], $response->code);
        $this->assertDatabaseHas(
            $this->table,
            [
                LinkConsts::ID => $response->id,
                LinkConsts::URL => $response->url,
                LinkConsts::CODE => $response->code,
            ]
        );
        $this->assertDatabaseCount($this->table, 1);
    } //end testStoreLink()


    public function testUpdateLink()
    {
        $this->record = Link::factory()->create();
        $url = $this->faker->url();
        $response     = $this->unitRepository->updateLink($this->record->id, [LinkConsts::URL => $url]);
        $this->assertIsBool($response);
        $this->assertTrue($response);
        $this->assertDatabaseHas(
            $this->table,
            array_merge(
                $this->record->only([LinkConsts::ID, LinkConsts::URL, LinkConsts::CODE]),
                [LinkConsts::URL => $url]
            )
        );
        $this->assertDatabaseMissing($this->table, $this->record->only([LinkConsts::ID, LinkConsts::URL, LinkConsts::CODE]));
        $this->assertDatabaseCount($this->table, 1);
    } //end testUpdateLink()


    public function testDeleteLink()
    {
        $this->record = Link::factory()->create();
        $response     = $this->unitRepository->deleteLink($this->record->id);
        $this->assertIsBool($response);
        $this->assertTrue($response);
        $this->assertDatabaseMissing($this->table, $this->record->only([LinkConsts::ID, LinkConsts::URL, LinkConsts::CODE]));
        $this->assertDatabaseCount($this->table, 0);
    } //end testDeleteLink()




}//end class
