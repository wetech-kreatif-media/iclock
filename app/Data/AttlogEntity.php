<?php

namespace App\Data;

class AttlogEntity
{
    public function __construct(
        public int    $id,
        public string $userId,
        public string $sn,
        public string $status,
        public string $date,
        public int    $upload
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getSn(): string
    {
        return $this->sn;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getUpload(): int
    {
        return $this->upload;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function setSn(string $sn): void
    {
        $this->sn = $sn;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function setUpload(int $upload): void
    {
        $this->upload = $upload;
    }

    public function getDataArray(): array
    {
        return [
            'user_id' => $this->userId,
            'sn' => $this->sn,
            'status' => $this->status,
            'date' => $this->date,
            'upload' => $this->upload
        ];
    }
}
