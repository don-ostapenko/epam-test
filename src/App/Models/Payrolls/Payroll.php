<?php

namespace App\Models\Payrolls;

use App\Models\ActiveRecordEntity;
use App\Exceptions\InvalidArgumentException;


class Payroll extends ActiveRecordEntity
{
    // Свойства
    /** @var string */
    protected $name;

    /** @var string */
    protected $department;

    /** @var int */
    protected $amount;

    /** @var int */
    protected $salary;


    // Сеттеры

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $department
     */
    public function setDepartment(string $department): void
    {
        $this->department = $department;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param int $salary
     */
    public function setSalary(int $salary): void
    {
        $this->salary = $salary;
    }


    // Геттеры

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getSalary(): int
    {
        return $this->salary;
    }

    protected static function getTableName(): string
    {
        return 'payrolls';
    }


    // Метод для создания новой ведомости
    public static function createPayroll(array $fields): Payroll
    {
        // Объявляем необходимые переменные
        $name = $fields['name'];
        $amount = abs($fields['amount']);
        $department = $fields['department'];

        if (empty($name)) {
            throw new InvalidArgumentException('Name is not entered');
        }

        if (!filter_var($name, FILTER_SANITIZE_STRING)) {
            throw new InvalidArgumentException('Name is incorrect');
        }

        if ($department == 'Choose...') {
            throw new InvalidArgumentException('Department is not chosen');
        }

        if (empty($amount)) {
            throw new InvalidArgumentException('Amount is not entered');
        }

        if (!filter_var($amount, FILTER_SANITIZE_NUMBER_INT)) {
            throw new InvalidArgumentException('Amount is incorrect');
        }

        // Переводим строку в нижний регистр
        $nameToLowerCase = mb_strtolower($name, 'UTF-8');
        // Первая буква в верхний регистр
        $firstLetter = mb_strtoupper(mb_substr($nameToLowerCase, 0, 1, 'UTF-8'), 'UTF-8');
        // Берем все, что после первой буквы
        $otherString = mb_substr($nameToLowerCase, 1);
        // Склеиваем в результирующую строку
        $normalName = $firstLetter . $otherString;

        // Проверяем, какой департамент был выбран и считаем по формуле доход
        if ($department == 'Mobile phones') {
            $salary = 500 * $amount * 0.15;
        } elseif ($department == 'TV sets') {
            $salary = 1000 * $amount * 0.15;
        } elseif ($department == 'Computers') {
            $salary = 1500 * $amount * 0.15;
        }

        $payroll = new Payroll();
        $payroll->setName($normalName);
        $payroll->setDepartment($department);
        $payroll->setAmount($amount);
        $payroll->setSalary((int)$salary);
        $payroll->save();
        return $payroll;
    }


    // Метод для редактирования платежной ведомости
    public function updatePayroll(array $fields): Payroll
    {
        // Объявляем необходимые переменные
        $name = $fields['name'];
        $amount = abs($fields['amount']);
        $department = $fields['department'];

        if (empty($name)) {
            throw new InvalidArgumentException('Name is not entered');
        }

        if (!filter_var($name, FILTER_SANITIZE_STRING)) {
            throw new InvalidArgumentException('Name is incorrect');
        }

        if (empty($amount)) {
            throw new InvalidArgumentException('Amount is not entered');
        }

        if (!filter_var($amount, FILTER_SANITIZE_NUMBER_INT)) {
            throw new InvalidArgumentException('Name is incorrect');
        }

        // Переводим строку в нижний регистр
        $nameToLowerCase = mb_strtolower($name, 'UTF-8');
        // Первая буква в верхний регистр
        $firstLetter = mb_strtoupper(mb_substr($nameToLowerCase, 0, 1, 'UTF-8'), 'UTF-8');
        // Берем все, что после первой буквы
        $otherString = mb_substr($nameToLowerCase, 1);
        // Склеиваем в результирующую строку
        $normalName = $firstLetter . $otherString;

        // Проверяем, какой департамент был выбран и считаем по формуле доход
        if ($department == 'Mobile phones') {
            $salary = 500 * $amount * 0.15;
        } elseif ($department == 'TV sets') {
            $salary = 1000 * $amount * 0.15;
        } elseif ($department == 'Computers') {
            $salary = 1500 * $amount * 0.15;
        }

        $this->setName($normalName);
        $this->setDepartment($department);
        $this->setAmount($amount);
        $this->setSalary((int)$salary);
        $this->save();
        return $this;
    }
}
