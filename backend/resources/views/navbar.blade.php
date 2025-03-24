<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">HealthTracker</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/calculators">Calculators</a>
                </li>
                @if(Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="/appointment">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/medications">Medications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/fitness">Fitness</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>