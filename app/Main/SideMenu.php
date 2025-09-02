<?php

namespace App\Main;
use App\Models\AggregationLevel;
use App\Models\Module;
use App\Models\Permission;
use Auth;
use Str;

class SideMenu
{
    /**
     * List of side menu items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function menu()
    {   
        $routes = [];

        if(!Auth::check()){
            return $routes;
        }

        $modules = Module::orderBy('menu_position','ASC')->where('type',Auth::user()->type)->get();

        if (count($modules)>0) {
            foreach ($modules as $key => $module) {

                $permission = Permission::where('user_id',Auth::id())->where('module_id',$module->id)->first();

                $route = [
                    'icon' => $module->icon,
                    'title'=> __($module->name),
                    'params' => [
                        'layout' => 'side-menu'
                    ],
                ];

                if ($module->has_sub_menu=='0') {
                    $route['route_name'] = $module->base_route;
                }

                if ($module->has_sub_menu=='1') {

                    $modify_routes = json_decode($module->modify_routes,true);

                    if($module->name=='Aggregations'){
                        $route['sub_menu'] = [];

                        array_push($route['sub_menu'],[
                            'icon' => '',
                            'title'=> 'All Aggregations',
                            'params' => [
                                'level'  => 'All',
                                'layout' => 'side-menu'
                            ],
                            'route_name' => $module->base_route
                        ]);

                        $levels = AggregationLevel::orderBy('level','ASC')->get();
                        foreach ($levels as $key => $level) {

                            $item = [
                                'icon' => '',
                                'title'=> $level->name,
                                'params' => [
                                    'level'  => Str::slug($level->name),
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => $module->base_route
                            ];

                            array_push($route['sub_menu'],$item);
                        }

                    }else{
                        $route['sub_menu'] = [
                            $module->slug.'primary' =>[
                                'icon' => '',
                                'title'=> __($module->name),
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => $module->base_route
                            ]
                        ];

                        if(Auth::user()->parent_id=='' || ($permission && $permission->modify=='1')){
                            $route['sub_menu'][$module->slug.'secondary'] = [
                                'icon' => '',
                                'title'=> ($module->slug=='manufacturers'?__('common.new'):__('common.create')).' '.__($module->name),
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => $modify_routes[0]
                            ];
                        }
                    }
                }


                if(Auth::user()->parent_id=='' || $permission ){
                    if((Auth::user()->type=='2' &&  Auth::user()->active=='1' && paymentReminder(Auth::id())['critical']==0) || $module->slug=="dashboard" || $module->slug=="my-invoices" || $module->slug=="profile" || Auth::user()->type=='1' || Auth::user()->type=='4')
                    {
                        array_push($routes,$route);
                    }
                    
                }
            }
        }

        return $routes;
    }
}
