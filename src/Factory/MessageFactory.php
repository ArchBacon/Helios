<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Message;
use App\Entity\Model\MessageModel;
use InvalidArgumentException;

class MessageFactory
{
    public static function create(MessageModel $model): Message
    {
        $company = $model->getDomain();
        if ($company === null) {
            throw new InvalidArgumentException('Property `company` should not be null.');
        }

        $message = $model->getMessage();
        if ($message === null) {
            throw new InvalidArgumentException('Property `message` should not be null. string expected');
        }

        $createdAt = $model->getCreatedAt();
        if ($createdAt === null) {
            throw new InvalidArgumentException('Property `message` should not be null. string expected');
        }

        return new Message($company, $message, $createdAt);
    }

    public static function fromJson(string $json): Message
    {
        $contents = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        return new Message($contents['domain'], $contents['message'], null);
    }
}