@extends("projects::frontend.layouts.default")

@section('vaahcms_extend_frontend_head')

@endsection

@section('vaahcms_extend_frontend_css')

@endsection

@section('vaahcms_extend_frontend_scripts')

@endsection
@section('vaahcms_extend_backend_js')
    @if(env('THEME_PROJECTS_ENV') == 'develop')
         <script src="http://localhost:8051/projects/assets/build/app.js" defer></script>
{{--        <script src="VaahCms/Themes/Projects/Vue/pages/projects/partials/ListTableJs.js"></script>--}}
    @else
        <script src="{{ vh_theme_assets_url("Projects", "build/app.js") }}"></script>
    @endif
@endsection
@section('content')
<h1>Projects</h1>
<p>Theme For Projects</p>


@endsection
