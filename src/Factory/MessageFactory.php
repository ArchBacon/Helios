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
        $company = $model->getCompany();
        if ($company === null)
        {
            throw new InvalidArgumentException('Property `company` should not be null.');
        }

        $username = $model->getUsername();
        if ($username === null)
        {
            throw new InvalidArgumentException('Property `username` should not be null.');
        }

        $email = $model->getEmail();
        if ($email === null)
        {
            throw new InvalidArgumentException('Property `email` should not be null.');
        }

        $message = $model->getMessage();
        if ($message === null)
        {
            throw new InvalidArgumentException('Property `message` should not be null. string expected');
        }

        return new Message($company, $username, $email, $message);
    }
}