<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TicketUpdateRequest;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Auth;

class SupportController extends Controller
{
    public function getStatusText($status)
    {
        switch($status){
            case '1':
            $status_text = 'Closed';
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

            $response       = SupportTicket::getSupportTicketModel($limit, $page, $orderby, $order, $search_field , $search_type,null);

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
                $u['manufacturer']  = $ticket->getUser->name;
                $u['created_at']    = date('M d, Y',strtotime($ticket->created_at))??'-';
                $actions            = view('admin.support.actions',['id' => $ticket->id]);
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
        return view('admin.support.index');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $ticket = SupportTicket::find($id);
        $status = $this->getStatusText($ticket->status);
        return view('admin.support.edit')->with('ticket',$ticket)->with('status',$status)->with('page_name', 'admin-support');
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
            $ticket->status  = $input['status'];
            $ticket->save();

            return response(['message'=>'Ticket updated successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }
}
