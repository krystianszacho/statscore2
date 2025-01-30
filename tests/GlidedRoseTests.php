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
        $item = new Item(
            $this->faker->word,
            $this->faker->numberBetween(1, 10),
            $this->faker->numberBetween(1, 50)
        );

        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();

        $this->assertEquals($item->sell_in + 1, $item->sell_in);
        $this->assertLessThanOrEqual(50, $item->quality);
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
        $items = [];

        for ($i = 0; $i < 10; $i++) {
            $items[] = new Item(
                $this->faker->word,
                $this->faker->numberBetween(-5, 15),
                $this->faker->numberBetween(0, 50)
            );
        }

        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        foreach ($items as $item) {
            $this->assertLessThanOrEqual(50, $item->quality);
            $this->assertGreaterThanOrEqual(0, $item->quality);
        }
    }
}
