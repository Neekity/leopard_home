<?php


namespace App\Http\Controllers;


class ApiController
{
    public function department()
    {
        return response()->json([
            'code' => '0',
            'data' => [
                [
                    'companyTitle'          => '钱升钱',
                    'departmentLevelFirst'  => '公共研发',
                    'departmentLevelSecond' => '快牛金科',
                    'departmentContract'    => '财务小组',
                    'level'                 => '1',
                ],
                [
                    'companyTitle'          => '乾升乾',
                    'departmentLevelFirst'  => '贷后',
                    'departmentLevelSecond' => '唯渡',
                    'departmentContract'    => '客户管理',
                    'level'                 => '2',
                ],
            ],
        ]);
    }
}