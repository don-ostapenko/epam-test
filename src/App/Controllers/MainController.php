<?php

namespace App\Controllers;

use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;
use App\Models\Payrolls\Payroll;

class MainController extends AbstractController
{
    // Экшен для вывода данных ведомостей
    public function main()
    {
        $payrolls = Payroll::findAll();
        $this->view->renderHtml('main/main.php', [
            'payrolls' => $payrolls,
            'title' => 'Payrolls'
        ]);
    }

    // Экшен для создания ведомости
    public function create()
    {
        if (!empty($_POST)) {
            try {
                $payroll = Payroll::createPayroll($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('main/create.php', ['error' => $e->getMessage()]);
                return;
            }
            header('Location: /', true, 302);
            exit();
        }

        $this->view->renderHtml('main/create.php', [
            'title' => 'Create payroll'
        ]);
    }

    // Экшен для редактирования ведомости
    public function edit(int $payrollId)
    {
        $payroll = Payroll::getById($payrollId);
        if ($payroll === null) {
            throw new NotFoundException('Not found payroll for your id');
        }

        if (!empty($_POST)) {
            try {
                $payroll->updatePayroll($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('main/edit.php', [
                    'error' => $e->getMessage(),
                    'payroll' => $payroll,
                    'title' => 'Edit payroll'
                ]);
                return;
            }
            header('Location: /', true, 302);
            exit();
        }

        $this->view->renderHtml('main/edit.php', [
            'title' => 'Edit payroll',
            'payroll' => $payroll
        ]);
    }

    public function del(int $payrollId)
    {
        $payroll = Payroll::getById($payrollId);
        if ($payroll === null) {
            throw new NotFoundException('Not found payroll for your id');
        }
        $payroll->delete();
        $this->view->renderHtml('success/successDelete.php');
    }

    public function search()
    {
        if (!empty($_POST)) {
            $search = $_POST['search'];

            // Переводим строку в нижний регистр
            $searchToLowerCase = mb_strtolower($search, 'UTF-8');
            // Первая буква в верхний регистр
            $firstLetter = mb_strtoupper(mb_substr($searchToLowerCase, 0, 1, 'UTF-8'), 'UTF-8');
            // Берем все, что после первой буквы
            $otherString = mb_substr($searchToLowerCase, 1);
            // Склеиваем в результирующую строку
            $normalSearch = $firstLetter . $otherString;

            $payrolls = Payroll::findByName($normalSearch);
            if ($payrolls === null) {
                $this->view->renderHtml('search/noResultSearch.php', [
                    'title' => 'Result search'
                ]);
                exit();
            }
            $this->view->renderHtml('search/resultSearch.php', [
                'payrolls' => $payrolls,
                'title' => 'Result search'
            ]);
            return;
        }
        $payrolls = Payroll::findAll();
        $this->view->renderHtml('main/main.php', [
            'payrolls' => $payrolls,
            'title' => 'Payrolls'
        ]);
    }
}