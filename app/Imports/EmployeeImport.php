<?php

namespace App\Imports;

use App\Models\Designation;
use App\Models\Employee;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

// Correctly import the Carbon class

class EmployeeImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        // Check if $row is an array, otherwise exit
        if (!is_array($row)) {
            Log::warning('Invalid row format: not an array', ['row' => $row]);
            return null;
        }

        // Ensure 'pdbee' is not null or empty, otherwise skip the row
        if (empty($row['nam'])) {
            Log::info("Skipping row due to missing 'pdbee' value: ", $row);
            return null; // Exit and skip this row
        }

        $joiningDate = null;
        $prlDate = null;

        // Function to convert various date formats into Y-m-d
        $convertToDate = function ($dateString) {
            $dateString = trim($dateString);

            if (is_numeric($dateString)) {
                return Carbon::createFromTimestamp(($dateString - 25569) * 86400)->format('Y-m-d');
            }

            $formats = [
                'd/m/Y', 'd.m.Y', 'd-m-Y', 'd-M-Y', 'Y-m-d', 'd M Y', 'M d, Y',
                'd-M-y', 'j-M-Y', 'j-n-Y', 'Y/m/d',
            ];

            foreach ($formats as $format) {
                try {
                    $date = Carbon::createFromFormat($format, $dateString);
                    if ($date && $date->format($format) === $dateString) {
                        return $date->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            return null;
        };

        $designationName = trim($row['pdbee']);
        $divisionName = trim($row['bivag_sakha_a_ka'] ?? '');
        $division = null;
        if (!empty($divisionName)) {
            $division = Section::firstOrCreate([
                'section_name' => $divisionName,
            ], [
                'created_by' => auth()->user()->id,
            ]);
        } else {
            Log::warning('Empty division name for row: ', $row);
        }

        // Check if a Designation with the same name and section_id already exists in the given section
        $designation = Designation::where('name', $designationName)
            ->where('section_id', $division ? $division->id : null)
            ->first();

        if (!$designation) {
            // Create the Designation if it doesn't exist with the same name and section_id
            $designation = Designation::create([
                'name' => $designationName,
                'section_id' => $division ? $division->id : null,
                'created_by' => auth()->user()->id,
            ]);
        }

        $joiningDate = !empty($row['zogdaner_tarikh']) ? $convertToDate($row['zogdaner_tarikh']) : null;
        $prlDate = !empty($row['piarel_tarikh']) ? $convertToDate($row['piarel_tarikh']) : null;

        $employee = new Employee([
            'name' => $row['nam'] ?? null,
            'mobile_no' => $row['mobail'] ?? null,
            'email' => $row['i_meil'] ?? null,
            'office_id' => $row['ofis_aidi'] ?? null,
            'nid' => $row['enaidi_smart_aidi'] ?? null,
            'blood_group' => $row['blad_grup'] ?? null,
            'joining_date' => $joiningDate,
            'prl_date' => $prlDate,
            'created_by' => auth()->user()->id,
        ]);

        if ($designation) {
            $employee->designation()->associate($designation);
        }

        if ($division) {
            $employee->section()->associate($division);
        }

        $employee->save();

        DB::commit();

        return $employee;
    }

}
