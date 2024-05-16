<?php namespace VaahCms\Modules\Project\Http\Controllers\Backend;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use VaahCms\Modules\Project\Models\Company;

class BackendController extends Controller
{


    public function __construct()
    {

    }

    public function index(Request $request)
    {


        /**
         * Check user has permission else redirect
         */
        /*
        $permission_slug = 'has-access-project';
        if(!\Auth::user()->hasPermission($permission_slug))
        {
            $error_message = trans("vaahcms::messages.permission_denied");
            if(env('APP_DEBUG'))
            {
                $error_message .= ' Permission Slug: '.$permission_slug;
            }
            $response['errors'][] = $error_message;
            return redirect('vh.backend')->withErrors($response['errors']);
        }
        */


        return view('project::backend.pages.app');



    }

    public function getAssets(Request $request)
    {

        /**
         * Check user has permission else return permission denied error
         */

        /*
        $permission_slug = 'has-access-project';
        if(!\Auth::user()->hasPermission($permission_slug))
        {
            $response['success'] = false;
            $error_message = trans("vaahcms::messages.permission_denied");
            if(env('APP_DEBUG'))
            {
                $error_message .= ' Permission Slug: '.$permission_slug;
            }
            $response['errors'][] = $error_message;
            return vh_response($response);
        }
        */

        $data=[];

        $data['module'] = [
            'name' => config('project.name'),
            'version' => config('settings.global.project_version')??config('project.version'),
            'is_dev' => config('project.is_dev'),
            'copywrite_year'=> config('settings.global.copyright_year'),
        ];

        $v_version = config('vaahcms.version');

        if(env('VAAHCMS_VERSION')){
            $v_version = env('VAAHCMS_VERSION');
        }
        $data['language_strings']['advanced_layout'] = [
            "companies" => trans("vaahcms-projects.company_title"),
            "dashboard" =>  trans("vaahcms-projects.dashborad_title"),
            "contacts" => trans("vaahcms-projects.contacts_title")


        ];
        $data['versions'] = [
            'laravel_version' => Application::VERSION,
            'php_version' => PHP_VERSION,
            'vaahcms_version' => $v_version,
            'app_version' => config('app.version','0.0.1'),
        ];

        $data['server'] = [
            'host' => $request->getHost(),
            'current_year' => \Carbon::now()->format('Y'),
            'current_date' => \Carbon::now()->format('Y-m-d'),
            'current_time' => \Carbon::now()->format('H:i:s'),
            'current_date_time' => \Carbon::now()->format('Y-m-d H:i:s'),
            'http' => 'http://',
        ];

        $data['vaahcms'] = [
            'name' => config('vaahcms.app_name'),
            'slug' => config('vaahcms.app_slug'),
            'version' => $v_version,
            'website' => config('vaahcms.website'),
            'docs' => config('vaahcms.documentation'),
        ];
        $data['empty_item'] = Company::getEmptyItem();

        $data['timezone'] = env("APP_TIMEZONE");
        $data['server_date_time'] = \Carbon::now();

        $response['success'] = true;
        $response['data'] = $data;

        return vh_response($response);

    }

}
