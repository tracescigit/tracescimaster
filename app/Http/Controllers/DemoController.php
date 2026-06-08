<?php

namespace App\Http\Controllers;

use App\Models\DemoSchedule;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $limit          = $request->input('size');
            $page           = $request->input('page');
            $search_field   = $request['filters'] ? $request['filters']['0']['field'] : '';
            $search_type    = $request['filters'] ? $request['filters']['0']['type'] : '';
            $search_value   = $request['filters'] ? $request['filters']['0']['value'] : '';
            $orderby        = $request['sorters'] ? $request['sorters']['0']['field'] : '';
            $order          = $orderby != "" ? $request['sorters']['0']['dir'] : "";

            $start_date = $request['filters'] ? $request['filters']['1']['value'] : '';
            $end_date = $request['filters'] ? $request['filters']['2']['value'] : '';

            $response       = DemoSchedule::getAdminUserModel($limit, $page, $orderby, $order, $search_field, $search_type, $search_value, $start_date, $end_date);

            if (!$response) {
                $demos      = [];
                $last_page  = 0;
                $total = 0;
            } else {
                $demos      = $response['response'];
                $last_page  = $response['last_page'];
                $total      = $response['total'];
            }

            $demoData = array();
            $i = 1;

            foreach ($demos as $demo) {
                $u['full_name']          = $demo->full_name ?? '--';
                $u['demo_date']         = date('M d, Y', strtotime($demo->demo_date)) ?? '-';
                $u['demo_time']         =  date('h:i A', strtotime($demo->demo_date)) ?? '-';
                $u['created_by']         = $demo->created_by ?? '--';
                $u['email']         = $demo->email ?? '--';
                $u['phone']        = $demo->phone ?? '--';
                $u['company_name']   =            $demo->company_name ?? '--';
                $u['company_email']   =            $demo->company_email ?? '--';
                $u['message']   =            $demo->message ?? '--';
                $u['status']   = $demo->status == 1 ? 'Active' : 'Inactive';
                $u['created_at']   =     date('M d, Y', strtotime($demo->created_at)) ?? '-';;

                $actions            = view('admin.demo.actions', ['id' => $demo->id]);
                $u['actions']       = $actions->render();

                $demoData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $demoData,
                "total" => $total
            ];

            return $return;
        }

        return view('admin.demo.index');
    }
    public function create()
    {
        // Build booked slots: ['2026-04-22' => ['09:00', '10:00'], ...]
        $bookedSlots = DemoSchedule::selectRaw('demo_date, GROUP_CONCAT(demo_time) as times')
            ->where('status', '!=', 3) // exclude cancelled
            ->groupBy('demo_date')
            ->get()
            ->mapWithKeys(fn($row) => [
                $row->demo_date => explode(',', $row->times)
            ]);
        return view('web.demo')->with('bookedSlots', $bookedSlots);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => [
                'required',
                'regex:/^[A-Za-z\s.\'-]+$/',
                'max:255'
            ],

            'email' => [
                'required',
                'email:rfc,dns',
                'max:255'
            ],

            'phone' => [
                'required',
                'digits:10'
            ],

            'company_name' => [
                'required',
                'string',
                'max:255'
            ],

            'company_email' => [
                'nullable',
                'email:rfc,dns',
                'max:255'
            ],

            'demo_date' => [
                'required',
                'date',
                'after_or_equal:today'
            ],

            'demo_time' => [
                'required',
                'in:09:00,10:00,11:00,14:00,15:00,16:00,17:00'
            ],

            'message' => [
                'nullable',
                'string',
                'max:1000'
            ],

        ]);

        // Check slot isn't already taken (race condition guard)
        $exists = DemoSchedule::where('demo_date', $validated['demo_date'])
            ->where('demo_time', $validated['demo_time'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'That slot is Already Taken. Please pick another time.'
            ], 422);
        }

        $demo = DemoSchedule::create($validated);

        return response()->json(['message' => 'Demo booked successfully.']);
    }
}
