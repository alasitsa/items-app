<?php

namespace App\Repositories\iface;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface IItemRepository
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param int $offset
     * @param int $count
     * @return Collection
     */
    public function getWithPagination(int $offset, int $count): Collection;

    /**
     * @param int $id
     * @return Item|null
     */
    public function get(int $id): ?Item;

    /**
     * @param Item $item
     * @return void
     */
    public function add(Item $item): void;

    /**
     * @param Item $item
     * @return void
     */
    public function edit(Item $item): void;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * @return int
     */
    public function count(): int;
}
