<div class="rheader">
    <h2 class="text-center m-0">{{ config('settings.siteTitle','') }}</h2>
    <p class="text-center m-0">{{ config('settings.siteAddress') }}</p>
    <p class="text-center m-0">Phone: {{ config('settings.sitePhone') }}, Email: {{ config('settings.siteEmail') }}</p>
    <h4 class="text-center m-0">{{ isset($title) ? $title : '' }}</h4>
    <hr/>
</div>