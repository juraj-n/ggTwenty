<?php
namespace App\Models;
use Framework\Core\Model;

class Encounter extends Model
{
    public ?int $id = null;
    protected ?int $dm_id = null;
    protected string $code = '';
    protected int $current = 0;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getDmId(): ?int
    {
        return $this->dm_id;
    }
    public function getCode(): string
    {
        return $this->code;
    }
    public function getCurrent(): int
    {
        return $this->current;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function setDmId(?int $dm_id): void
    {
        $this->dm_id = $dm_id;
    }
    public function setCode(string $code): void
    {
        $this->code = $code;
    }
    public function setCurrent(int $current): void
    {
        $this->current = $current;
    }
}
