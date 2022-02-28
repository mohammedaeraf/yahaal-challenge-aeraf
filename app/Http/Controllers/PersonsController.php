<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/*
 * Controller class for Persons
 * Has method to retreive persons data from mock.txt file
 * */

class PersonsController extends Controller
{
    /**
     * Gets a listing of Persons.
     *
     * returns Array of JSON objects
     */
    public function index(): array
    {
        $file = File::get(storage_path('database\mock.txt'));

        $personDataRows = explode(PHP_EOL, $file);

        $colHeadingsRow = array_shift($personDataRows);  // extract the first row that contains the column heading

        $colHeadings = explode(',', $colHeadingsRow);   // get column headings in an array

        return array_map(
            static function ($personDataRow) use ($colHeadings) {
                if ($personDataRow === '') {
                    return false;
                }

                $personData = explode(',', $personDataRow);

                // associative array with keys as column headings and value as person data
                return [
                    $colHeadings[0] => $personData[0],
                    $colHeadings[1] => $personData[1],
                    $colHeadings[2] => $personData[2],
                    $colHeadings[3] => $personData[3],
                    $colHeadings[4] => $personData[4],
                    $colHeadings[5] => $personData[5]
                ];
            },
            $personDataRows
        );
    }
}
