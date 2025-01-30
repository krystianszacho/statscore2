<?php

namespace Tests;

use App\Services\GildedRose;
use App\Models\Item;
use Faker\Factory as Faker;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Faker::create();
    }

    public function testNormalItemDegradesInQuality(): void
    {
        $sellIn = $this->faker->numberBetween(1, 10);
        $quality = $this->faker->numberBetween(1, 50);

        $item = new Item(
            $this->faker->word,
            $sellIn,
            $quality
        );

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $this->assertEquals($sellIn - 1, $item->sell_in);

        $expectedQuality = max(0, $quality - (($sellIn - 1 < 0) ? 2 : 1));
        $this->assertEquals($expectedQuality, $item->quality);
    }


    public function testAgedBrieIncreasesInQuality(): void
    {
        $item = new Item('Aged Brie', 10, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $this->assertGreaterThan(20, $item->quality);
        $this->assertLessThanOrEqual(50, $item->quality);
    }

    public function testBackstagePassesIncreaseInQuality(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 10, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $this->assertGreaterThan(20, $item->quality);
        $this->assertLessThanOrEqual(50, $item->quality);
    }

    public function testBackstagePassesDropToZeroAfterSellIn(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 0, 20);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $this->assertEquals(0, $item->quality);
    }

    public function testSulfurasNeverChanges(): void
    {
        $item = new Item('Sulfuras, Hand of Ragnaros', 10, 80);

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $this->assertEquals(10, $item->sell_in);
        $this->assertEquals(80, $item->quality);
    }

    public function testRandomItems(): void
    {
        $items = array_map(fn() => new Item(
            $this->faker->word,
            $this->faker->numberBetween(-5, 15),
            $this->faker->numberBetween(0, 50)
        ), range(1, 10));

        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        array_walk($items, function ($item) {
            $this->assertLessThanOrEqual(50, $item->quality);
            $this->assertGreaterThanOrEqual(0, $item->quality);
        });
    }
}
