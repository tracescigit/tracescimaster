<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\TicketCreateRequest;
use App\Http\Requests\Vendor\TicketUpdateRequest;
use App\Models\SupportTicket;
use Auth;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function getStatusText($status)
    {
        switch($status){
            case '1':
            $status_text = 'Resolved';
            break;
            case '2':
            $status_text = 'Rejected';
            break;
            case '3':
            $status_text = 'Reopened';
            break;
            default:
            $status_text = 'Open';
        }

        return $status_text;
    }

    public function index(Request $request)
    {

        if($request->ajax())
        {   
            $limit          = $request->input('size');
            $page           = $request->input('page');
            $search_field   = $request['filters']?$request['filters']['0']['field']:'';
            $search_type    = $request['filters']?$request['filters']['0']['type']:'';
            $search_value   = $request['filters']?$request['filters']['0']['value']:'';
            $orderby        = $request['sorters']?$request['sorters']['0']['field']:'';         
            $order          = $orderby != "" ? $request['sorters']['0']['dir'] : "";

            $response       = SupportTicket::getSupportTicketModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, Auth::id());

            if(!$response){
                $tickets      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $tickets      = $response['response'];
                $last_page     = $response['last_page'];
                $total     = $response['total'];
            }

            $ticketData = array();
            $i = 1;

            foreach ($tickets as $ticket) {
                $u['id']            = $ticket->id??'-';
                $u['status']        = $this->getStatusText($ticket->status);
                $u['subject']       = $ticket->subject??'-';
                $u['created_at']    = date('M d, Y',strtotime($ticket->created_at))??'-';
                $actions            = view('vendor.support.actions',['id' => $ticket->id]);
                $u['actions']       = $actions->render();
                $ticketData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $ticketData,
                "total"             =>  $total
            ];
            
            return $return;
        }
        return view('vendor.support.index');
    }

    public function create()
    {   
        return view('vendor.support.create'); 
    }

    public function store(TicketCreateRequest $request)
    {
        try{
            $input   = $request->all();
            $ticket  = new SupportTicket;
            $ticket->subject = $input['subject'];
            $ticket->user_id = Auth::user()->parent_id??Auth::id();
            $content = [];
            $child = array(
                'message'=>$input['message'],
                'created_by'=>Auth::user()->name,
                'time'=>date('M d Y, h:i a',strtotime('now'))
            );
            array_push($content,$child);
            $ticket->content = json_encode($content);
            $ticket->save();

            return response(['message'=>'Ticket created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $ticket = SupportTicket::find($id);
        $status = $this->getStatusText($ticket->status);
        return view('vendor.support.edit')->with('ticket',$ticket)->with('status',$status)->with('page_name', 'vendor-support');
    }


    public function update(TicketUpdateRequest $request ,$id)
    {
        try{
            $id = decrypt($id);

            $input   = $request->all();
            $ticket = SupportTicket::find($id);

            $content = json_decode($ticket->content,true);

            $child = array(
                'message'=>$input['message'],
                'created_by'=>Auth::user()->name,
                'time'=>date('M d Y, h:i a',strtotime('now'))
            );
            array_push($content,$child);

            $ticket->content = json_encode($content);

            if($ticket->status!='0' && $input['message']!=''){
                $ticket->status = '3';
            }

            $ticket->save();

            return response(['message'=>'Ticket updated successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }



}
