<?php

namespace App\Observers;

use App\Models\Item;
use App\Repositories\iface\IItemRepository;
use Illuminate\Support\Facades\Cache;

class ItemObserver
{
    private IItemRepository $itemRepository;
    private const CACHE_KEY_PREFIX = 'items_page_';
    private const COUNT = 5;

    /**
     * @param IItemRepository $itemRepository
     */
    public function __construct(IItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @param Item $item
     * @return void
     */
    public function created(Item $item): void
    {
        $count = $this->itemRepository->count();
        Cache::forget(self::CACHE_KEY_PREFIX . $count / self::COUNT);
    }

    /**
     * @param Item $item
     * @return void
     */
    public function updated(Item $item): void
    {
        $this->handle($item->id);
    }

    /**
     * @param Item $item
     * @return void
     */
    public function deleted(Item $item): void
    {
        $this->handle($item->id);
    }

    /**
     * @param int $itemId
     * @return void
     */
    private function handle(int $itemId): void
    {
        $items = $this->itemRepository->getAll();
        $page = 1;
        $lastPage = $this->itemRepository->count() / self::COUNT;
        foreach (range($page, $lastPage) as $curPage) {
            Cache::forget(self::CACHE_KEY_PREFIX . $curPage);
        }
    }
}
