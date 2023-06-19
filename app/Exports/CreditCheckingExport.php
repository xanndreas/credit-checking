<?php

namespace App\Exports;

use App\Models\DealerInformation;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CreditCheckingExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(string $minDate, string $maxDate)
    {
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
    }

    public function query()
    {
        $dealerInformation = DealerInformation::with(['dealer', 'product', 'brand', 'insurance', 'tenors', 'debtor_information']);

        if (Gate::denies('credit_check_access_super')) {
            $dealerInformation->whereRelation('debtor_information.auto_planner_information', 'auto_planner_name_id', auth()->user()->id);
        }

        $dealerInformation
            ->get()
            ->filter(function ($query) {
                if (request()->has('minDate') && request()->has('maxDate')) {
                    $query->whereBetween('dealer_informations.created_at', [$this->minDate, $this->maxDate]);
                }
            });

        return $dealerInformation;
    }

    public function headings(): array
    {
        return [
            'Timestamp',
            'Email Address',
            'NAMA AUTO PLANNER',
            'Individu / Badan Usaha',
            'Nama Calon Debitur Individu/Badan Usaha',
            'Jenis Identitas',
            'Nomer Identitas Calon Debitur',
            'Nama Pasangan',
            'Nomer Identitas Pasangan',
            'Nama Penjamin',
            'Nomer Identitas Penjamin',
            'Nama Pemegang Saham / Pengurus',
            'Nomer Identitas Pemegang Saham / Pengurus',
            'Dealer',
            'Produk',
            'Brand',
            'Model (yang lengkap)',
            'Tahun Mobil',
            'Jumlah Unit',
            'OTR',
            'Pokok Hutang',
            'Asuransi',
            'Down Payment',
            'Tenor (tahun)',
            'ADDM / ADDB',
            'RATE (Bunga) Effective',
            'Nomer HP Calon Debitur',
            'REMARKS',
            'UPLOAD KTP, KK, NPWP, DLL',
            'Nama Pemegang Saham / Pengurus',
            'Nomer Identitas Pemegang Saham / Pengurus',
            'Nama Sales'
        ];
    }

    public function map($row): array
    {

        return [
            $row->created_at,
            $row->debtor_information->auto_planner_information->auto_planner_name->email,
            $row->debtor_information->auto_planner_information->auto_planner_name->name,
            $row->debtor_information->auto_planner_information->auto_planner_name->type,
            $row->debtor_information->debtor_name,
            $row->debtor_information->id_type,
            $row->debtor_information->id_number,
            $row->debtor_information->partner_name,
            null,
            $row->debtor_information->guarantor_name,
            $row->debtor_information->guarantor_id_number,
            $row->debtor_information->shareholders,
            $row->debtor_information->shareholder_id_number,
            $row->dealer->name,
            $row->product->name,
            $row->brand->name,
            $row->models,
            null,
            $row->number_of_units,
            $row->otr,
            $row->debt_principal,
            $row->insurance->name,
            $row->down_payment,
            $row->tenors->year,
            $row->addm_addb,
            $row->effective_rates,
            $row->debtor_phone,
            $row->remarks,
            null,
            $row->debtor_information->shareholders,
            $row->debtor_information->shareholder_id_number,
            $row->debtor_information->auto_planner_information->auto_planner_name->name
        ];
    }
}
