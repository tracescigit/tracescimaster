<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventController extends Controller
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

            $response       = Event::getAdminUserModel($limit, $page, $orderby, $order, $search_field, $search_type, $search_value, $start_date, $end_date);

            if (!$response) {
                $events      = [];
                $last_page  = 0;
                $total = 0;
            } else {
                $events      = $response['response'];
                $last_page  = $response['last_page'];
                $total      = $response['total'];
            }

            $BlogsData = array();
            $i = 1;

            foreach ($events as $event) {
                $u['name']          = $event->name ?? '--';
                $u['start_date']         = date('M d, Y', strtotime($event->start_date)) ?? '-';
                $u['end_date']         = date('M d, Y', strtotime($event->end_date)) ?? '-';;
                $u['address']         = $event->address ?? '--';
                $u['description']        = $event->description ?? '--';
                $u['city']        = $event->city ?? '--';
                $u['image']   =            $event->image_path ?? '--';
                $u['is_allowed']   =      $event->is_allowed == 1 ? 'Yes' : 'No';
                $u['status']   = $event->status == 1 ? 'Active' : 'Inactive';
                $u['created_at']   =     date('M d, Y', strtotime($event->created_at)) ?? '-';;

                $actions            = view('admin.events.actions', ['id' => $event->id]);
                $u['actions']       = $actions->render();

                $BlogsData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $BlogsData,
                "total" => $total
            ];

            return $return;
        }

        return view('admin.events.index');
    }
    public function create()
    {
        return view('admin.events.create');
    }
    public function store(Request $request)
    {
        try {
            $input = $request->all();

            $event = new Event();
            $event->name = $input['event_name'];
            $event->start_date = $input['start_date'];
            $event->end_date = $input['end_date'];
            $event->address = $input['address'];
            $event->city = $input['city'];
            $event->is_allowed = $input['allowed'] ?? 0;
            $event->description = $input['description'];
            $event->status = $input['status'] ?? 0;
            $event->created_by = Auth::user()->parent_id ?? Auth::id();


            if ($request->hasFile('event_img')) {
                $file = $request->file('event_img');
                $filename = 'event_image_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                $filepath = $file->storeAs('events/images', $filename, 'public');
                $event->image_path = $filepath;
            }

            $event->save();

            return response(['message' => 'Event created successfully.'], 201);
        } catch (Exception $e) {
            return response(['message' => 'Something went wrong.'], 503);
        }
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $event = Event::find($id);

        return view('admin.events.edit')->with('event', $event);
    }
    public function Update(Request $request, $id)
    {
        try {
            $id = decrypt($id);
            $input = $request->all();
            $event = Event::find($id);

            if ($event) {

                $event->name = $input['event_name'];
                $event->start_date = $input['start_date'];
                $event->end_date = $input['end_date'];
                $event->address = $input['address'];
                $event->city = $input['city'];
                $event->is_allowed = $input['allowed'] ?? 0;
                $event->description = $input['description'];
                $event->status = $input['status'] ?? 0;
                $event->created_by = Auth::user()->parent_id ?? Auth::id();


                if ($request->hasFile('event_img')) {
                    $file = $request->file('event_img');
                    $filename = 'event_image_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $filepath = $file->storeAs('events/images', $filename, 'public');
                    $event->image_path = $filepath;
                }

                $event->save();
            }
            return response(['message' => 'Event updated successfully.'], 200);
        } catch (Exception $e) {
            return response(['message' => 'Something went wrong.'], 503);
        }
    }
}
