    @extends("vaahcms::backend.vaahone.layouts.backend")

    @section('vaahcms_extend_backend_css')

    @endsection


    @section('vaahcms_extend_backend_js')

        @if(env('THEME_PROJECTS_ENV') == 'develop')
            <script  src="http://localhost:8051/projects/assets/build/app.js" defer></script>
        @else
            <script src="{{vh_theme_assets_url("Projects", "build/app.js")}}"></script>
        @endif

    @endsection

    @section('content')

        <div id="appProjects">
            <p>Theme Projects Environment: {{ env('THEME_PROJECTS_ENV') }}</p>
            <router-view></router-view>

            <vue-progress-bar></vue-progress-bar>

        </div>

    @endsection
