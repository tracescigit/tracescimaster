<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
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

            $response       = Blog::getAdminUserModel($limit, $page, $orderby, $order, $search_field, $search_type, $search_value, $start_date, $end_date);

            if (!$response) {
                $blogs      = [];
                $last_page  = 0;
                $total = 0;
            } else {
                $blogs      = $response['response'];
                $last_page  = $response['last_page'];
                $total      = $response['total'];
            }

            $BlogsData = array();
            $i = 1;

            foreach ($blogs as $blog) {
                $u['title']          = $blog->title ?? '--';
                $u['publish_date']         = date('M d, Y', strtotime($blog->publish_date)) ?? '-';
                $u['created_by']         = $blog->created_by ?? '--';
                $u['publish_by']         = $blog->publish_by ?? '--';
                $u['description']        = $blog->description ?? '--';
                $u['image']   =            $blog->image_path ?? '--';
                $u['is_allowed']   =      $blog->is_allowed == 1 ? 'Yes' : 'No';
                $u['status']   = $blog->status == 1 ? 'Active' : 'Inactive';
                $u['created_at']   =     date('M d, Y', strtotime($blog->created_at)) ?? '-';;

                $actions            = view('admin.blogs.actions', ['id' => $blog->id]);
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

        return view('admin.blogs.index');
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        try {
            $input = $request->all();

            $blog = new Blog();
            $blog->title = $input['title'];
            $blog->publish_date = $input['publish_date'];
            $blog->publish_by = $input['publish_by'];
            $blog->is_allowed = $input['allowed'] ?? 0;
            $blog->description = $input['description'];
            $blog->status = $input['status'] ?? 0;
            $blog->created_by = Auth::user()->parent_id ?? Auth::id();

            if ($request->hasFile('blog_img')) {
                $file = $request->file('blog_img');
                $filename = 'blog_image_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                $filepath = $file->storeAs('blogs/images', $filename, 'public');
                $blog->image_path = $filepath;
            }

            $blog->save();

            return response(['message' => 'Blog created successfully.'], 201);
        } catch (Exception $e) {
            return response(['message' => 'Something went wrong.'], 503);
        }
    }
    public function edit($id)
    {
        $id = decrypt($id);
        $blog = Blog::find($id);
        return view('admin.blogs.edit')->with('blog', $blog);
    }
}
