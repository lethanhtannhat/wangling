<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Google2FAController extends Controller
{
    public function index()
    {
        if (!config('features.google_2fa')) {
            abort(404);
        }

        $results = DB::table('google_2fa_reports')
            ->orderBy('id', 'asc')
            ->get();

        return view('google2fa.index', compact('results'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        
        $header = fgetcsv($handle);
        $emailIndex = -1;
        $statusIndex = -1;

        foreach ($header as $index => $label) {
            if (trim($label) === 'Email Address [Required]') {
                $emailIndex = $index;
            }
            if (trim($label) === '2sv Enrolled [READ ONLY]') {
                $statusIndex = $index;
            }
        }

        if ($emailIndex === -1 || $statusIndex === -1) {
            fclose($handle);
            return back()->with('error', 'Required columns not found in CSV.');
        }

        // Clear previous report
        DB::table('google_2fa_reports')->truncate();

        $updatedCount = 0;
        $insertData = [];

        while (($row = fgetcsv($handle)) !== false) {
            $email = $row[$emailIndex] ?? null;
            $status = $row[$statusIndex] ?? null;

            if ($email) {
                // Persist to report table (for the persistent HTML table)
                $insertData[] = [
                    'email' => $email,
                    'status' => $status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Sync with Employee table
                Employee::where('email', $email)->update(['google_2fa_status' => $status]);
                $updatedCount++;
            }
        }

        // Batch insert for performance
        if (!empty($insertData)) {
            DB::table('google_2fa_reports')->insert($insertData);
        }

        fclose($handle);

        return redirect()->route('google2fa.index')->with('success', "Processed $updatedCount rows. The list below shows the extracted data.");
    }
}
