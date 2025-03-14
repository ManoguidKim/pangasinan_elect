<?php

namespace PowerComponents\LivewirePowerGrid\Components\SetUp;

use Livewire\Wireable;

final class Cache implements Wireable
{
    public string $name = 'cache';

    public bool $enabled = true;

    public string $tag = '';

    public int $ttl = 300;

    public string $prefix = '';

    public function disabled(): Cache
    {
        $this->enabled = false;

        return $this;
    }

    public function customTag(string $tag): Cache
    {
        $this->tag = $tag;

        return $this;
    }

    public function prefix(string $prefix): Cache
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function ttl(int $time): Cache
    {
        $this->ttl = $time;

        return $this;
    }

    public function toLivewire(): array
    {
        return (array) $this;
    }

    public static function fromLivewire($value)
    {
        return $value;
    }
}
