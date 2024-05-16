@extends("projects::frontend.layouts.default")

@section('vaahcms_extend_frontend_head')

@endsection

@section('vaahcms_extend_frontend_css')

@endsection

@section('vaahcms_extend_frontend_scripts')
    @if(env('THEME_PROJECTS_ENV') == 'develop')
        <script  src="http://localhost:8051/main.js" defer></script>
    @else
        <script src="{{vh_theme_assets_url("Projects", "build/index.js")}}"></script>
    @endif
@endsection
{{--@section('vaahcms_extend_backend_js')--}}

{{--   --}}

{{--@endsection--}}
@section('content')

<div class="container has-text-centered mt-6">

{{--        <div class="notification is-link is-light">--}}
{{--            This is the home page when marked as home from the CMS menu--}}
{{--        </div>--}}

        <section class="hero">
            <div class="hero-body">
                <p class="title">Projects</p>

                <p class="subtitle">Home Page</p>

            </div>
        </section>

</div>
<div id="themeProjects">

    <Form></Form>
    <p>Theme Projects Environment: {{ env('THEME_PROJECTS_ENV') }}</p>

<VaahVueClickToCopy/>
{{--    <vue-progress-bar></vue-progress-bar>--}}
</div>
@endsection



