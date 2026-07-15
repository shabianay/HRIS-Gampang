<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\PayrollSetting;
use App\Models\SalaryComponent;

class PayrollCalculationService
{
    private array $progressiveTaxBrackets = [
        ['limit' => 60000000, 'rate' => 0.05],
        ['limit' => 250000000, 'rate' => 0.15],
        ['limit' => 500000000, 'rate' => 0.25],
        ['limit' => 5000000000, 'rate' => 0.30],
        ['limit' => PHP_FLOAT_MAX, 'rate' => 0.35],
    ];

    public function calculateBpjsKesehatan(float $baseSalary): array
    {
        $rate = PayrollSetting::getDecimal('bpjs_kesehatan_employee_rate', 1) / 100;
        $maxBase = PayrollSetting::getDecimal('bpjs_kesehatan_max_base', 12000000);
        $effectiveBase = min($baseSalary, $maxBase);

        return [
            'employee' => round($effectiveBase * $rate, 2),
            'employer' => 0,
            'base' => $effectiveBase,
        ];
    }

    public function calculateBpjsKetenagakerjaan(float $baseSalary): array
    {
        $jhtRate = PayrollSetting::getDecimal('bpjs_jht_employee_rate', 2) / 100;
        $jpRate = PayrollSetting::getDecimal('bpjs_jp_employee_rate', 1) / 100;

        return [
            'jht_employee' => round($baseSalary * $jhtRate, 2),
            'jp_employee' => round($baseSalary * $jpRate, 2),
            'total_employee' => round($baseSalary * ($jhtRate + $jpRate), 2),
        ];
    }

    public function calculatePPh21(
        float $baseSalary,
        float $totalAllowance,
        string $ptkpStatus,
        string $period,
        int $employeeId
    ): float {
        $employee = Employee::find($employeeId);
        if (!$employee) return 0;

        $npwp = $employee->npwp;
        $hasNpwp = !empty($npwp);

        // Monthly gross income
        $grossMonthly = $baseSalary + $totalAllowance;

        // Monthly deductions: BPJS Kesehatan (employee) + BPJS Ketenagakerjaan (employee)
        $bpjsKes = $this->calculateBpjsKesehatan($baseSalary);
        $bpjsKt = $this->calculateBpjsKetenagakerjaan($baseSalary);
        $monthlyDeduction = $bpjsKes['employee'] + $bpjsKt['total_employee'];

        // Net monthly income
        $netMonthly = $grossMonthly - $monthlyDeduction;

        // Annualize
        $netAnnual = $netMonthly * 12;

        // PTKP
        $ptkp = PayrollSetting::getPTKP($ptkpStatus);

        // PKP (Penghasilan Kena Pajak)
        $pkp = max(0, $netAnnual - $ptkp);

        // Progressive tax
        $pphAnnual = $this->calculateProgressiveTax($pkp);

        // 20% higher if no NPWP
        if (!$hasNpwp) {
            $pphAnnual *= 1.2;
        }

        // Monthly PPh21
        $pphMonthly = round($pphAnnual / 12, 2);

        return max(0, $pphMonthly);
    }

    public function calculateAll(float $baseSalary, float $totalAllowance, string $ptkpStatus, string $period, int $employeeId): array
    {
        $bpjsKes = $this->calculateBpjsKesehatan($baseSalary);
        $bpjsKt = $this->calculateBpjsKetenagakerjaan($baseSalary);
        $pph21 = $this->calculatePPh21($baseSalary, $totalAllowance, $ptkpStatus, $period, $employeeId);

        return [
            'bpjs_kesehatan_employee' => $bpjsKes['employee'],
            'bpjs_ketenagakerjaan_employee' => $bpjsKt['total_employee'],
            'pph21' => $pph21,
        ];
    }

    private function calculateProgressiveTax(float $pkp): float
    {
        $tax = 0;
        $remaining = $pkp;
        $previousLimit = 0;

        foreach ($this->progressiveTaxBrackets as $bracket) {
            if ($remaining <= 0) break;

            $taxableInBracket = min($remaining, $bracket['limit'] - $previousLimit);
            $tax += $taxableInBracket * $bracket['rate'];
            $remaining -= $taxableInBracket;
            $previousLimit = $bracket['limit'];
        }

        return $tax;
    }

    public static function getPtkpStatuses(): array
    {
        return [
            'TK/0' => 'Tidak Kawin (0 tanggungan)',
            'TK/1' => 'Tidak Kawin (1 tanggungan)',
            'TK/2' => 'Tidak Kawin (2 tanggungan)',
            'TK/3' => 'Tidak Kawin (3 tanggungan)',
            'K/0' => 'Kawin (0 tanggungan)',
            'K/1' => 'Kawin (1 tanggungan)',
            'K/2' => 'Kawin (2 tanggungan)',
            'K/3' => 'Kawin (3 tanggungan)',
        ];
    }
}
