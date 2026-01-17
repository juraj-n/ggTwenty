<?php
namespace App\Models;
use Framework\Core\Model;

class Token extends Model
{
    public ?int $id = null;
    protected ?int $enc_id = null;
    protected string $name = '';
    protected string $image_url = '';
    protected int $x = 0;
    protected int $y = 0;
    protected int $initiative = 0;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getEncId(): ?int
    {
        return $this->enc_id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getImageUrl(): string
    {
        return $this->image_url;
    }
    public function getX(): int
    {
        return $this->x;
    }
    public function getY(): int
    {
        return $this->y;
    }
    public function getInitiative(): int
    {
        return $this->initiative;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function setEncId(?int $enc_id): void
    {
        $this->enc_id = $enc_id;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setImageUrl(string $image_url): void
    {
        $this->image_url = $image_url;
    }
    public function setX(int $x): void
    {
        $this->x = $x;
    }
    public function setY(int $y): void
    {
        $this->y = $y;
    }
    public function setInitiative(int $initiative): void
    {
        $this->initiative = $initiative;
    }
}