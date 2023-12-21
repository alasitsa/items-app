<?php

namespace App\Repositories;

use App\Models\Item;
use App\Repositories\iface\IItemRepository;
use Illuminate\Database\Eloquent\Collection;

class ItemRepository implements IItemRepository
{

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Item::all();
    }

    /**
     * @param int $offset
     * @param int $count
     * @return Collection
     */
    public function getWithPagination(int $offset, int $count): Collection
    {
        return Item::query()->offset($offset)->limit($count)->get();
    }

    /**
     * @param int $id
     * @return Item|null
     */
    public function get(int $id): ?Item
    {
        return Item::find($id);
    }

    /**
     * @param Item $item
     * @return void
     */
    public function add(Item $item): void
    {
        $item->save();
    }

    /**
     * @param Item $item
     * @return void
     */
    public function edit(Item $item): void
    {
        $item->save();
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $item = Item::find($id);
        $item->delete($id);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return Item::all()->count();
    }
}
