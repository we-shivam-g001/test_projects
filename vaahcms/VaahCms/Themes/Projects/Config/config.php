<?php

return [
    "name"=> "Projects",
    "title"=> "Theme For Projects",
    "slug"=> "projects",
    "thumbnail"=> "https://img.site/p/300/160",
    "is_dev" => env('THEME_PROJECTS_ENV')?true:false,
    "excerpt"=> "Theme For Projects",
    "description"=> "Theme For Projects",
    "download_link"=> "",
    "author_name"=> "projects",
    "author_website"=> "https://vaah.dev",
    "version"=> "v0.0.1",
    "is_migratable"=> true,
    "is_sample_data_available"=> false,
    "db_table_prefix"=> "vh_projects_",
    "providers"=> [
        "\\VaahCms\\Themes\\Projects\\Providers\\ProjectsServiceProvider"
    ],
    "aside-menu-order"=> null
];
