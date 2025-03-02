<ul class="list-group">
	<a class="list-group-item list-group-item-action" href="{{ route('admission.dashboard') }}">Dashboard</a>
	<a class="list-group-item list-group-item-action" href="{{ route('admission.formfilup') }}">Form Filup</a>
	<a class="list-group-item list-group-item-action" href="{{ route('admission.form_show') }}">Admit Card</a>
	<a class="list-group-item list-group-item-action" href="{{ route('admission.payment') }}">Payment</a>
	<a class="list-group-item list-group-item-action" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{ route('admission.logout') }}">Logout</a>
	{{-- <a class="list-group-item list-group-item-action" href="{{ route('admission.result') }}">Result</a> --}}
</ul>
<form method="POST" id="logout-form" class="d-none" action="{{ route('admission.logout') }}">
	@csrf
</form>
