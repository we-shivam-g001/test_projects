<?php  namespace VaahCms\Modules\Project\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use VaahCms\Modules\Project\Models\Company;
use VaahCms\Modules\Project\Models\Contact;

class ExtendController extends Controller
{

    //----------------------------------------------------------
    private static $link;

    public function __construct()
    {
    }
    //----------------------------------------------------------
    public static function topLeftMenu()
    {
        $links = [];

        $response['success'] = true;
        $response['data'] = $links;

        return vh_response($response);

    }
    //----------------------------------------------------------
    public static function topRightUserMenu()
    {
        $links = [];

        $response['success'] = true;
        $response['data'] = $links;

        return vh_response($response);
    }
    //----------------------------------------------------------
    public static function sidebarMenu()
    {
        $links = [];


        $links[0] = [
            'icon' => 'table',
            'label'=> 'Project',
            'link'=> route('vh.backend.project'),
             'items'=>[
                 [
                 'icon' => 'shield',
                 'label'=> 'Products',
                 'link'=> route('vh.backend.project').'#/products'
                 ],
                 [
                 'icon' => 'shield',
                 'label'=> 'Companies',
                 'link'=> route('vh.backend.project').'#/companies'
             ],
                 [
                     'icon' => 'shield',
                     'label'=> 'Contacts',
                     'link'=> route('vh.backend.project').'#/contacts'
                 ]
             ]
        ];


        if(version_compare(config('vaahcms.version'), '2.0.0', '<' )){
            $links[0]['link'] = route('vh.backend.project');
        } else{
            $links[0]['url'] = route('vh.backend.project');
        }


        $response['success'] = true;
        $response['data'] = $links;

        return vh_response($response);
    }
    //----------------------------------------------------------
    public function getDashboardItems()
    {

        $data = array();

        $data['card'] = [
            "title" => "Contacts and Companies(Project Module)",
            "link_text"=>"view details",
            "list" => [

                [
                    "count" => Company::count(),
                    "label" => 'Total Company',
                    "icon" => "pi-shopping-bag",
                    "type" => "success",
                    "link" => self::$link."backend/project#/companies"
                ],
                [
                    "count" => Contact::count(),
                    "label" => 'Total Contacts',
                    "icon" => "pi-shopping-bag",
                    "type" => "success",
                    "link" =>  self::$link."backend/project#/contacts"
                ],
                [
                    "count" => Company::whereNull('is_active')
                    ->orWhere('is_active', 0)
                    ->count(),
                    "label" => 'Inactive Company',
                    "icon" => "pi-shopping-bag",
                    "type" => "success",
                    "link" =>  self::$link."backend/project#/companies"
                ],
            ],
        ];

        $data['actions'] = [
            [
                'name' => 'Manage your Companies',
                'icon' => 'pi-shopping-bag',
                "link" =>  self::$link."backend/project#/companies"
            ],
        ];

        $data['expanded_item'] = [
            [
                'title' => 'Product',
                'type' => 'content',
                'description' => 'Tasks that is kept in the queue to be performed one after another.Queues allow you to defer the processing of a time',
            ],
        ];

        $response['success'] = true;
        $response['data'] = $data;
        return $response;
    }
}
