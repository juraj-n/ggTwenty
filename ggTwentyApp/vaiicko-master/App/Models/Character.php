<?php

namespace App\Models;

use Framework\Core\Model;

class Character extends Model
{
    public ?int $id = null;
    protected ?int $user_id = null;
    protected string $name = '';
    protected int $hp = 0;
    protected int $ac = 0;
    protected int $current_hp = 0;
    protected ?string $image_url = '';

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUserId(): ?int
    {
        return $this->user_id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getHp(): int
    {
        return $this->hp;
    }
    public function getAc(): int
    {
        return $this->ac;
    }
    public function getCurrentHp(): int
    {
        return $this->current_hp;
    }
    public function getImageUrl(): string
    {
        return $this->image_url;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setHp(int $hp): void
    {
        $this->hp = $hp;
    }
    public function setAc(int $ac): void
    {
        $this->ac = $ac;
    }
    public function setCurrentHp(int $current_hp): void
    {
        $this->current_hp = $current_hp;
    }
    public function setImageUrl(?string $image_url): void
    {
        $this->image_url = $image_url;
    }
}